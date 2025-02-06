<?php

namespace App\Http\Controllers;

use App\Models\knowledgebase;
use App\Models\knowledgebaseCategory;
use App\Models\Publisher;
use App\Models\User;
use App\Notifications\knowledgebaseNotification;
use Illuminate\Http\Request;
use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Facades\View;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;

class knowledgebaseController extends Controller
{
    public function index(Request $request)
    {
        $query = knowledgebase::query();
        $search ="";
        // Searching
        if ($request->has('search')) {
            $search = $request->input('search');
            if(strtolower($request->input('sort'))!=='category.name'){
                $query->join('knowledgebase_categories','knowledgebases.category_id','=','knowledgebase_categories.id');
            }
                $query->join('publishers','knowledgebase.publisher_id','=','publishers.id')
                ->where('title', 'like', "%$search%")
                ->orWhere('description', 'like', "%$search%")
                ->orWhere('knowledgebases_categories.name', 'like', "%$search%")
                ->orWhere('publishers.name', 'like', "%$search%");

            
            if (DateTime::createFromFormat('d/M/Y',$search) !== false){
                $searchDate = Carbon::createFromFormat('d/M/Y',$search)->format('Y-m-d');
                $query->orWhere('date_knowledgebase','like',"%$searchDate%");
            }

            $query->select('knowledgebase.*');

        }


        $knowledgebases = $query->sortable(['date_knowledgebase'=>'desc'])->paginate(15);
        return view('knowledgebase.index', compact('knowledgebases','search'));
    }

    public function whatsnewindex(Request $request)
    {
        $query = knowledgebase::query();
        $search ="";
        $twoWeeksAgoDate = Carbon::today()->subDays(14);
        // Searching
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->join('knowledgebase_categories','knowledgebase.category_id','=','knowledgebase_categories.id')
            ->join('publishers','knowledgebase.publisher_id','=','publishers.id')
                ->where('knowledgebase.created_at','>=',$twoWeeksAgoDate)
                ->where(function($subquery) use ($search){    
                    $subquery->where('title', 'like', "%$search%")
                    ->orWhere('description', 'like', "%$search%")
                    ->orWhere('knowledgebase_categories.name', 'like', "%$search%")
                    ->orWhere('publishers.name', 'like', "%$search%");
                });
            
            if (DateTime::createFromFormat('d/M/Y',$search) !== false){
                $searchDate = Carbon::createFromFormat('d/M/Y',$search)->format('Y-m-d');
                $query->orWhere('date_knowledgebase','like',"%$searchDate%");
            }
            $query->select('knowledgebase.*');

        }else{
            $query->where('created_at','>=',$twoWeeksAgoDate);
        }


        $knowledgebases = $query->sortable(['created_at'=>'desc'])->paginate(15);
        return view('knowledgebase.index', compact('knowledgebases','search'));
    }
    public function create(){
        $categories = knowledgebaseCategory::orderBy('name','asc')->get();
        $publishers = Publisher::orderBy('name','asc')->get();
        return view('knowledgebase.create',compact(['categories','publishers']));
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
            'date_knowledgebase' => 'required|date_format:d/M/Y',
        ]);

        if(!is_numeric($validatedData['category'])){
            $law_category = new knowledgebaseCategory();
            $law_category->name = $validatedData['category'];
            $law_category->save();
            $validatedData['category']=$law_category->id;
        }
        
        if(!empty($validatedData['relatedcategory'])){
            foreach($validatedData['relatedcategory'] as $key=>$category){
                if(!is_numeric($category) && trim($category) != '' ){
                    $law_category = new knowledgebaseCategory();
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

        // Create a new instance of the knowledgebase model
        $knowledgebase = new knowledgebase();

        // Set the attributes on the model instance
        $knowledgebase->published = $validatedData['published'];
        $knowledgebase->title = $validatedData['title'];
        $knowledgebase->category_id = $validatedData['category'];
        $knowledgebase->publisher_id = $validatedData['publisher'];
        $knowledgebase->description =$validatedData['description'];
        $knowledgebase->url_link = $validatedData['url_link'];
        $knowledgebase->date_knowledgebase = Carbon::createFromFormat('d/M/Y',$validatedData['date_knowledgebase'])->format('Y-m-d');

        // Save the knowledgebase to the database
        $knowledgebase->save();
         if(!empty($validatedData['relatedcategory'])){
             $knowledgebase->relatedCategories()->attach($validatedData['relatedcategory']);
         }
        switch($request->input('action')){
            case "save_notify_all":
                $users = User::all();
                Notification::send($users,new knowledgebaseNotification($knowledgebase,'save_notify_all'));
                break;
            case "save_notify_admin":
                $users = User::role('admin')->get();
                Notification::send($users,new knowledgebaseNotification($knowledgebase,'save_notify_admin'));
                break;
        }
        // Redirect to the index page with a success message
        return redirect()->route('knowledgebase.index')->with('success', 'knowledgebase added successfully.');
    }

    public function edit($id)
    {
        $categories = knowledgebaseCategory::orderBy('name','asc')->get();
        $publishers = Publisher::orderBy('name','asc')->get();
        $knowledgebase = knowledgebase::findOrFail($id);
        $selectedCategories = $knowledgebase->relatedCategories;
        return view('knowledgebases.edit', compact(['knowledgebase','categories','publishers','selectedCategories']));
    }

    public function update(Request $request, $id)
    {
        // Code to update the knowledgebase

        // Validate the incoming request data
        $validatedData = $request->validate([
            'title' => 'required|string',
            'category' => 'required',
            'relatedcategory' => '',
            'publisher' => 'required',
            'url_link' => 'required',
            'description' =>'required',
            'published' =>'required',
            'date_knowledgebase' => 'required|date_format:d/M/Y',
        ]);
         // Create a new instance of the knowledgebase model
         $knowledgebase = knowledgebase::findOrFail($id);
         if ($knowledgebase){

            if(!is_numeric($validatedData['category'])){
                $law_category = new knowledgebaseCategory();
                $law_category->name = $validatedData['category'];
                $law_category->save();
                $validatedData['category']=$law_category->id;
            }
            
            if(!empty($validatedData['relatedcategory'])){
                foreach($validatedData['relatedcategory'] as $key=>$category){
                    if(!is_numeric($category) && trim($category) != '' ){
                        $law_category = new knowledgebaseCategory();
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
            $knowledgebase->title = $validatedData['title'];
            $knowledgebase->published = $validatedData['published'];
            $knowledgebase->category_id = $validatedData['category'];
            $knowledgebase->publisher_id = $validatedData['publisher'];
            $knowledgebase->description =$validatedData['description'];
            $knowledgebase->url_link = $validatedData['url_link'];
            $knowledgebase->date_knowledgebase = Carbon::createFromFormat('d/M/Y',$validatedData['date_knowledgebase'])->format('Y-m-d');
    
            // update the knowledgebase to the database
            $knowledgebase->save();
            
            $knowledgebase->relatedCategories()->detach();   
            if(!empty($validatedData['relatedcategory'])){
                $knowledgebase->relatedCategories()->attach($validatedData['relatedcategory']);
            }
            return redirect()->route('knowledgebase.index')->with('success', 'knowledgebase updated successfully.');
        }else{
            return redirect()->route('knowledgebase.index')->with('error', 'knowledgebase maybe updated or deleted, please try again.');
        }

        
    }



    public function deleteSelected(Request $request)
    {
        try {
            $selectedIds = $request->input('selectedIds');
            if (!empty($selectedIds)) {
                knowledgebase::whereIn('id', explode(',', $selectedIds))->delete();
                return redirect()->route('knowledgebase.index')->with('success', 'Selected knowledgebases deleted successfully.');
            } else {
                return redirect()->route('knowledgebase.index')->with('error', 'No knowledgebase selected for deletion.');
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
                $knowledgebases = knowledgebase::whereIn('id', explode(',', $selectedIds))->get();
                foreach($knowledgebases as $key => $knowledgebase){
                    $newknowledgebase = $knowledgebase->replicate();
                    $newknowledgebase->created_at = Carbon::now();
                    $newknowledgebase->save();
                }
                return redirect()->route('knowledgebase.index')->with('success', 'Selected knowledgebases copied successfully.');
            } else {
                return redirect()->route('knowledgebase.index')->with('error', 'No knowledgebase selected for copy.');
            }
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }
    }

}