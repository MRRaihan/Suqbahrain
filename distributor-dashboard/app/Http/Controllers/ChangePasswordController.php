<?php

namespace App\Http\Controllers;

use App\Rules\MatchOldPassword;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ChangePasswordController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('changePassword');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function store(Request $request)
    {
        $request->validate([
            'new_password' => "required | min:6 | confirmed",
            'current_password' => "required",
        ]);
         $flag = true;
        $current_password = $request->current_password;
        $new_password = $request->new_password;

        // is current password correct
        if (!Hash::check($current_password, Auth::user()->password)) {
            $flag = false;
            Session::flash('err_msg_current_password', 'Invalid Credentials!');
        }

        // is new password is same as previous password
        if (Hash::check($new_password, Auth::user()->password)) {
            $flag = false;
            Session::flash('err_msg_same_password', 'Please enter different password than previous one!');
        }

        if($flag){
            //update operation
            User::find(auth()->user()->id)->update(['password'=> Hash::make($request->new_password)]);
            Toastr::success('message', 'Password Update Successfully');
        }

        return redirect()->back();
    }
}
