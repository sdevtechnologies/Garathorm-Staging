<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DNS;
use App\Models\DNSCategory;
use Carbon\Carbon;
use Illuminate\Support\Facades\View;
use Exception;
use Illuminate\Support\Facades\Log;

class DNSController extends Controller
{
    public function index(Request $request)
    {
        $query = DNS::query();
        $search ="";
        // Searching
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('title', 'like', "%$search%")
                ->orWhere('description', 'like', "%$search%")
                ->orWhere('category', 'like', "%$search%");
        }


        $DNSs = $query->orderBy('created_at','desc')->sortable()->paginate(15);
        return view('DNS.index', compact('DNSs','search'));
    }
    public function create(){
        return view('DNS.create');
    }

    public function store(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'title' => 'required|string',
            'category' => 'required',
            'url_link' => '',
            'description' =>'',
            'date_issue' => 'required|date_format:d/M/Y',
        ]);

        // Create a new instance of the DNS model
        $DNS = new DNS();

        // Set the attributes on the model instance
        $DNS->title = $validatedData['title'];
        $DNS->category = $validatedData['category'];
        $DNS->description = $validatedData['description'];
        $DNS->url_link =  $validatedData['url_link'];
        $DNS->date_issue = Carbon::createFromFormat('d/M/Y',$validatedData['date_issue'])->format('Y-m-d');

        // Save the DNS to the database
        $DNS->save();

        // Redirect to the index page with a success message
        return redirect()->route('DNS.index')->with('success', 'DNS added successfully.');
    }

    public function edit($id)
    {
        $DNS = DNS::findOrFail($id);
        return view('DNS.edit', compact('DNS'));
    }

    public function update(Request $request, $id)
    {
        // Code to update the DNS

        // Validate the incoming request data
        $validatedData = $request->validate([
            'title' => 'required|string',
            'category' => 'required',
            'url_link' => '',
            'description' =>'',
            'date_issue' => 'required|date_format:d/M/Y',
        ]);
         // Create a new instance of the DNS model
         $DNS = DNS::findOrFail($id);
         if ($DNS){
             // Set the attributes on the model instance
            $DNS->title = $validatedData['title'];
            $DNS->category = $validatedData['category'];
            $DNS->description =  $validatedData['description'];
            $DNS->url_link =  $validatedData['url_link'];
            $DNS->date_issue = Carbon::createFromFormat('d/M/Y',$validatedData['date_issue'])->format('Y-m-d');
    
            // update the DNS to the database
            $DNS->save();
            return redirect()->route('DNS.index')->with('success', 'DNS updated successfully.');
        }else{
            return redirect()->route('DNS.index')->with('error', 'DNS maybe updated or deleted, please try again.');
        }

        
    }



    public function deleteSelected(Request $request)
    {
        try {
            $selectedIds = $request->input('selectedIds');
            if (!empty($selectedIds)) {
                DNS::whereIn('id', explode(',', $selectedIds))->delete();
                return redirect()->route('DNS.index')->with('success', 'Selected DNSs deleted successfully.');
            } else {
                return redirect()->route('DNS.index')->with('error', 'No DNS selected for deletion.');
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
                $DNSs = DNS::whereIn('id', explode(',', $selectedIds))->get();
                foreach($DNSs as $key => $DNS){
                    $newDNS = $DNS->replicate();
                    $newDNS->created_at = Carbon::now();
                    $newDNS->save();
                }
                return redirect()->route('DNS.index')->with('success', 'Selected DNSs copied successfully.');
            } else {
                return redirect()->route('DNS.index')->with('error', 'No DNS selected for copy.');
            }
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }
    }


}
