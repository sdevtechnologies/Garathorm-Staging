<?php

namespace App\Http\Controllers;

use App\Models\LawCategory;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LawCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = LawCategory::query();
        $search ="";
        // Searching
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('name', 'like', "%$search%");
        }


        $categories = $query->sortable(['created_at'=> 'desc'])->paginate(15);
        return view('lawcategory.index', compact('categories','search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('lawcategory.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'name' => 'required|string|unique:'.LawCategory::class,
        ]);

        // Create a new instance of the lawcategory model
        $category = new LawCategory();

        // Set the attributes on the model instance
        $category->name = $validatedData['name'];

        // Save the category to the database
        $category->save();

        // Redirect to the index page with a success message
        return redirect()->route('lawcategory.index')->with('success', 'Category added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(LawCategory $lawCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(LawCategory $lawCategory)
    {
        $category = $lawCategory;
        return view('lawcategory.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, LawCategory $lawCategory)
    {
        $request->validate([
            'name' => ['required', 'string', 'unique:law_categories,name,'.$lawCategory->id],
        ]);

        $category = $lawCategory;
        $category->name = $request->name;
        $category->save();
        return redirect()->route('lawcategory.index')->with('success','Category updated sucessfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LawCategory $lawCategory)
    {
        //
    }

    public function deleteSelected(Request $request)
    {
        try {
            $selectedIds = $request->input('selectedIds');
            if (!empty($selectedIds)) {
                LawCategory::whereIn('id', explode(',', $selectedIds))->delete();
                return redirect()->route('lawcategory.index')->with('success', 'Selected category deleted successfully.');
            } else {
                return redirect()->route('lawcategory.index')->with('error', 'No category selected for deletion.');
            }
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }
    }
}
