<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
       $categories = Category::orderByDESC('id')->get();
       return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
       return view('admin.categories.create');
        
    }

    public function store(Request $request)
    {
        $fileName = "";
        $dir  = "uploads/categories/";

        if($request->has("image")) {
            $fileName = time().'-category.'.$request->image->getClientOriginalExtension();
            $request->image->move($dir, $fileName);
            $fileName = asset($dir.$fileName);
        }
        Category::create([
            "name"=>$request->name,
            "image"=>$fileName
        ]);

        return redirect('admin/categories')->with("success", "Category created");
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $category = Category::find($id);
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $dir  = "uploads/categories/";

        $category = Category::find($id);
        $category->name = $request->name;

        if($request->has("image")) {
            $fileName = time().'-category.'.$request->image->getClientOriginalExtension();
            $request->image->move($dir, $fileName);
            $fileName = asset($dir.$fileName);

            $category->image = $fileName;
        }

        $category->status = $request->status;
        $category->save();
        return redirect('admin/categories')->with("success", "Category updated");

    }

    public function destroy($id)
    {
        //
    }
}
