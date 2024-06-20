<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use App\Models\User;
use App\Models\Follow;
use PhpParser\Node\Stmt\Foreach_;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    private $post;
    private $user;

    public function __construct(Post $post, User $user)
    {
        // $this->middleware('auth');
        $this->post = $post;
        $this->user = $user;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        if ($request->search) {
            //search results
            $home_posts = $this->post->where('description', 'LIKE', '%' . $request->search . '%')->latest()->get();
            //SELECT * FROM users WHERE description LIKE '%keyword%'

        } else { //regular home posts
            $all_posts = $this->post->latest()->get();

            // Display only posts of the users who you are following
            $home_posts = [];
            foreach ($all_posts as $post) {
                if ($post->user->isFollowing() || $post->user_id == Auth::user()->id) {
                    // if ($post->user_id == Auth::user()->id) {
                    $home_posts[] = $post;
                }
            }
        }

        return view('user.home')
            ->with('all_posts', $home_posts)
            ->with('suggested_users', $this->getSuggestedUsers())
            ->with('search', $request->search);
    }

    // get a list of suggested users
    private function getSuggestedUsers()
    {
        $all_users = $this->user->all()->except(Auth::user()->id);

        $suggested = [];
        $count = 0;
        foreach ($all_users as $user) {
            if (!$user->isFollowing() && $count < 10) {
                $suggested[] = $user;
                $count++;
            }
        }

        return $suggested;
    }

    public function getSuggestedUsersIndex(Request $request)
    {
        if ($request->search) {
            $all_users = $this->user->where('name', 'LIKE', '%' . $request->search . '%')->get()->except(Auth::user()->id);
        } else {
        $all_users = $this->user->all()->except(Auth::user()->id);
        }

        $suggested = [];
        // $count = 0;
        foreach ($all_users as $user) {
            if (!$user->isFollowing()) {
                $suggested[] = $user;
                // $count++;
            }
        }


        return view('user.suggested-users')
            ->with('suggested_users', $suggested)
            ->with('search', $request->search);
    }

}
