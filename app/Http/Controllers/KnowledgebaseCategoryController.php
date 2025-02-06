<?php

namespace App\Http\Controllers;

use App\Models\knowledgebaseCategory;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Log;

class knowledgebaseCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = knowledgebaseCategory::query();
        $search = "";

        // Searching
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('name', 'like', "%$search%");
        }

        $categories = $query->sortable(['created_at' => 'desc'])->paginate(15);
        return view('knowledgebasecategory.index', compact('categories', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('knowledgebasecategory.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'name' => 'required|string|unique:' . knowledgebaseCategory::class,
        ]);

        // Create a new instance of the knowledgebaseCategory model
        $category = new knowledgebaseCategory();

        // Set the attributes on the model instance
        $category->name = $validatedData['name'];

        // Save the category to the database
        $category->save();

        // Redirect to the index page with a success message
        return redirect()->route('knowledgebasecategories.index')->with('success', 'Category added successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(knowledgebaseCategory $knowledgebaseCategory)
    {
        $category = $knowledgebaseCategory;
        return view('knowledgebasecategories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, knowledgebaseCategory $knowledgebaseCategory)
    {
        $request->validate([
            'name' => ['required', 'string', 'unique:knowledgebase_categories,name,' . $knowledgebaseCategory->id],
        ]);

        $category = $knowledgebaseCategory;
        $category->name = $request->name;
        $category->save();

        return redirect()->route('knowledgebasecategories.index')->with('success', 'Category updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(knowledgebaseCategory $knowledgebaseCategory)
    {
        // Delete the category
        $knowledgebaseCategory->delete();
        return redirect()->route('knowledgebasecategories.index')->with('success', 'Category deleted successfully.');
    }

    /**
     * Delete selected categories.
     */
    public function deleteSelected(Request $request)
    {
        try {
            $selectedIds = $request->input('selectedIds');
            if (!empty($selectedIds)) {
                knowledgebaseCategory::whereIn('id', explode(',', $selectedIds))->delete();
                return redirect()->route('knowledgebasecategories.index')->with('success', 'Selected categories deleted successfully.');
            } else {
                return redirect()->route('knowledgebasecategories.index')->with('error', 'No category selected for deletion.');
            }
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return redirect()->route('knowledgebasecategories.index')->with('error', 'An error occurred while deleting categories.');
        }
    }
};