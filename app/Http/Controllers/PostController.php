<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;
use App\Models\Post;


class PostController extends Controller
{
    private $category;
    private $post;

    public function __construct(Category $category, Post $post)
    {
        $this->category = $category;
        $this->post = $post;
    }

    public function create()
    {
        $all_categories = $this->category->all();

        return view('user.posts.create')
            ->with('all_categories', $all_categories);
    }

    public function store(Request $request)
    {
        $request->validate([
            'categories'          => 'required|array|between:1,3', //up to 3
            'description'         => 'required|max:1000',
            'image'               => 'required|max:1048|mimes:jpeg,jpg,png,gif',
        ]);

        $this->post->description  = $request->description;
        $this->post->image        = 'data:image/' . $request->image->extension() . ';base64,' . base64_encode(file_get_contents($request->image));
        $this->post->user_id      = Auth::user()->id;

        $this->post->save();

        $category_posts = [];
        foreach($request->categories as $category_id){
            $category_posts [] = ['category_id' => $category_id];
        }
        // $category_posts = [
        //     [
        //         'category_id' => 1
        //     ],
        //     [
        //         'category_id' => 2
        //     ]
        // ]

        $this->post->categoryPosts()->createMany($category_posts);
        // createMany() creates multiple arrays

        return redirect()->route('home');
    }

    public function show($id)
    {
        $post_a = $this->post->findOrFail($id);

        return view('user.posts.show')
            ->with('post', $post_a);
    }

    public function edit($id)
    {
        $all_categories = $this->category->all();
        $post_a = $this->post->findOrFail($id);

        $selected_categories = [];
        foreach ($post_a->categoryPosts as $category_post){
            $selected_categories [] = $category_post->category_id;
        }

        return view('user.posts.edit')
            ->with('post', $post_a)
            ->with('all_categories', $all_categories)
            ->with('selected_categories', $selected_categories);
    }

    public function update(Request $request, $id)
    {
        $post_a = $this->post->findOrFail($id);

        $request->validate([
            'description'     => 'required|max:1000',
            'image'           => 'max:1048|mimes:jpeg,jpg,png,gif'
        ]);

        $post_a->description = $request->description;
        // $this->post->image       = 'data:image/' . $request->image->extension() . ';base64,' . base64_encode(file_get_contents($request->image));
        // $img_obj = $request->image;
        // if ($img_obj !== null) {
        //     $this->post->image       = 'data:image/' . $request->image->extension() . ';base64,' . base64_encode(file_get_contents($request->image));
        // }

        if ($request->image) {
        $post_a->image       = 'data:image/' . $request->image->extension() . ';base64,' . base64_encode(file_get_contents($request->image));
        }

        $post_a->save();

        // delete all category_post records (related to the post)
        $post_a->categoryPosts()->delete();

        $category_posts = [];
        foreach($request->categories as $category_id){
            $category_posts [] = ['category_id' => $category_id];
        }

        $post_a->categoryPosts()->createMany($category_posts);


        return redirect()->route('post.show', $id);
    }

    public function destroy($id)
    {
        // $post_a = $this->post->findOrFail($id);
        $post_a = $this->post->findOrFail($id);
        $post_a->forceDelete(); //Permanent delete

        // $post_a->destroy($id);
        return redirect()->route('home');
    }
}
