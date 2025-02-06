<?php

namespace App\Http\Controllers;

use App\Models\DNSCategory;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Log;

class DNSCategoryController extends Controller
{
    public function index(Request $request)
    {
        $query = DNSCategory::query();
        $search ="";
        // Searching
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('name', 'like', "%$search%");
        }


        $categories = $query->orderBy('created_at','desc')->sortable()->paginate(15);
        return view('dnscategory.index', compact('categories','search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dnscategory.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'name' => 'required|string|unique:'.DNSCategory::class,
        ]);

        // Create a new instance of the lawcategory model
        $category = new DNSCategory();

        // Set the attributes on the model instance
        $category->name = $validatedData['name'];

        // Save the category to the database
        $category->save();

        // Redirect to the index page with a success message
        return redirect()->route('dnscategory.index')->with('success', 'Category added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(DNSCategory $dNSCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DNSCategory $dNSCategory)
    {
        $category = $dNSCategory;
        return view('dnscategory.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DNSCategory $dNSCategory)
    {
        $request->validate([
            'name' => ['required', 'string', 'unique:industry_categories,name,'.$dNSCategory->id],
        ]);

        $category = $dNSCategory;
        $category->name = $request->name;
        $category->save();
        return redirect()->route('dnscategory.index')->with('success','Category updated sucessfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DNSCategory $dNSCategory)
    {
        //
    }

    public function deleteSelected(Request $request)
    {
        try {
            $selectedIds = $request->input('selectedIds');
            if (!empty($selectedIds)) {
                DNSCategory::whereIn('id', explode(',', $selectedIds))->delete();
                return redirect()->route('dnscategory.index')->with('success', 'Selected category deleted successfully.');
            } else {
                return redirect()->route('dnscategory.index')->with('error', 'No category selected for deletion.');
            }
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }
    }
}
