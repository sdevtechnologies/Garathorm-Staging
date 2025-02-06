<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\AnnouncementCategory;
use App\Models\Publisher;
use App\Models\User;
use App\Notifications\AnnouncementNotification;
use Illuminate\Http\Request;
use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Facades\View;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;

class AnnouncementController extends Controller
{
    public function index(Request $request)
    {
        $query = Announcement::query();
        $search ="";
        // Searching
        if ($request->has('search')) {
            $search = $request->input('search');
            if(strtolower($request->input('sort'))!=='category.name'){
                $query->join('announcement_categories','announcements.category_id','=','announcement_categories.id');
            }
                $query->join('publishers','announcements.publisher_id','=','publishers.id')
                ->where('title', 'like', "%$search%")
                ->orWhere('description', 'like', "%$search%")
                ->orWhere('announcement_categories.name', 'like', "%$search%")
                ->orWhere('publishers.name', 'like', "%$search%");

            
            if (DateTime::createFromFormat('d/M/Y',$search) !== false){
                $searchDate = Carbon::createFromFormat('d/M/Y',$search)->format('Y-m-d');
                $query->orWhere('date_announcement','like',"%$searchDate%");
            }

            $query->select('announcements.*');

        }


        $announcements = $query->sortable(['date_announcement'=>'desc'])->paginate(15);
        return view('announcement.index', compact('announcements','search'));
    }

    public function whatsnewindex(Request $request)
    {
        $query = Announcement::query();
        $search ="";
        $twoWeeksAgoDate = Carbon::today()->subDays(14);
        // Searching
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->join('announcement_categories','announcement.category_id','=','announcement_categories.id')
            ->join('publishers','announcements.publisher_id','=','publishers.id')
                ->where('announcement.created_at','>=',$twoWeeksAgoDate)
                ->where(function($subquery) use ($search){    
                    $subquery->where('title', 'like', "%$search%")
                    ->orWhere('description', 'like', "%$search%")
                    ->orWhere('announcement_categories.name', 'like', "%$search%")
                    ->orWhere('publishers.name', 'like', "%$search%");
                });
            
            if (DateTime::createFromFormat('d/M/Y',$search) !== false){
                $searchDate = Carbon::createFromFormat('d/M/Y',$search)->format('Y-m-d');
                $query->orWhere('date_announcement','like',"%$searchDate%");
            }
            $query->select('announcement.*');

        }else{
            $query->where('created_at','>=',$twoWeeksAgoDate);
        }


        $announcements = $query->sortable(['created_at'=>'desc'])->paginate(15);
        return view('announcement.index', compact('announcements','search'));
    }
    public function create(){
        $categories = announcementCategory::orderBy('name','asc')->get();
        $publishers = Publisher::orderBy('name','asc')->get();
        return view('announcement.create',compact(['categories','publishers']));
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
            'date_announcement' => 'required|date_format:d/M/Y',
        ]);

        if(!is_numeric($validatedData['category'])){
            $law_category = new announcementCategory();
            $law_category->name = $validatedData['category'];
            $law_category->save();
            $validatedData['category']=$law_category->id;
        }
        
        if(!empty($validatedData['relatedcategory'])){
            foreach($validatedData['relatedcategory'] as $key=>$category){
                if(!is_numeric($category) && trim($category) != '' ){
                    $law_category = new announcementCategory();
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

        // Create a new instance of the announcement model
        $announcement = new announcement();

        // Set the attributes on the model instance
        $announcement->published = $validatedData['published'];
        $announcement->title = $validatedData['title'];
        $announcement->category_id = $validatedData['category'];
        $announcement->publisher_id = $validatedData['publisher'];
        $announcement->description =$validatedData['description'];
        $announcement->url_link = $validatedData['url_link'];
        $announcement->date_announcement = Carbon::createFromFormat('d/M/Y',$validatedData['date_announcement'])->format('Y-m-d');

        // Save the announcement to the database
        $announcement->save();
         if(!empty($validatedData['relatedcategory'])){
             $announcement->relatedCategories()->attach($validatedData['relatedcategory']);
         }
        switch($request->input('action')){
            case "save_notify_all":
                $users = User::all();
                Notification::send($users,new announcementNotification($announcement,'save_notify_all'));
                break;
            case "save_notify_admin":
                $users = User::role('admin')->get();
                Notification::send($users,new announcementNotification($announcement,'save_notify_admin'));
                break;
        }
        // Redirect to the index page with a success message
        return redirect()->route('announcement.index')->with('success', 'announcement added successfully.');
    }

    public function edit($id)
    {
        $categories = announcementCategory::orderBy('name','asc')->get();
        $publishers = Publisher::orderBy('name','asc')->get();
        $announcement = announcement::findOrFail($id);
        $selectedCategories = $announcement->relatedCategories;
        return view('announcement.edit', compact(['announcement','categories','publishers','selectedCategories']));
    }

    public function update(Request $request, $id)
    {
        // Code to update the announcement

        // Validate the incoming request data
        $validatedData = $request->validate([
            'title' => 'required|string',
            'category' => 'required',
            'relatedcategory' => '',
            'publisher' => 'required',
            'url_link' => 'required',
            'description' =>'required',
            'published' =>'required',
            'date_announcement' => 'required|date_format:d/M/Y',
        ]);
         // Create a new instance of the announcement model
         $announcement = announcement::findOrFail($id);
         if ($announcement){

            if(!is_numeric($validatedData['category'])){
                $law_category = new announcementCategory();
                $law_category->name = $validatedData['category'];
                $law_category->save();
                $validatedData['category']=$law_category->id;
            }
            
            if(!empty($validatedData['relatedcategory'])){
                foreach($validatedData['relatedcategory'] as $key=>$category){
                    if(!is_numeric($category) && trim($category) != '' ){
                        $law_category = new AnnouncementCategory();
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
            $announcement->title = $validatedData['title'];
            $announcement->published = $validatedData['published'];
            $announcement->category_id = $validatedData['category'];
            $announcement->publisher_id = $validatedData['publisher'];
            $announcement->description =$validatedData['description'];
            $announcement->url_link = $validatedData['url_link'];
            $announcement->date_announcement = Carbon::createFromFormat('d/M/Y',$validatedData['date_announcement'])->format('Y-m-d');
    
            // update the announcement to the database
            $announcement->save();
            
            $announcement->relatedCategories()->detach();   
            if(!empty($validatedData['relatedcategory'])){
                $announcement->relatedCategories()->attach($validatedData['relatedcategory']);
            }
            return redirect()->route('announcement.index')->with('success', 'announcement updated successfully.');
        }else{
            return redirect()->route('announcement.index')->with('error', 'announcement maybe updated or deleted, please try again.');
        }

        
    }



    public function deleteSelected(Request $request)
    {
        try {
            $selectedIds = $request->input('selectedIds');
            if (!empty($selectedIds)) {
                announcement::whereIn('id', explode(',', $selectedIds))->delete();
                return redirect()->route('announcement.index')->with('success', 'Selected announcements deleted successfully.');
            } else {
                return redirect()->route('announcement.index')->with('error', 'No announcement selected for deletion.');
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
                $announcements = announcement::whereIn('id', explode(',', $selectedIds))->get();
                foreach($announcements as $key => $announcement){
                    $newannouncement = $announcement->replicate();
                    $newannouncement->created_at = Carbon::now();
                    $newannouncement->save();
                }
                return redirect()->route('announcement.index')->with('success', 'Selected announcements copied successfully.');
            } else {
                return redirect()->route('announcement.index')->with('error', 'No announcement selected for copy.');
            }
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }
    }

}