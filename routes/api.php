<?php

use App\Models\IncidentAnnouncement;
use App\Models\IndustryReference;
use App\Models\LawsFrameworkTb;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->get('/getLaws',function (Request $request){
    $laws = LawsFrameworkTb::join('publishers','laws_framework_tb.publisher_id','=','publishers.id')->where('published',1)->orderBy('laws_framework_tb.created_at','desc')->get(['title','url_link','description','date_published','publishers.name'])->toJson();
    return $laws;
});

Route::middleware('auth:sanctum')->get('/getIndustries',function (Request $request){
    $industry = IndustryReference::join('publishers','industry_references.publisher_id','=','publishers.id')->where('published',1)->orderBy('industry_references.created_at','desc')->get(['title','url_link','description','date_published','publishers.name'])->toJson();
    return $industry;
});
Route::middleware('auth:sanctum')->get('/getIncidents',function (Request $request){
    $incident = IncidentAnnouncement::join('publishers','incident_announcements.publisher_id','=','publishers.id')->where('published',1)->orderBy('incident_announcements.created_at','desc')->get(['title','url_link','description','date_incident','publishers.name'])->toJson();
    return $incident;
});

Route::post('/apilogin',function(Request $request){
    $data= $request->validate([
        'email' => ['required','email','exists:users'],
        'password' => ['required']
    ]);
    $user = User::where('email',$data['email'])->first();
    if (!$user || !Hash::check($data['password'], $user->password)){
        return response([
            'message'=> 'Bad Credentials'
        ],401);
    }
    

    $token = $user->createToken('auth_token')->plainTextToken;

    return [
        'token' => $token
    ];
});



