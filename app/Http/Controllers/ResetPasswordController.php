<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Notification;
use App\Notifications\ResetPassword;
use App\Models\User;

class ResetPasswordController extends Controller
{
    public function __construct()
    {
    }

    public function sendemail(Request $request)
    {
      $cekuser = User::where('username',$request->email)->first();
      if ($cekuser !=null) {
        Notification::route('mail',$request->email)->notify(new ResetPassword($cekuser));
      }else {
        return back()->with('notif', json_encode([
            'title' => "RESET PASSWORD",
            'text'  => "Data tidak ditemukan.",
            'type'  => "error"
        ]));
      }
      return back()->with('notif', json_encode([
          'title' => "RESET PASSWORD",
          'text'  => "Tautan untuk reset password telah dikirim melalui email.",
          'type'  => "success"
      ]));
    }

    public function newpassword($token)
    {
        $user = User::where('remember_token',$token)->first();
        if ($user != null) {
          return view('auth.newpassword',compact('user'));
        }
    }

    public function storepassword(Request $request)
    {
      User::where('id',$request->id)->update([
        'password' =>bcrypt($request->password)
      ]);
      return redirect('/')->with('notif', json_encode([
          'title' => "RESET PASSWORD",
          'text'  => "Password berhasil diubah.",
          'type'  => "success"
      ]));;
    }

    public function reset()
    {
      return view('auth.addemail');
    }
}
