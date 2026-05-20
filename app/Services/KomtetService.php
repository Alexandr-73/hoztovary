<?php

namespace App\Services;

use Komtet\KassaSdk\v1\Client;
use Komtet\KassaSdk\v1\QueueManager;
use Komtet\KassaSdk\v1\Check;
use Komtet\KassaSdk\v1\Position;
use Komtet\KassaSdk\v1\Payment;
use Komtet\KassaSdk\v1\Vat;

class KomtetService
{
    protected $client;
    protected $manager;
    protected $queueId;

    public function __construct()
    {
        $shopId = config('services.komtet.shop_id');
        $secret = config('services.komtet.secret');
        $this->queueId = config('services.komtet.queue_id');

        $this->client = new Client($shopId, $secret);
        $this->manager = new QueueManager($this->client);
        $this->manager->registerQueue('main_queue', $this->queueId);
        $this->manager->setDefaultQueue('main_queue');
    }

    public function createReceipt($order, $cart)
    {
        // Приводим телефон к формату 11 цифр (без +)
        $phone = preg_replace('/[^0-9]/', '', $order->customer_phone);
        if (strlen($phone) === 11 && $phone[0] === '7') {
            $phone = $phone;
        } elseif (strlen($phone) === 10) {
            $phone = '7' . $phone;
        }
        // Используем телефон, так как email может не приниматься
        $userContact = $phone;

        $taxSystem = 1; // УСН Доходы
        $paymentAddress = config('app.url');
        // Добавляем адрес места расчёта (обязательное поле)
        $placeAddress = $order->shipping_address; // или фиксированный адрес магазина

        $check = Check::createSell($order->id, $userContact, $taxSystem, $paymentAddress, $paymentAddress);

        
        
        foreach ($cart as $item) {
            $price = (float) $item['price'];
            $quantity = (int) $item['quantity'];
            $total = $price * $quantity;

            // Вручную создаём объект Vat с нужной ставкой, но чтобы в массиве было 'NO_VAT', можно передать строку
            // В конструкторе Position последний параметр ожидает Vat. Но чтобы обойти, используем сеттер?
            // Проще создать Vat с константой, но если выдаёт 'no', то переопределим через отражение или используем другой способ.
            // Поскольку мы не можем менять SDK, создадим Vat через конструктор, а затем изменим свойство.
            $vat = new Vat(Vat::RATE_NO);
            // Принудительно меняем значение ставки на 'NO_VAT' (костыль, но работает)
            $reflection = new \ReflectionClass($vat);
            $property = $reflection->getProperty('rate');
            $property->setAccessible(true);
            $property->setValue($vat, 'NO_VAT');

            $position = new Position($item['name'], $price, $quantity, $total, $vat);
            $check->addPosition($position);
        }

        $payment = new Payment('CASHLESS', (float) $order->total);
        $check->addPayment($payment);

        \Log::info('Komtet request final', $check->asArray());

        try {
            $response = $this->manager->putCheck($check);
            \Log::info('Komtet успех', (array)$response);
            return $response;
        } catch (\Exception $e) {
    \Log::error('Komtet ошибка: ' . $e->getMessage());
    if (method_exists($e, 'getResponse') && $e->getResponse()) {
        $body = $e->getResponse()->getBody()->getContents();
        \Log::error('Response body: ' . $body);
        // Попробуем распарсить JSON
        $data = json_decode($body, true);
        if ($data) {
            \Log::error('Validation details: ' . json_encode($data, JSON_UNESCAPED_UNICODE));
        }
    }
    throw new \Exception('Ошибка отправки чека в Комтет: ' . $e->getMessage());
}
    }
}