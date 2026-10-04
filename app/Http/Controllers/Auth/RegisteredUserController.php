<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\VerificationCodeMail;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class RegisteredUserController extends Controller
{
    public function create()
    {
        return view('auth.register');
    }

    // 1-qadam: ma'lumot + parolni olish, kod yuborish
    public function store(Request $request)
    {
        $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'surname'  => ['required', 'string', 'max:255'],
            'phone'    => ['required', 'string', 'max:20'],
            'email'    => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $code = rand(100000, 999999);

        Session::put('registration_data', [
            'name'     => $request->name,
            'surname'  => $request->surname,
            'phone'    => $request->phone,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'code'     => $code,
        ]);

        Mail::to($request->email)->send(new VerificationCodeMail($code));

        return redirect()->route('verify.form');
    }

    // 2-qadam: kod kiritish sahifasi
    public function verifyForm()
    {
        if (!Session::has('registration_data')) {
            return redirect()->route('register');
        }
        return view('auth.verify');
    }

    // 2-qadam: kodni tekshirish va akkaunt yaratish
    public function verifyCode(Request $request)
    {
        $request->validate(['code' => 'required']);

        $data = Session::get('registration_data');

        if (!$data || $request->code != $data['code']) {
            return back()->withErrors(['code' => 'Kod noto\'g\'ri. Qaytadan urinib ko\'ring.']);
        }

        $user = User::create([
            'name'        => $data['name'],
            'surname'     => $data['surname'],
            'phone'       => $data['phone'],
            'email'       => $data['email'],
            'password'    => $data['password'],
            'is_verified' => true,
        ]);

        Session::forget('registration_data');
Auth::login($user);

return redirect()->route('home'); // ← redirect('/') o'rniga shu
    }
}