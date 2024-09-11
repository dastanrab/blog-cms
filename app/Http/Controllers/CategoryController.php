<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryCreateRequest;
use App\Models\Category;
use App\Services\Category\CategoryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class CategoryController extends Controller
{
    private CategoryService $category_service;

    public function __construct(CategoryService $category_service)
    {
        $this->category_service=$category_service;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories=$this->category_service->getCategories();
       return view('category.index',compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryCreateRequest $request)
    {
        $this->category_service->createCategory($request);
        return view('category.create')->with('success','post created!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        $category=$this->category_service->showCategory($category);
        return view('category.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        $category=$this->category_service->showCategory($category);
        return view('category.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $this->category_service->updateCategory($request,$category);
        return redirect()->back()->with('success','category updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $this->category_service->deleteCategory($category);
        return redirect()->back()->with('success', 'Category deleted successfully!');
    }
}
