<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactFormMail;

class PageController extends Controller
{
    // Главная страница
    public function home()
    {
        return view('pages.home');
    }

    // О нас
    public function about()
    {
        return view('pages.about');
    }

    // Отзывы
    public function reviews()
    {
        return view('pages.reviews');
    }

    // Фото
    public function photos()
    {
        return view('pages.photos');
    }

    // Контакты
    public function contacts()
    {
        return view('pages.contacts');
    }

    public function delivery()
    {
        return view('pages.delivery');
    }

    public function quality()
    {
        return view('pages.quality');
    }

    public function parking()
    {
        return view('pages.parking');
    }

    public function developer()
    {
        return view('pages.developer');
    }

    public function storeContact(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string',
        'email' => 'required|email',
        'project_type' => 'required|string',
        'features' => 'required|string',
        'design_reference' => 'nullable|string',
        'budget' => 'nullable|string',
        'deadline' => 'nullable|string',
    ]);

    $message = "Новая заявка с сайта\n\n";
    $message .= "Имя: {$validated['name']}\n";
    $message .= "Email: {$validated['email']}\n";
    $message .= "Тип сайта: {$validated['project_type']}\n";
    $message .= "Функции: {$validated['features']}\n";
    $message .= "Дизайн/примеры: {$validated['design_reference']}\n";
    $message .= "Бюджет: {$validated['budget']}\n";
    $message .= "Сроки: {$validated['deadline']}\n";

// Отправляем письмо
Mail::to('sckirkin@yandex.ru')->send(new ContactFormMail(['text' => $messageText]));
    // Можно также сохранить в базу, если нужно
    // Contact::create($validated);

    return back()->with('success', 'Спасибо! Я свяжусь с вами в ближайшее время.');
    }
}