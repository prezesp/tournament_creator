<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Validator;
use Hash;
use App\User;


class ChangePasswordController extends Controller
{
  public function admin_credential_rules(array $data)
  {
    $messages = [
      'current_password.required' => 'Please enter current password',
      'password.required' => 'Please enter password',
    ];

    $validator = Validator::make($data, [
      'current_password' => 'required',
      'password' => 'required|same:password',
      'password_confirmation' => 'required|same:password',
    ], $messages);

    return $validator;
  }

  public function index()
  {
    return view ('auth.passwords.change');
  }

  public function postCredentials(Request $request)
  {
    if (Auth::Check())
    {
      $request_data = $request->All();
      $validator = $this->admin_credential_rules($request_data);
      if ($validator->fails())
      {
        return redirect()->back()->withErrors($validator->getMessageBag()->toArray());
      }
      else
      {
        $current_password = Auth::User()->password;
        if(Hash::check($request_data['current_password'], $current_password))
        {
          $user_id = Auth::User()->id;
          $obj_user = User::find($user_id);
          $obj_user->password = Hash::make($request_data['password']);;
          $obj_user->save();
          Auth::logout();

          $request->session()->forget('message');
          $message = 'Well done! Your password was changed. Please login again.';
          $request->session()->flash('message', $message);

          return redirect()->to('/login');
        }
        else
        {
          $error = array('current_password' => 'Please enter correct current password');
          return redirect()->back()->withErrors($error);
        }
      }
    }
    else
    {
      return redirect()->to('/');
    }
  }
}
