<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Comment;

class CommentController extends Controller
{
    private $comment;

    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
    }

    public function store(Request $request, $post_id)
    {
        $request->validate([
            'comment_body' . $post_id           => 'required|max:150'
        ],[
            'comment_body' . $post_id . '.required' =>'You cannot post an empty comment.',
            'comment_body' . $post_id. '.max' => 'Maximum of 150 characters only.'
        ]);

        $this->comment->body = $request->input('comment_body' . $post_id);
        $this->comment->post_id = $post_id;
        $this->comment->user_id = Auth::user()->id;
        $this->comment->save();

        return redirect()->back();
    }

    // public function index()
    // {
    //     $all_comments = $this->comment->all();

    //     return redirect()->route('post.show')
    //         ->with('all_comments', $all_comments);
    // }

    public function destroy($id)
    {
        $comment = $this->comment->findOrFail($id);
        $comment->destroy($id);

        return redirect()->back();
    }
}
