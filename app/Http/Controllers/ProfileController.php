<?php

namespace App\Http\Controllers;

use Auth;
use Validator;

use App\Models\Ban;
use App\Models\User;
use App\Models\post;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Str;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Carbon;
use DateTime;

function extractTime($inputString)
{
    $parts = explode(',', $inputString);
    if (count($parts) < 2) {
        return null;
    }

    $datetimePart = $parts[1];
    $datetimeParts = explode('_', $datetimePart);
    if (count($datetimeParts) < 2) {
        return null;
    }

    // Время в формате "HH-MM-SS"
    $timeString = str_replace('-', ':', $datetimeParts[1]);
    return $timeString; // возвращает "11:43:48"
}

function isTimeExceeded($inputString, $minutesThreshold = 5)
{
    $timeStr = extractTime($inputString);
    if ($timeStr === null) {
        return "Некорректный формат строки";
    }

    $currentTime = new DateTime();
    // Создаем объект DateTime из извлеченного времени, предполагая сегодняшнюю дату
    $dateTimeString = $currentTime->format('Y-m-d') . ' ' . $timeStr;
    $startTime = DateTime::createFromFormat('Y-m-d H:i:s', $dateTimeString);

    if (!$startTime) {
        return "Ошибка при обработке времени";
    }

    // Разница в минутах
    $diffMinutes = $currentTime->getTimestamp() - $startTime->getTimestamp();
    $diffMinutes = abs($diffMinutes) / 60;

    if ($diffMinutes > $minutesThreshold) {
        return false;
    } else {
        return true;
    }
}


class ProfileController extends Controller
{
    //
    public function update_user(Request $request, $id)
    {
        $user = User::FindOrFail($id);
        if ($request->hasFile('ava')) {
            $imageName = Str::random(32) . "." . $request->ava->getClientOriginalExtension();
            $user->update(['ava' => $imageName]);

            Storage::disk('public')->put($imageName, file_get_contents($request->ava));

            return response()->json($user);
        } else {
            return response()->json('uncomplited');
        }
    }

    public function change_password(Request $request)
    {
        $rules = [
            'password' => [
                'required',
                'min:8',
                'regex:/^(?=.*[A-Za-z])(?=.*\d).+$/',
            ],
            'token' => [
                'required',
                'exists:users,password_resets' 
            ],
        ];
        $validator = Validator::make($request->all(), $rules, $messages = [
            'password' => 'Пароль должен содержать минимум 8 символов, а так же иметь 1 букву и 1 цифру',
            'token' => 'Токен должен совпадать с бд'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        if (isTimeExceeded($request->token)) {
            $userId = Auth::user()->id;
            User::where('id', $userId)->update(['password' => Hash::make($request->password),'password_resets'=>null]);
            return response()->json("Пароль изменен");
        }
        return response()->json("Время истекло");
    }


    public function ban(Request $request, $id)
    {
        $user = User::find($id);

        if ($user && $user->is_baned === 0) {
            Ban::create([
                'user_id' => $user->id,
                'content' => $request->input('content', 'Блокировка по решению администратора'),
                'admin_id' => Auth::user()->id,
                'ban_time' => now(),
                'unban_time' => $request->unban,
            ]);

            $user->is_baned = true;
            $ban_id = Ban::where("user_id", $user->id)->value("id");
            $user->ban_id = $ban_id;

            $user->save();
            return response()->json('ban success');
        } elseif ($user && $user->is_baned === 1) {
            $user->is_baned = false;
            $user->ban_id = null;
            $user->save();
            Ban::where('user_id', $user->id)->delete();

            return response()->json('Unbundle');
        } else {
            return response()->json('User not found');
        }
    }

    public function info()
    {
        return response()->json(["Users" => User::where('id', Auth::user()->id)->get()]);
    }

    public function sendResetLink(Request $request)
    {
        // $request->validate([
        //     'email' => 'required|email',
        // ], $request->all());

        $user = User::where('email', $request->email)->first();


        if (!$user) {
            return response()->json(['message' => 'Пользователь не найден'], 404);
        }

        $token = Str::random(60) . "," . Carbon::now()->format('Y-m-d_H-i-s');


        User::where('email', $request->email)->update([
            'password_resets' => $token,
        ]);

        // Отправляем письмо
        Mail::to("sasabirukov665@gmail.com")->send(new \App\Mail\ResetPassword($token, $user->email));

        return response()->json(['message' => 'Письмо с инструкциями отправлено.'], 200);
    }
    public function post(Request $request)
    {
        return response()->json(["Post" => post::where('user_id', Auth::user()->id)->get()]);
    }
}
