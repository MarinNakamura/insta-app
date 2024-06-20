<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class ProfileController extends Controller
{
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function show($id)
    {
        $user_a = $this->user->findOrFail($id);

        return view('user.profiles.show')
            ->with('user', $user_a);
    }

    public function edit()
    {
        return view('user.profiles.edit');
    }

    public function update(Request $request)
    {
        $request->validate([
            'avatar'          => 'max:1048|mimes:jpeg,jpg,png.gif',
            'name'            => 'required|max:50',
            'email'           => 'required|max:50|email|unique:users,email,' . Auth::user()->id,
            //Adding: unique:<table>, <column>
            //Updating: unique:<table>, <column>, <id>
            'introduction'    => 'max:100'
        ]);

        $user_a = $this->user->findOrFail(Auth::user()->id);

        $user_a->name         = $request->name;
        $user_a->email        = $request->email;
        $user_a->introduction = $request->introduction;

        if ($request->avatar) {
            $user_a->avatar   = 'data:image/' . $request->avatar->extension() . ';base64,' . base64_encode(file_get_contents($request->avatar));
        }

        $user_a->save();

        return redirect()->route('profile.show', Auth::user()->id);

    }

    public function followers($id)
    {
        $user_a = $this->user->findOrFail($id);

        return view('user.profiles.followers')
            ->with('user', $user_a);
    }

    public function following($id)
    {
        $user_a = $this->user->findOrFail($id);

        return view('user.profiles.following')
            ->with('user', $user_a);
    }

    public function updatePassword(Request $request)
    {
        //check old password
        $user_a = $this->user->findOrFail(Auth::user()->id);
        if(!Hash::check($request->old_password, $user_a->password)){
            //return with validation error
            return redirect()->back()->with('old_password_error', 'Incorrect current password.');
        }

        //validate if old and new password are the same
        if($request->old_password == $request->new_password){
            //return with validation error
            return redirect()->back()->with('new_password_error', 'New password cannot be the same as old.');
        }

        //confirm new password
        $request->validate([
            'new_password' => 'required|min:8|confirmed'
        ],[
            'new_password.confirmed' => 'The new password and the confirm password do not match.'
        ]);

        $user_a->password = Hash::make($request->new_password);
        $user_a->save();

        return redirect()->back()->with('success_message', 'Password changed successfully!');
    }


}
