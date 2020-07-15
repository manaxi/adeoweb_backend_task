<?php

namespace App\Http\Controllers;

use \Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Category;
Use App\Http\Resources\Category as categoryResoure;

class CategoriesController extends Controller
{
    public function getCategories()
    {
        $categories = Category::paginate(10);
        return categoryResoure::collection($categories);
    }

    public function showCategory($id)
    {
        $category = Category::findOrFail($id);
        return new categoryResoure($category);
    }

    public function showCategoryProducts($id)
    {
        $category = Category::findOrFail($id)->products;
        return new categoryResoure(app('App\Http\Controllers\ProductsController')->paginate($category));
    }

    public function storeCategory(Request $request)
    {
        $validatedData = Validator::make($request->all(), [
            'name' => 'required|min:4',
            'weather' => 'required',
            'slug' => 'required|min:3'
        ]);
        $category = $request->isMethod('put') ? Category::findOrFail($request->category_id) : New Category;
        $category->id = $request->category_id;
        $category->name = $request->name;
        $category->weather = $request->weather;
        $category->slug = $request->slug;
        if ($validatedData->fails()) {
            foreach ($validatedData->errors()->getMessages() as $item)
                $errors[] = $item;
            return response()->json(['errors' => $errors], 200);
        } else {
            $category->save();
            if ($category->save())
                return new categoryResoure($category);
        }
        return null;
    }

    public function deleteCategory($id)
    {
        $category = Category::findOrFail($id);
        if ($category->delete())
            return new categoryResoure($category);
    }
}
