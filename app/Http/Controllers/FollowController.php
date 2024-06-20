<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Follow;

class FollowController extends Controller
{
    private $follow;

    public function __construct(Follow $follow)
    {
        $this->follow = $follow;
    }

    public function store($user_id)
    {
        // f$user_id = followed id
        $this->follow->follower_id = Auth::user()->id;
        $this->follow->followed_id = $user_id;
        $this->follow->save();

        return redirect()->back();
    }

    public function destroy($user_id)
    {
        $this->follow->where('follower_id', Auth::user()->id)
                    ->where('followed_id', $user_id)
                    ->delete();

        return redirect()->back();
    }

    public function storeFollowing($user_id)
    {
        // user_id = follower id
        $this->follow->followed_id = Auth::user()->id;
        $this->follow->follower_id = $user_id;
        $this->follow->save();

        return redirect()->back();
    }

    public function destroyFollowing($user_id)
    {
        $this->follow->where('followed_id', Auth::user()->id)
                    ->where('follower_id', $user_id)
                    ->delete();

        return redirect()->back();
    }
}
