<?php

namespace App\Services\Category;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoryService
{
    public function getCategories()
    {
        return Category::query()->latest()->paginate(10);
    }

    public function createCategory(Request $request)
    {
        $category = new Category();
        $category->name = $request->name;
        $category->save();
        if ($request->hasFile('image')) {
            $category->image()->create(['path'=>$request->file('image')->store('public')]) ;
        }
    }
    public function showCategory(Category $category)
    {
        $related=['image'];
        return $category->load($related);
    }

    public function updateCategory(Request $request, Category $category)
    {
        $category->name = $request->name;
        if ($request->hasFile('image'))
        {
            $this->checkImage($category);
            $category->image()->create(['path'=>$request->file('image')->store('public')]) ;
        }
        $category->save();
        return $category;
    }
    private function checkImage(Category $category)
    {
        $image=$category->image()->first();
        if ($image)
        {
            Storage::delete($category->image->path);
            $category->image()->delete();
        }
    }
    public function deleteCategory(Category $category)
    {
        $this->checkImage($category);
        $category->posts()->detach();
        $category->delete();
    }
}
