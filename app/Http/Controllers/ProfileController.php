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

    $timeString = str_replace('-', ':', $datetimeParts[1]);
    return $timeString;
}

function isTimeExceeded($inputString, $minutesThreshold = 5)
{
    $timeStr = extractTime($inputString);
    if ($timeStr === null) {
        return "Некорректный формат строки";
    }

    $currentTime = new DateTime();
    $dateTimeString = $currentTime->format('Y-m-d') . ' ' . $timeStr;
    $startTime = DateTime::createFromFormat('Y-m-d H:i:s', $dateTimeString);

    if (!$startTime) {
        return "Ошибка при обработке времени";
    }

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
    public function update_user(Request $request)
    {
        $user = User::FindOrFail(Auth::user()->id);
        if ($request->hasFile('ava')) {
            $imageName = Str::random(32) . "." . $request->ava->getClientOriginalExtension();
            $user->update(['ava' => $imageName]);

            Storage::disk('public')->put($imageName, file_get_contents($request->ava));

            return response()->json(['data' => $user]);
        } else {
            return response()->json(['code' => 'uncomplited']);
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
                'exists:users,resetToken'
            ],
        ];
        $validator = Validator::make($request->all(), $rules, $messages = [
            'password' => 'Пароль должен содержать минимум 8 символов, а так же иметь 1 букву и 1 цифру',
            'token' => 'Токен должен совпадать с бд'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'code' => $validator->errors()
            ], 422);
        }

        if (isTimeExceeded($request->token)) {
            $userId = $request->user_id;
            User::where('id', $userId)->update(['password' => Hash::make($request->password), 'resetToken' => null]);
            return response()->json(["code" => "success"]);
        }
        return response()->json(["code" => "error"]);
    }


    public function ban(Request $request, $id)
    {
        $user = User::find($id);


        if ($user && $user->is_baned === 0) {
            Ban::create([
                'user_id' => $user->id,
                'reason' => $request->input('reason', 'Блокировка по решению администратора'),
                'admin_id' => Auth::user()->id,
                'ban_time' => now(),
                'unban_time' => $request->unban,
            ]);

            $user->is_baned = true;
            $ban_id = Ban::where("user_id", $user->id)->value("id");
            $user->ban_id = $ban_id;

            $user->save();
            return response()->json(["code" => 'ban success']);
        } elseif ($user && $user->is_baned === 1) {
            $user->is_baned = false;
            $user->ban_id = null;
            $user->save();
            Ban::where('user_id', $user->id)->delete();

            return response()->json(['code' => 'Unbundle']);
        } else {
            return response()->json(['code' => 'error']);
        }
    }

    public function info()
    {
        return response()->json(["data" => User::where('id', Auth::user()->id)->get()]);
    }

    public function reset_password(Request $request)
    {
        // $request->validate([
        //     'email' => 'required|email',
        // ], $request->all());

        $user = User::where('email', $request->email)->first();


        if (!$user) {
            return response()->json(['code' => 'error'], 404);
        }

        $token = Str::random(60) . "," . Carbon::now()->format('Y-m-d_H-i-s');


        User::where('email', $request->email)->update([
            'resetToken' => $token,
        ]);

        Mail::to($request->email)->send(new \App\Mail\ResetPassword($token, $user->email));

        return response()->json(['code' => 'success.'], 200);
    }
    public function post(Request $request)
    {
        return response()->json(["data" => post::where('user_id', Auth::user()->id)->get()]);
    }

    public function banReason(Request $request)
    {
        $reason = Ban::where('user_id', $request->id)->first();
        $AdminName = User::where('id', $reason->admin_id)->value("name");
        return response()->json([
            'NameAdmin' => $AdminName,
            'Reason' => $reason->reason,
            'UnbanTime' => $reason->unban_time,
            'BanTime' => $reason->ban_time
        ]);
    }

    public function index()
    {
        $userId = Auth::user()->id;
        $user = User::find($userId);

        if ($user) {
            return response()->json([
                'name' => $user->name,
                'email' => $user->email,
                'ava' => $user->ava,
            ]);
        } else {
            return response()->json(['code' => 'error'], 404);
        }
    }
}
