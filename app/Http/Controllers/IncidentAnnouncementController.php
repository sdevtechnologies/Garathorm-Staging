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

class IncidentAnnouncementController extends Controller
{
    public function index(Request $request)
    {
        $query = IncidentAnnouncement::query();
        $search ="";
        // Searching
        if ($request->has('search')) {
            $search = $request->input('search');
            if(strtolower($request->input('sort'))!=='category.name'){
                $query->join('incident_categories','incident_announcements.category_id','=','incident_categories.id');
            }
                $query->join('publishers','incident_announcements.publisher_id','=','publishers.id')
                ->where('title', 'like', "%$search%")
                ->orWhere('description', 'like', "%$search%")
                ->orWhere('incident_categories.name', 'like', "%$search%")
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

    public function whatsnewindex(Request $request)
    {
        $query = IncidentAnnouncement::query();
        $search ="";
        $twoWeeksAgoDate = Carbon::today()->subDays(14);
        // Searching
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->join('incident_categories','incident_announcements.category_id','=','incident_categories.id')
            ->join('publishers','incident_announcements.publisher_id','=','publishers.id')
                ->where('incident_announcements.created_at','>=',$twoWeeksAgoDate)
                ->where(function($subquery) use ($search){    
                    $subquery->where('title', 'like', "%$search%")
                    ->orWhere('description', 'like', "%$search%")
                    ->orWhere('incident_categories.name', 'like', "%$search%")
                    ->orWhere('publishers.name', 'like', "%$search%");
                });
            
            if (DateTime::createFromFormat('d/M/Y',$search) !== false){
                $searchDate = Carbon::createFromFormat('d/M/Y',$search)->format('Y-m-d');
                $query->orWhere('date_incident','like',"%$searchDate%");
            }
            $query->select('incident_announcements.*');

        }else{
            $query->where('created_at','>=',$twoWeeksAgoDate);
        }


        $incidents = $query->sortable(['created_at'=>'desc'])->paginate(15);
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
            'relatedcategory' => '',
            'publisher' => 'required',
            'url_link' => 'required',
            'description' =>'required',
            'published' =>'required',
            'date_incident' => 'required|date_format:d/M/Y',
        ]);

        if(!is_numeric($validatedData['category'])){
            $law_category = new IncidentCategory();
            $law_category->name = $validatedData['category'];
            $law_category->save();
            $validatedData['category']=$law_category->id;
        }
        
        if(!empty($validatedData['relatedcategory'])){
            foreach($validatedData['relatedcategory'] as $key=>$category){
                if(!is_numeric($category) && trim($category) != '' ){
                    $law_category = new IncidentCategory();
                    $law_category->name = $category;
                    $law_category->save();
                    $validatedData['relatedcategory'][$key]=$law_category->id;
                }
            }
        }

        if(!is_numeric($validatedData['publisher'])){
            $publisher = new Publisher();
            $publisher->name = $validatedData['publisher'];
            $publisher->save();
            $validatedData['publisher']=$publisher->id;
        }

        // Create a new instance of the incident model
        $incident = new IncidentAnnouncement();

        // Set the attributes on the model instance
        $incident->title = $validatedData['title'];
        $incident->published = $validatedData['published'];
        $incident->category_id = $validatedData['category'];
        $incident->publisher_id = $validatedData['publisher'];
        $incident->description =$validatedData['description'] ;
        $incident->url_link = $validatedData['url_link'];
        $incident->date_incident = Carbon::createFromFormat('d/M/Y',$validatedData['date_incident'])->format('Y-m-d');

        // Save the incident to the database
        $incident->save();
        if(!empty($validatedData['relatedcategory'])){
            $incident->relatedCategories()->attach($validatedData['relatedcategory']);
        }
        switch($request->input('action')){
            case "save_notify_all":
                $users = User::all();
                Notification::send($users,new IncidentNotification($incident,'save_notify_all'));
                break;
            case "save_notify_admin":
                $users = User::role('admin')->get();
                Notification::send($users,new IncidentNotification($incident,'save_notify_admin'));
                break;
        }
        // Redirect to the index page with a success message
        return redirect()->route('incident.index')->with('success', 'Incident added successfully.');
    }

    public function edit($id)
    {
        $categories = IncidentCategory::orderBy('name','asc')->get();
        $publishers = Publisher::orderBy('name','asc')->get();
        $incident = IncidentAnnouncement::findOrFail($id);
        $selectedCategories = $incident->relatedCategories;
        return view('incident.edit', compact(['incident','categories','publishers','selectedCategories']));
    }

    public function update(Request $request, $id)
    {
        // Code to update the incident

        // Validate the incoming request data
        $validatedData = $request->validate([
            'title' => 'required|string',
            'category' => 'required',
            'relatedcategory' => '',
            'publisher' => 'required',
            'url_link' => 'required',
            'description' =>'required',
            'published' =>'required',
            'date_incident' => 'required|date_format:d/M/Y',
        ]);
         // Create a new instance of the incident model
         $incident = IncidentAnnouncement::findOrFail($id);
         if ($incident){

            if(!is_numeric($validatedData['category'])){
                $law_category = new IncidentCategory();
                $law_category->name = $validatedData['category'];
                $law_category->save();
                $validatedData['category']=$law_category->id;
            }
            
            if(!empty($validatedData['relatedcategory'])){
                foreach($validatedData['relatedcategory'] as $key=>$category){
                    if(!is_numeric($category) && trim($category) != '' ){
                        $law_category = new IncidentCategory();
                        $law_category->name = $category;
                        $law_category->save();
                        $validatedData['relatedcategory'][$key]=$law_category->id;
                    }
                }
            }
    
            if(!is_numeric($validatedData['publisher'])){
                $publisher = new Publisher();
                $publisher->name = $validatedData['publisher'];
                $publisher->save();
                $validatedData['publisher']=$publisher->id;
            }
             // Set the attributes on the model instance
            $incident->title = $validatedData['title'];
            $incident->published = $validatedData['published'];
            $incident->category_id = $validatedData['category'];
            $incident->publisher_id = $validatedData['publisher'];
            $incident->description =$validatedData['description'];
            $incident->url_link = $validatedData['url_link'];
            $incident->date_incident = Carbon::createFromFormat('d/M/Y',$validatedData['date_incident'])->format('Y-m-d');
    
            // update the incident to the database
            $incident->save();
            
            $incident->relatedCategories()->detach();   
            if(!empty($validatedData['relatedcategory'])){
                $incident->relatedCategories()->attach($validatedData['relatedcategory']);
            }
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