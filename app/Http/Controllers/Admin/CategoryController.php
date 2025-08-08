<?php

namespace App\Http\Controllers\Admin;;

use App\Models\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

        public function index()
        {
            $categories = Category::all();
            return view('admin.categories.index', compact('categories'));
        }

        public function create()
        {
            return view('admin.categories.create');
        }

        public function store(Request $request)
        {
            $request->validate([
                'name' => 'required|string|max:255',
                'amount' => 'required|numeric',
            ]);

            Category::create($request->all());

            return redirect()->route('admin.categories.index')->with('success', 'Category created successfully.');
        }

        public function show(Category $category)
        {
            return view('admin.categories.show', compact('category'));
        }

        public function edit(Category $category)
        {
            return view('admin.categories.edit', compact('category'));
        }

        public function update(Request $request, Category $category)
        {
            $request->validate([
                'name' => 'required|string|max:255',
                'amount' => 'required|numeric',
            ]);

            $category->update($request->all());

            return redirect()->route('admin.categories.index')->with('success', 'Category updated successfully.');
        }

        public function destroy(Category $category)
        {
            $category->delete();

            return redirect()->route('admin.categories.index')->with('success', 'Category deleted successfully.');
        }

}
