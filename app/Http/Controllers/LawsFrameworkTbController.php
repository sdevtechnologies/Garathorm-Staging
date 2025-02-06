<?php

namespace App\Http\Controllers;

use App\Models\LawCategory;
use App\Models\Publisher;
use App\Notifications\SendEmail;
use Illuminate\Http\Request;
use App\Models\LawsFrameworkTb;
use App\Models\User;
use App\Notifications\LawsNotification;
use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Facades\View;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;

//NOTE: not specifying type may pose problem - php does support typecasting
class LawsFrameworkTbController extends Controller
{
    public function index(Request $request)
    {
        $query = LawsFrameworkTb::query();
        $search ="";
        // Searching
        if ($request->has('search')) {
            $search = $request->input('search');
            if(strtolower($request->input('sort'))!=='category.name'){
                $query->join('law_categories','laws_framework_tb.category_id','=','law_categories.id');
            }
            $query->join('publishers','laws_framework_tb.publisher_id','=','publishers.id')
                ->where('title', 'like', "%$search%")
                ->orWhere('description', 'like', "%$search%")
                ->orWhere('law_categories.name', 'like', "%$search%")
                ->orWhere('publishers.name', 'like', "%$search%");

            if (DateTime::createFromFormat('d/M/Y',$search) !== false){
                $searchDate = Carbon::createFromFormat('d/M/Y',$search)->format('Y-m-d');
                $query->orWhere('date_published','like',"%$searchDate%");
            }

            $query->select('laws_framework_tb.*');
        
        }


        $laws = $query->sortable(['date_published'=>'desc'])->paginate(15);
        return view('laws.index', compact('laws','search'));
    }

    public function whatsnewindex(Request $request)
    {
        $query = LawsFrameworkTb::query();
        $search ="";
        $twoWeeksAgoDate = Carbon::today()->subDays(14);
        // Searching
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->join('law_categories','laws_framework_tb.category_id','=','law_categories.id')
            ->join('publishers','laws_framework_tb.publisher_id','=','publishers.id')
                ->where('laws_framework_tb.created_at','>=',$twoWeeksAgoDate)
                ->where(function($subquery) use ($search){
                    $subquery->where('title', 'like', "%$search%")
                    ->orWhere('description', 'like', "%$search%")
                    ->orWhere('law_categories.name', 'like', "%$search%")
                    ->orWhere('publishers.name', 'like', "%$search%");
                });

            if (DateTime::createFromFormat('d/M/Y',$search) !== false){
                $searchDate = Carbon::createFromFormat('d/M/Y',$search)->format('Y-m-d');
                $query->orWhere('date_published','like',"%$searchDate%");
            }
           

            $query->select('laws_framework_tb.*');
        
        }else{
            $query->where('created_at','>=',$twoWeeksAgoDate);
        }

        //dd($query);
        $laws = $query->sortable(['created_at'=>'desc'])->paginate(15);
        return view('laws.index', compact('laws','search'));
    }
    public function create(){
        $categories = LawCategory::orderBy('name','asc')->get();
        $publishers = Publisher::orderBy('name','asc')->get();
        return view('laws.create',compact(['categories','publishers']));
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
            $law_category = new LawCategory();
            $law_category->name = $validatedData['category'];
            $law_category->save();
            $validatedData['category']=$law_category->id;
        }
        
        if(!empty($validatedData['relatedcategory'])){
            foreach($validatedData['relatedcategory'] as $key=>$category){
                if(!is_numeric($category) && trim($category) != '' ){
                    $law_category = new LawCategory();
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

        // Create a new instance of the LawsFrameworkTb model
        $law = new LawsFrameworkTb();
        // Set the attributes on the model instance
        $law->title = $validatedData['title'];
        $law->category_id = $validatedData['category'];
        $law->publisher_id = $validatedData['publisher'];
        $law->description =  $validatedData['description'];
        $law->url_link = $validatedData['url_link'];
        $law->published = $validatedData['published'];
        $law->date_published = Carbon::createFromFormat('d/M/Y',$validatedData['date_published'])->format('Y-m-d');

        // Save the law to the database
        $law->save();
        if(!empty($validatedData['relatedcategory'])){
            $law->relatedCategories()->attach($validatedData['relatedcategory']);
        }

        switch($request->input('action')){
            case "save_notify_all":
                $users = User::all();
                Notification::send($users,new LawsNotification($law,'save_notify_all'));
                break;
            case "save_notify_admin":
                $users = User::role('admin')->get();
                Notification::send($users,new LawsNotification($law,'save_notify_admin'));
                break;
        }


        // Redirect to the index page with a success message
        return redirect()->route('laws.index')->with('success', 'Law added successfully.');
    }

    public function edit($id)
    {
        $law = LawsFrameworkTb::findOrFail($id);
        $categories = LawCategory::orderBy('name','asc')->get();
        $publishers = Publisher::orderBy('name','asc')->get();
        $selectedCategories = $law->relatedCategories;
        return view('laws.edit', compact(['law','categories','publishers','selectedCategories']));
    }

    public function update(Request $request, $id)
    {
        // Code to update the law

        // Validate the incoming request data
        $validatedData = $request->validate([
            'title' => 'required|string',
            'category' => 'required',
            'relatedcategory' => '',
            'published' => 'required',
            'publisher' => 'required',
            'url_link' => 'required',
            'description' =>'required',
            'date_published' => 'required|date_format:d/M/Y',
        ]);
         // Create a new instance of the LawsFrameworkTb model
         $law = LawsFrameworkTb::findOrFail($id);
         if ($law){

            if(!is_numeric($validatedData['category'])){
                $law_category = new LawCategory();
                $law_category->name = $validatedData['category'];
                $law_category->save();
                $validatedData['category']=$law_category->id;
            }
            
            if(!empty($validatedData['relatedcategory'])){
                foreach($validatedData['relatedcategory'] as $key=>$category){
                    if(!is_numeric($category) && trim($category) != '' ){
                        $law_category = new LawCategory();
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
            $law->title = $validatedData['title'];
            $law->published = $validatedData['published'];
            $law->category_id = $validatedData['category'];
            $law->publisher_id = $validatedData['publisher'];
            $law->description =$validatedData['description'];
            $law->url_link =  $validatedData['url_link'];
            $law->date_published = Carbon::createFromFormat('d/M/Y',$validatedData['date_published'])->format('Y-m-d');
    
            // update the law to the database
            $law->save();
            
            $law->relatedCategories()->detach();   
            if(!empty($validatedData['relatedcategory'])){
                $law->relatedCategories()->attach($validatedData['relatedcategory']);
            }

            return redirect()->route('laws.index')->with('success', 'Law updated successfully.');
        }else{
            return redirect()->route('laws.index')->with('error', 'Law maybe updated or deleted, please try again.');
        }

        
    }

    public function destroy($id)
    {
        $law = LawsFrameworkTb::findOrFail($id);
        $law->delete();
        return redirect()->route('laws.index')->with('success', 'Law deleted successfully.');
    }

    public function deleteSelected(Request $request)
    {
        try {
            $selectedIds = $request->input('selectedIds');
            if (!empty($selectedIds)) {
                LawsFrameworkTb::whereIn('id', explode(',', $selectedIds))->delete();
                return redirect()->route('laws.index')->with('success', 'Selected laws deleted successfully.');
            } else {
                return redirect()->route('laws.index')->with('error', 'No law selected for deletion.');
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
                $Laws = LawsFrameworkTb::whereIn('id', explode(',', $selectedIds))->get();
                foreach($Laws as $key => $Law){
                    $newLaw = $Law->replicate();
                    $newLaw->created_at = Carbon::now();
                    $newLaw->save();
                }
                return redirect()->route('laws.index')->with('success', 'Selected laws copied successfully.');
            } else {
                return redirect()->route('laws.index')->with('error', 'No law selected for copy.');
            }
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }
    }
/*
    public function search(Request $request)
    {
        $search = $request->input('search');
        $laws = LawsFrameworkTb::where('title', 'like', "%$search%")
            ->orWhere('description', 'like', "%$search%")
            ->get();

        return view('laws.index', compact('laws'));
    }

    // Change your sort method like this
    public function sort(Request $request)
    {
        $query = LawsFrameworkTb::query();

        // Sorting
        $column = $request->input('column', 'title');
        $direction = $request->input('direction', 'asc');
        $query->orderBy($column, $direction);

        $laws = $query->get();

        // Render only the table body content
        $view = View::make('laws.table_body', compact('laws'))->render();

        return response()->json(['html' => $view]);
    }
*/
}
