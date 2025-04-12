<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function categoryInsert(Request $request)
    {

        // gelen veriyi dogrulama
        $validated = $request->validate(["name" => "required"]);

        // gelen kategoriyi veritabanina ekleme
        $category = Category::create([
            'name' => $validated["name"],
        ]);

        return response()->json([
            'message' => 'Category created successfully.',
        ]);

    }

    public function categoryUpdate(Request $request, $id)
    {
        $validated = $request->validate(["name" => "required"]);

        $category = Category::find($id);

        if (!$category) {
            return response()->json([
                'message' => 'Category not found.',
            ]);
        }

        $category->name = $validated["name"];
        $category->save();

        return response()->json([
            'message' => 'Category updated successfully.',
        ]);
    }

    public function categoryDelete($id)
    {
        $category = Category::find($id);

        if (!$category) {
            return response()->json([
                'message' => 'Category not found.',
            ]);
        }

        $category->delete();

        return response()->json([
            'message' => 'Category deleted successfully.',
        ]);
    }

    public function categoryList(){

        $categories = Category::all();
        return response()->json([
            'categories' => $categories,
        ]);
    }

}
