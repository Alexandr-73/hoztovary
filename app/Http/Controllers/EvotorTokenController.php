<?php

// namespace App\Http\Controllers;

// use App\Models\EvotorToken;
// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Log;

// class EvotorTokenController extends Controller
// {
//     public function store(Request $request)
//     {
//         /**
//      * Принимает токен от Эвотора и сохраняет в БД.
//      *
//      * @param Request $request
//      * @return \Illuminate\Http\JsonResponse
//      */



//           // Логируем все входящие данные для отладки
//         Log::info('Запрос на получение токена от Эвотора:', $request->all());

//         // Валидируем данные (как указано в документации)
//         $validated = $request->validate([
//             'userId' => 'required|string',
//             'token' => 'required|string',
//         ]);

//         // Сохраняем или обновляем токен для данного user_id
//         EvotorToken::updateOrCreate(
//             ['user_id' => $validated['userId']],
//             [ 'token' => $validated['token'],
//                 // Если Эвотор передаёт срок действия, можно добавить поле expires_at
//                 'expires_at' => now()->addDays(30),
//             ]
//         );

//         // Обязательно возвращаем 200 OK – Эвотор ожидает именно такой ответ
//         return response()->json(['status' => 'success'], 200);
//     }
// }