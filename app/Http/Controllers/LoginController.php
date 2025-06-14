<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Testing\Fluent\Concerns\Has;

class LoginController extends Controller
{
    // login olma islemini burada gerceklestirecegiz
    // controller aracılığıyla Model ile bağlantı kurularak veritabanından veri alınır veya veritabanına veri gönderilir
    // son olarak controller bize cevap dondurur.

    public function login(Request $request)
    {
        // requestten donen degerler alir ardindan dogrulama yapilir
        // login olma islemi sadece email ve sifre degerleri ile alinir
        $request->validate([
            'email' => 'required|string',
            'password' => 'required'
        ]);

        // gelen degerler dogrulandiktan sonra bu kullanicinin veritabanindan cekilmesi:
        $employee = Employee::where('email', $request->email)->first();

        // $employee degiskeni ile calisan bilgileri bu degiskene atandi
        if (!$employee || !Hash::check($request->password, $employee->password)) {
            return response()->json([
                'error' => 'The provided credentials are incorrect.'], 401);
        }

        $token = $employee->createToken('auth_token')->plainTextToken; // her calisan icin bir token olusturulmali
        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'id' => $employee->id,
            'name' => $employee->name,
            'surname' => $employee->surname,
            'email' => $employee->email,
            'phone' => $employee->phone,
            'status' => $employee->status,
        ]);
    }

}
