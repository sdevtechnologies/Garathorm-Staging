<?php

namespace App\Http\Controllers;

use App\Models\Knowledgebase;
use App\Models\KnowledgebaseCategory;
use App\Models\UserAssignedForm;
use App\Models\Publisher;
use App\Models\User;
use App\Notifications\KnowledgebaseNotification;
use Illuminate\Http\Request;
use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Facades\View;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\File;

class KnowledgebaseController extends Controller
{
    public function index(Request $request)
    {
        $query = Knowledgebase::query();
        $search ="";
        // Searching
        if ($request->has('search')) {
            $search = $request->input('search');
            if(strtolower($request->input('sort'))!=='category.name'){
                $query->join('knowledgebase_categories','knowledgebases.category_id','=','knowledgebase_categories.id');
            }
                $query
                ->where('title', 'like', "%$search%")
                ->orWhere('description', 'like', "%$search%")
                ->orWhere('knowledgebase_categories.name', 'like', "%$search%");

            $query->select('knowledgebases.*');

        }


        $knowledgebases = $query->paginate(15);
        return view('knowledgebase.index', compact('knowledgebases','search'));
    }

    public function whatsnewindex(Request $request)
    {
        $query = Knowledgebase::query();
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
        $categories = KnowledgebaseCategory::orderBy('name','asc')->get();
        $publishers = Publisher::orderBy('name','asc')->get();
        $users = User::all();

        return view('knowledgebase.create',compact(['categories','publishers','users']));
    }

    public function store(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'title' => 'required|string',
            'category' => 'required',
            'assignusers' => '',
            'mandatory' => 'required',
            'image' => 'nullable|mimes:jpg,jpeg,gif,txt,pdf|max:2048',
            'url_link' => 'nullable|string',
            'description' =>'required',
            'status' => 'required',
        ]);

        if(!is_numeric($validatedData['category'])){
            $law_category = new KnowledgebaseCategory();
            $law_category->name = $validatedData['category'];
            $law_category->save();
            $validatedData['category']=$law_category->id;
        }
        
        if(!empty($validatedData['assignusers'])){
            foreach($validatedData['assignusers'] as $key=>$category){
                if(!is_numeric($category) && trim($category) != '' ){
                    $law_category = new UserAssignedForm();
                    $law_category->name = $category;
                    $law_category->status = 0;
                    $law_category->save();
                    $validatedData['assignusers'][$key]=$law_category->id;
                }
            }
        }

        if(!empty($validatedData['image'])){
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            
            $filename = time().'.'.$extension;
            $path = 'uploads/knowledgebase/';
            $file->move($path, $filename);
            $validatedData['image'] = $path.$filename;
        }
        else{
            $validatedData['image'] = NULL;
        }

        // Create a new instance of the knowledgebase model
        $knowledgebase = new Knowledgebase();

        // Set the attributes on the model instance
        $knowledgebase->title = $validatedData['title'];
        $knowledgebase->category_id = $validatedData['category'];
        $knowledgebase->mandatory = $validatedData['mandatory'];
        $knowledgebase->image = $validatedData['image'];
        $knowledgebase->url_link = $validatedData['url_link'] ?? '';
        $knowledgebase->description =$validatedData['description'];
        $knowledgebase->status =$validatedData['status'];

        // Save the knowledgebase to the database
        $knowledgebase->save();
         if(!empty($validatedData['assignusers'])){
             $knowledgebase->relatedCategories()->attach($validatedData['assignusers']);
         }
        switch($request->input('action')){
            case "save_notify_all":
                $users = User::all();
                Notification::send($users,new KnowledgebaseNotification($knowledgebase,'save_notify_all'));
                break;
            case "save_notify_admin":
                $users = User::role('admin')->get();
                Notification::send($users,new KnowledgebaseNotification($knowledgebase,'save_notify_admin'));
                break;
        }
        // Redirect to the index page with a success message
        return redirect()->route('knowledgebases.index')->with('success', 'knowledgebase added successfully.');
    }

    public function edit($id)
    {
        $categories = KnowledgebaseCategory::orderBy('name','asc')->get();
        //$publishers = Publisher::orderBy('name','asc')->get();
        $knowledgebase = Knowledgebase::findOrFail($id);
        $selectedCategories = $knowledgebase->relatedCategories;
        $users = User::all();
        return view('knowledgebase.edit', compact(['knowledgebase','categories','selectedCategories','users']));
    }

    public function update(Request $request, $id)
    {
        // Code to update the knowledgebase

        // Validate the incoming request data
        $validatedData = $request->validate([
            'title' => 'required|string',
            'category' => 'required',
            'assignusers' => '',
            'mandatory' => 'required',
            'image' => 'nullable|mimes:jpg,jpeg,gif,txt,pdf|max:20000',
            'url_link' => 'required',
            'description' =>'required',
            'status' => 'required'
        ]);
         // Create a new instance of the knowledgebase model
         $knowledgebase = Knowledgebase::findOrFail($id);
         if ($knowledgebase){

            if(!is_numeric($validatedData['category'])){
                $law_category = new KnowledgebaseCategory();
                $law_category->name = $validatedData['category'];
                $law_category->save();
                $validatedData['category']=$law_category->id;
            }
            
            if(!empty($validatedData['assignusers'])){
                foreach($validatedData['assignusers'] as $key=>$category){
                    if(!is_numeric($category) && trim($category) != '' ){
                        $law_category = new UserAssignedForm();
                        $law_category->name = $category;
                        $law_category->status = $category;
                        $law_category->save();
                        $validatedData['assignusers'][$key]=$law_category->id;
                    }
                }
            }

            if(!empty($validatedData['image'])){
                $file = $request->file('image');
                $extension = $file->getClientOriginalExtension();
                
                $filename = time().'.'.$extension;
                $path = 'uploads/knowledgebase/';
                $file->move($path, $filename);

                if(File::exists($knowledgebase->image)){
                    File::delete($knowledgebase->image);
                }

                $validatedData['image'] = $path.$filename;
            }
            else{
                $validatedData['image'] = NULL;
            }
    

             // Set the attributes on the model instance
             $knowledgebase->title = $validatedData['title'];
             $knowledgebase->category_id = $validatedData['category'];
             $knowledgebase->mandatory = $validatedData['mandatory'];
             $knowledgebase->image = $validatedData['image'];
             $knowledgebase->url_link = $validatedData['url_link'];
             $knowledgebase->description =$validatedData['description'];
             $knowledgebase->status =$validatedData['status'];
    
            // update the knowledgebase to the database
            $knowledgebase->save();
            
            $knowledgebase->relatedCategories()->detach();   
            if(!empty($validatedData['assignusers'])){
                $knowledgebase->relatedCategories()->attach($validatedData['assignusers']);
            }
            return redirect()->route('knowledgebases.index')->with('success', 'knowledgebase updated successfully.');
        }else{
            return redirect()->route('knowledgebases.index')->with('error', 'knowledgebase maybe updated or deleted, please try again.');
        }

        
    }



    public function deleteSelected(Request $request)
    {
        try {
            $selectedIds = $request->input('selectedIds');
            if (!empty($selectedIds)) {
                knowledgebase::whereIn('id', explode(',', $selectedIds))->delete();
                return redirect()->route('knowledgebases.index')->with('success', 'Selected knowledgebases deleted successfully.');
            } else {
                return redirect()->route('knowledgebases.index')->with('error', 'No knowledgebase selected for deletion.');
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
                return redirect()->route('knowledgebases.index')->with('success', 'Selected knowledgebases copied successfully.');
            } else {
                return redirect()->route('knowledgebases.index')->with('error', 'No knowledgebase selected for copy.');
            }
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }
    }

}