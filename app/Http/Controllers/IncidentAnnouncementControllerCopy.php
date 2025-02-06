<?php

namespace App\Http\Controllers;

use App\Models\IncidentAnnouncement;
use App\Models\IncidentCategory;
use App\Models\Publisher;
use App\Models\User;
use App\Notifications\IncidentNotification;
use Illuminate\Http\Request;
use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Facades\View;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;

class IncidentAnnouncementControllerCopy extends Controller
{
    public function index(Request $request)
    {
        $query = IncidentAnnouncement::query();
        $search ="";
        // Searching
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->join('incident_categories','incident_announcements.category_id','=','incident_categories.id')
            ->join('publishers','incident_announcements.publisher_id','=','publishers.id')
                ->where('title', 'like', "%$search%")
                ->orWhere('incident_categories.name', 'like', "%$search%")
                ->orWhere('description', 'like', "%$search%")
                ->orWhere('publishers.name', 'like', "%$search%");

            
            if (DateTime::createFromFormat('d/M/Y',$search) !== false){
                $searchDate = Carbon::createFromFormat('d/M/Y',$search)->format('Y-m-d');
                $query->orWhere('date_incident','like',"%$searchDate%");
            }

            $query->select('incident_announcements.*');

        }


        $incidents = $query->sortable(['date_incident'=>'desc'])->paginate(15);
        return view('incident.index', compact('incidents','search'));
    }
    public function create(){
        $categories = IncidentCategory::orderBy('name','asc')->get();
        $publishers = Publisher::orderBy('name','asc')->get();
        return view('incident.create',compact(['categories','publishers']));
    }

    public function store(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'title' => 'required|string',
            'category' => 'required',
            'publisher' => 'required',
            'url_link' => 'required',
            'description' =>'required',
            'date_incident' => 'required|date_format:d/M/Y',
        ]);

        

        
        // Create a new instance of the incident model
        $incident = new IncidentAnnouncement();

        // Set the attributes on the model instance
        $incident->title = $validatedData['title'];
        $incident->category_id = $validatedData['category'];
        $incident->publisher_id = $validatedData['publisher'];
        $incident->description =$validatedData['description'] ;
        $incident->url_link = $validatedData['url_link'];
        $incident->date_incident = Carbon::createFromFormat('d/M/Y',$validatedData['date_incident'])->format('Y-m-d');

        // Save the incident to the database
        $incident->save();
        
        // Redirect to the index page with a success message
        return redirect()->route('incident.index')->with('success', 'Incident added successfully.');
    }

    public function edit($id)
    {
        $categories = IncidentCategory::orderBy('name','asc')->get();
        $publishers = Publisher::orderBy('name','asc')->get();
        $incident = IncidentAnnouncement::findOrFail($id);
        return view('incident.edit', compact(['incident','categories','publishers']));
    }

    public function update(Request $request, $id)
    {
        // Code to update the incident

        // Validate the incoming request data
        $validatedData = $request->validate([
            'title' => 'required|string',
            'category' => 'required',
            'publisher' => 'required',
            'url_link' => 'required',
            'description' =>'required',
            'date_incident' => 'required|date_format:d/M/Y',
        ]);
         // Create a new instance of the incident model
         $incident = IncidentAnnouncement::findOrFail($id);
         if ($incident){

            
             // Set the attributes on the model instance
            $incident->title = $validatedData['title'];
            $incident->publisher_id = $validatedData['publisher'];
            $incident->category_id = $validatedData['category'];
            $incident->description =$validatedData['description'];
            $incident->url_link = $validatedData['url_link'];
            $incident->date_incident = Carbon::createFromFormat('d/M/Y',$validatedData['date_incident'])->format('Y-m-d');
    
            // update the incident to the database
            $incident->save();
            
            return redirect()->route('incident.index')->with('success', 'Incident updated successfully.');
        }else{
            return redirect()->route('incident.index')->with('error', 'Incident maybe updated or deleted, please try again.');
        }

        
    }



    public function deleteSelected(Request $request)
    {
        try {
            $selectedIds = $request->input('selectedIds');
            if (!empty($selectedIds)) {
                IncidentAnnouncement::whereIn('id', explode(',', $selectedIds))->delete();
                return redirect()->route('incident.index')->with('success', 'Selected incidents deleted successfully.');
            } else {
                return redirect()->route('incident.index')->with('error', 'No incident selected for deletion.');
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
                $incidents = IncidentAnnouncement::whereIn('id', explode(',', $selectedIds))->get();
                foreach($incidents as $key => $incident){
                    $newincident = $incident->replicate();
                    $newincident->created_at = Carbon::now();
                    $newincident->save();
                }
                return redirect()->route('incident.index')->with('success', 'Selected incidents copied successfully.');
            } else {
                return redirect()->route('incident.index')->with('error', 'No incident selected for copy.');
            }
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }
    }

}
