<?php

namespace App\Http\Controllers;

use App\Models\IndustryCategory;
use App\Models\IndustryReference;
use App\Models\Publisher;
use App\Models\User;
use App\Notifications\IndustryNotification;
use Illuminate\Http\Request;
use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Facades\View;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;

class IndustryReferenceController extends Controller
{
    //
    public function index(Request $request)
    {
        $query = IndustryReference::query();
        $search ="";
        // Searching
        if ($request->has('search')) {
            $search = $request->input('search');
            if(strtolower($request->input('sort'))!=='category.name'){
                $query->join('industry_categories','industry_references.category_id','=','industry_categories.id');
            }
                $query->join('publishers','industry_references.publisher_id','=','publishers.id')
                ->where('title', 'like', "%$search%")
                ->orWhere('description', 'like', "%$search%")
                ->orWhere('industry_categories.name', 'like', "%$search%")
                ->orWhere('publishers.name', 'like', "%$search%");

            if (DateTime::createFromFormat('d/M/Y',$search) !== false){
                $searchDate = Carbon::createFromFormat('d/M/Y',$search)->format('Y-m-d');
                $query->orWhere('date_published','like',"%$searchDate%");
            }
            $query->select('industry_references.*');
        }


        $industries = $query->sortable(['date_published'=>'desc'])->paginate(15);
        return view('industry.index', compact('industries','search'));
    }

    public function whatsnewindex(Request $request)
    {
        $query = IndustryReference::query();
        $search ="";
        $twoWeeksAgoDate = Carbon::today()->subDays(14);
        // Searching
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->join('industry_categories','industry_references.category_id','=','industry_categories.id')
            ->join('publishers','industry_references.publisher_id','=','publishers.id')
                ->where('industry_references.created_at','>=',$twoWeeksAgoDate)
                ->where(function($subquery) use ($search){    
                    $subquery->where('title', 'like', "%$search%")
                    ->orWhere('description', 'like', "%$search%")
                    ->orWhere('industry_categories.name', 'like', "%$search%")
                    ->orWhere('publishers.name', 'like', "%$search%");
                });

            if (DateTime::createFromFormat('d/M/Y',$search) !== false){
                $searchDate = Carbon::createFromFormat('d/M/Y',$search)->format('Y-m-d');
                $query->orWhere('date_published','like',"%$searchDate%");
            }
            $query->where('industry_references.created_at','>=',$twoWeeksAgoDate);
            $query->select('industry_references.*');
        }else{
            $query->where('created_at','>=',$twoWeeksAgoDate);
        }


        $industries = $query->sortable(['created_at'=>'desc'])->paginate(15);
        return view('industry.index', compact('industries','search'));
    }
    public function create(){
        $categories = IndustryCategory::orderBy('name','asc')->get();
        $publishers = Publisher::orderBy('name','asc')->get();
        return view('industry.create',compact(['categories','publishers']));
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
            'published' => 'required',
            'date_published' => 'required|date_format:d/M/Y',
        ]);

        if(!is_numeric($validatedData['category'])){
            $law_category = new IndustryCategory();
            $law_category->name = $validatedData['category'];
            $law_category->save();
            $validatedData['category']=$law_category->id;
        }
        
        if(!empty($validatedData['relatedcategory'])){
            foreach($validatedData['relatedcategory'] as $key=>$category){
                if(!is_numeric($category) && trim($category) != '' ){
                    $law_category = new IndustryCategory();
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

        // Create a new instance of the Industry model
        $industry = new IndustryReference();

        // Set the attributes on the model instance
        $industry->title = $validatedData['title'];
        $industry->category_id = $validatedData['category'];
        $industry->publisher_id = $validatedData['publisher'];
        $industry->description =  $validatedData['description'];
        $industry->url_link = $validatedData['url_link'];
        $industry->published = $validatedData['published'];
        $industry->date_published = Carbon::createFromFormat('d/M/Y',$validatedData['date_published'])->format('Y-m-d');

        // Save the industry to the database
        $industry->save();
        if(!empty($validatedData['relatedcategory'])){
            $industry->relatedCategories()->attach($validatedData['relatedcategory']);
        }

        switch($request->input('action')){
            case "save_notify_all":
                $users = User::all();
                Notification::send($users,new IndustryNotification($industry,'save_notify_all'));
                break;
            case "save_notify_admin":
                $users = User::role('admin')->get();
                Notification::send($users,new IndustryNotification($industry,'save_notify_admin'));
                break;
        }
        // Redirect to the index page with a success message
        return redirect()->route('industry.index')->with('success', 'Industry added successfully.');
    }

    public function edit($id)
    {
        $industry = IndustryReference::findOrFail($id);
        $categories = IndustryCategory::orderBy('name','asc')->get();
        $publishers = Publisher::orderBy('name','asc')->get();
        $selectedCategories = $industry->relatedCategories;
        return view('industry.edit', compact(['industry','categories','publishers','selectedCategories']));
    }

    public function update(Request $request, $id)
    {
        // Code to update the industry

        // Validate the incoming request data
        $validatedData = $request->validate([
            'title' => 'required|string',
            'category' => 'required',
            'relatedcategory' => '',
            'publisher' => 'required',
            'published' => 'required',
            'url_link' => 'required',
            'description' =>'required',
            'date_published' => 'required|date_format:d/M/Y',
        ]);
         // Create a new instance of the industry model
         $industry = IndustryReference::findOrFail($id);
         if ($industry){
            if(!is_numeric($validatedData['category'])){
                $law_category = new IndustryCategory();
                $law_category->name = $validatedData['category'];
                $law_category->save();
                $validatedData['category']=$law_category->id;
            }
            
            if(!empty($validatedData['relatedcategory'])){
                foreach($validatedData['relatedcategory'] as $key=>$category){
                    if(!is_numeric($category) && trim($category) != '' ){
                        $law_category = new IndustryCategory();
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
            $industry->title = $validatedData['title'];
            $industry->published = $validatedData['published'];
            $industry->category_id = $validatedData['category'];
            $industry->publisher_id = $validatedData['publisher'];
            $industry->description = $validatedData['description'];
            $industry->url_link =  $validatedData['url_link'];
            $industry->date_published = Carbon::createFromFormat('d/M/Y',$validatedData['date_published'])->format('Y-m-d');
    
            // update the industry to the database
            $industry->save();
            $industry->relatedCategories()->detach();   
            if(!empty($validatedData['relatedcategory'])){
                $industry->relatedCategories()->attach($validatedData['relatedcategory']);
            }
            return redirect()->route('industry.index')->with('success', 'Industry updated successfully.');
        }else{
            return redirect()->route('industry.index')->with('error', 'Industry maybe updated or deleted, please try again.');
        }

        
    }



    public function deleteSelected(Request $request)
    {
        try {
            $selectedIds = $request->input('selectedIds');
            if (!empty($selectedIds)) {
                IndustryReference::whereIn('id', explode(',', $selectedIds))->delete();
                return redirect()->route('industry.index')->with('success', 'Selected industries deleted successfully.');
            } else {
                return redirect()->route('industry.index')->with('error', 'No industry selected for deletion.');
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
                $industries = IndustryReference::whereIn('id', explode(',', $selectedIds))->get();
                foreach($industries as $key => $industry){
                    $newIndustry = $industry->replicate();
                    $newIndustry->created_at = Carbon::now();
                    $newIndustry->save();
                }
                return redirect()->route('industry.index')->with('success', 'Selected industries copied successfully.');
            } else {
                return redirect()->route('industry.index')->with('error', 'No industry selected for copy.');
            }
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }
    }

}
