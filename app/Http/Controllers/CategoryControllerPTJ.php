<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

/**
 * CategoryControllerPTJ
 *
 * Manages task categories (Admin only).
 
 */
class CategoryControllerPTJ extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin'); // Only admins manage categories
    }

    
    public function index()
    {
        $categories = Category::withCount('tasks')->get();
        return view('categories.index', compact('categories'));
    }

    /** Route: GET /categories/create */
    public function create()
    {
        return view('categories.create');
    }

    /** Route: POST /categories */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => ['required', 'string', 'max:100', 'unique:categories,name'],
            'description' => ['nullable', 'string', 'max:255'],
            'color'       => ['nullable', 'regex:/^#[0-9A-Fa-f]{6}$/'], // hex color
        ]);

        Category::create($validated);

        return redirect()->route('categories.index')->with('success', 'Category created!');
    }

    /** Route: GET /categories/{category}/edit */
    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    /** Route: PUT /categories/{category} */
    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name'        => ['required', 'string', 'max:100', 'unique:categories,name,' . $category->id],
            'description' => ['nullable', 'string', 'max:255'],
            'color'       => ['nullable', 'regex:/^#[0-9A-Fa-f]{6}$/'],
        ]);

        $category->update($validated);

        return redirect()->route('categories.index')->with('success', 'Category updated!');
    }

    /** Route: DELETE /categories/{category} */
    public function destroy(Category $category)
    {
        // Prevent deleting a category that still has tasks
        if ($category->tasks()->exists()) {
            return back()->with('error', 'Cannot delete a category that has tasks assigned to it.');
        }

        $category->delete();

        return redirect()->route('categories.index')->with('success', 'Category deleted!');
    }
}
