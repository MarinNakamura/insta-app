<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoriesController extends Controller
{
    private $category;

    public function __construct(Category $category)
    {
        $this->category = $category;
    }

    public function index()
    {
        $all_categories = $this->category->orderBy('name')->paginate(10);

        return view('admin.categories.index')
            ->with('all_categories', $all_categories);
    }

    public function store(Request $request)
    {
        $request->validate([
            'add_category'         => 'required|max:50|unique:categories,name'
        ]);

        $this->category->name = $request->add_category;

        $this->category->save();

        return redirect()->back();
    }

    public function destroy($id)
    {
        $category_a = $this->category->findOrFail($id);
        $category_a->destroy($id);

        return redirect()->back();
    }

    public function update(Request $request, $id)
    {
        $category_a = $this->category->findOrFail($id);

        $request->validate([
            'edit_category'                => 'required|max:50|unique:categories,name'
        ]);

        $category_a->name = $request->edit_category;
        $category_a->save();

        return redirect()->back();
    }
}
