<?php

namespace App\Http\Controllers;

use App\Models\IncidentCategory;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Log;

class IncidentCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = IncidentCategory::query();
        $search ="";
        // Searching
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('name', 'like', "%$search%");
        }


        $categories = $query->sortable(['created_at'=> 'desc'])->paginate(15);
        return view('inccategory.index', compact('categories','search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('inccategory.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'name' => 'required|string|unique:'.IncidentCategory::class,
        ]);

        // Create a new instance of the lawcategory model
        $category = new IncidentCategory();

        // Set the attributes on the model instance
        $category->name = $validatedData['name'];

        // Save the category to the database
        $category->save();

        // Redirect to the index page with a success message
        return redirect()->route('inccategory.index')->with('success', 'Category added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(IncidentCategory $incidentCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(IncidentCategory $incidentCategory)
    {
        $category = $incidentCategory;
        return view('inccategory.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, IncidentCategory $incidentCategory)
    {
        $request->validate([
            'name' => ['required', 'string', 'unique:industry_categories,name,'.$incidentCategory->id],
        ]);

        $category = $incidentCategory;
        $category->name = $request->name;
        $category->save();
        return redirect()->route('inccategory.index')->with('success','Category updated sucessfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(IncidentCategory $incidentCategory)
    {
        //
    }

    public function deleteSelected(Request $request)
    {
        try {
            $selectedIds = $request->input('selectedIds');
            if (!empty($selectedIds)) {
                IncidentCategory::whereIn('id', explode(',', $selectedIds))->delete();
                return redirect()->route('inccategory.index')->with('success', 'Selected category deleted successfully.');
            } else {
                return redirect()->route('inccategory.index')->with('error', 'No category selected for deletion.');
            }
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }
    }
}
