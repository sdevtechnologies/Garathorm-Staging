<?php

namespace App\Http\Controllers;

use App\Models\Publisher;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PublisherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Publisher::query();
        $search ="";
        // Searching
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('name', 'like', "%$search%");
        }


        $publishers = $query->sortable(['created_at'=> 'desc'])->paginate(15);
        return view('publisher.index', compact('publishers','search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('publisher.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|unique:'.Publisher::class,
        ]);

        $publisher = new Publisher();

        $publisher->name = $validatedData['name'];

        $publisher->save();
        return redirect()->route('publisher.index')->with('success', 'Publisher added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Publisher $publisher)
    {
        return view('publisher.edit', compact('publisher'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Publisher $publisher)
    {
        //
        $request->validate([
            'name' => ['required', 'string', 'unique:publishers,name,'.$publisher->id],
        ]);

        $publisher->name = $request->name;
        $publisher->save();
        return redirect()->route('publisher.index')->with('success','Publisher updated sucessfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function deleteSelected(Request $request)
    {
        try {
            $selectedIds = $request->input('selectedIds');
            if (!empty($selectedIds)) {
                Publisher::whereIn('id', explode(',', $selectedIds))->delete();
                return redirect()->route('publisher.index')->with('success', 'Selected publisher deleted successfully.');
            } else {
                return redirect()->route('publisher.index')->with('error', 'No publisher selected for deletion.');
            }
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }
    }
}
