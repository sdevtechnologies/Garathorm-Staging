<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VAPT;
use App\Models\VAPTCategory;
use Carbon\Carbon;
use Illuminate\Support\Facades\View;
use Exception;
use Illuminate\Support\Facades\Log;

class VAPTController extends Controller
{
    public function index(Request $request)
    {
        $query = VAPT::query();
        $search ="";
        // Searching
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('title', 'like', "%$search%")
                ->orWhere('description', 'like', "%$search%")
                ->orWhere('category', 'like', "%$search%");
        }


        $VAPTs = $query->orderBy('created_at','desc')->sortable()->paginate(15);
        return view('VAPT.index', compact('VAPTs','search'));
    }
    public function create(){
        return view('VAPT.create');
    }

    public function store(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'title' => 'required|string',
            'category' => 'required|',
            'url_link' => '',
            'description' =>'',
            'date_issue' => 'required|date_format:d/M/Y',
        ]);

        // Create a new instance of the VAPT model
        $VAPT = new VAPT();

        // Set the attributes on the model instance
        $VAPT->title = $validatedData['title'];
        $VAPT->category = $validatedData['category'];
        $VAPT->description = $validatedData['description'];
        $VAPT->url_link = $validatedData['url_link'] ;
        $VAPT->date_issue = Carbon::createFromFormat('d/M/Y',$validatedData['date_issue'])->format('Y-m-d');

        // Save the VAPT to the database
        $VAPT->save();

        // Redirect to the index page with a success message
        return redirect()->route('VAPT.index')->with('success', 'VAPT added successfully.');
    }

    public function edit($id)
    {
        $VAPT = VAPT::findOrFail($id);
        return view('VAPT.edit', compact('VAPT'));
    }

    public function update(Request $request, $id)
    {
        // Code to update the VAPT

        // Validate the incoming request data
        $validatedData = $request->validate([
            'title' => 'required|string',
            'category' => 'required',
            'url_link' => '',
            'description' =>'',
            'date_issue' => 'required|date_format:d/M/Y',
        ]);
         // Create a new instance of the VAPT model
         $VAPT = VAPT::findOrFail($id);
         if ($VAPT){
             // Set the attributes on the model instance
            $VAPT->title = $validatedData['title'];
            $VAPT->category = $validatedData['category'];
            $VAPT->description = $validatedData['description'];
            $VAPT->url_link =  $validatedData['url_link'];
            $VAPT->date_issue = Carbon::createFromFormat('d/M/Y',$validatedData['date_issue'])->format('Y-m-d');
    
            // update the VAPT to the database
            $VAPT->save();
            return redirect()->route('VAPT.index')->with('success', 'VAPT updated successfully.');
        }else{
            return redirect()->route('VAPT.index')->with('error', 'VAPT maybe updated or deleted, please try again.');
        }

        
    }



    public function deleteSelected(Request $request)
    {
        try {
            $selectedIds = $request->input('selectedIds');
            if (!empty($selectedIds)) {
                VAPT::whereIn('id', explode(',', $selectedIds))->delete();
                return redirect()->route('VAPT.index')->with('success', 'Selected VAPTs deleted successfully.');
            } else {
                return redirect()->route('VAPT.index')->with('error', 'No VAPT selected for deletion.');
            }
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }
    }

    public function copySelected(Request $request)
    {
        try {
            $selectedIds = $request->input('selectedCopyIds');
            if (!empty($selectedIds)) {
                $VAPTs = VAPT::whereIn('id', explode(',', $selectedIds))->get();
                foreach($VAPTs as $key => $VAPT){
                    $newVAPT = $VAPT->replicate();
                    $newVAPT->created_at = Carbon::now();
                    $newVAPT->save();
                }
                return redirect()->route('VAPT.index')->with('success', 'Selected VAPTs copied successfully.');
            } else {
                return redirect()->route('VAPT.index')->with('error', 'No VAPT selected for copy.');
            }
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }
    }

}
