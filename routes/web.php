<?php

use App\Http\Controllers\DNSCategoryController;
use App\Http\Controllers\DNSController;
use App\Http\Controllers\ImportController;
use App\Http\Controllers\IncidentAnnouncementController;
use App\Http\Controllers\IncidentCategoryController;
use App\Http\Controllers\IndustryCategoryController;
use App\Http\Controllers\IndustryReferenceController;
use App\Http\Controllers\LawCategoryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LawsFrameworkTbController;
use App\Http\Controllers\PublisherController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VAPTCategoryController;
use App\Http\Controllers\VAPTController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AnnouncementController; 
use App\Http\Controllers\AnnouncementCategoryController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/



Route::get('/', function () {
    return redirect('/incident');
});

Route::middleware('admin')->group(function(){

    //for import
    Route::get('/import', function () {
        return view('upload');
    })->name('import.index');
    Route::post('/import',[ImportController::class,'import'])->name('import');

    //Routes for User
    Route::get('/user', [UserController::class, 'index'])->name('user.index');
    Route::get('/user/{id}/edit', [UserController::class, 'edit'])->name('user.edit');
    Route::put('/user/{id}', [UserController::class, 'update'])->name('user.update');
    Route::delete('/user/delete-selected', [UserController::class, 'deleteSelected'])->name('user.deleteSelected');
    
    //law category
    Route::get('/lawcategory', [LawCategoryController::class, 'index'])->name('lawcategory.index');
    Route::get('/lawcategory/create', [LawCategoryController::class, 'create'])->name('lawcategory.create');
    Route::post('/lawcategory', [LawCategoryController::class, 'store'])->name('lawcategory.store');
    Route::get('/lawcategory/{lawCategory}/edit', [LawCategoryController::class, 'edit'])->name('lawcategory.edit');
    Route::put('/lawcategory/{lawCategory}', [LawCategoryController::class, 'update'])->name('lawcategory.update');
    Route::delete('/lawcategory/delete-selected', [LawCategoryController::class, 'deleteSelected'])->name('lawcategory.deleteSelected');
    
    //publisher
    Route::get('/publisher', [PublisherController::class, 'index'])->name('publisher.index');
    Route::get('/publisher/create', [PublisherController::class, 'create'])->name('publisher.create');
    Route::post('/publisher', [PublisherController::class, 'store'])->name('publisher.store');
    Route::get('/publisher/{publisher}/edit', [PublisherController::class, 'edit'])->name('publisher.edit');
    Route::put('/publisher/{publisher}', [PublisherController::class, 'update'])->name('publisher.update');
    Route::delete('/publisher/delete-selected', [PublisherController::class, 'deleteSelected'])->name('publisher.deleteSelected');
    

    //industry category
    Route::get('/indcategory', [IndustryCategoryController::class, 'index'])->name('indcategory.index');
    Route::get('/indcategory/create', [IndustryCategoryController::class, 'create'])->name('indcategory.create');
    Route::post('/indcategory', [IndustryCategoryController::class, 'store'])->name('indcategory.store');
    Route::get('/indcategory/{industryCategory}/edit', [IndustryCategoryController::class, 'edit'])->name('indcategory.edit');
    Route::put('/indcategory/{industryCategory}', [IndustryCategoryController::class, 'update'])->name('indcategory.update');
    Route::delete('/indcategory/delete-selected', [IndustryCategoryController::class, 'deleteSelected'])->name('indcategory.deleteSelected');
    
    //incident category
    Route::get('/inccategory', [IncidentCategoryController::class, 'index'])->name('inccategory.index');
    Route::get('/inccategory/create', [IncidentCategoryController::class, 'create'])->name('inccategory.create');
    Route::post('/inccategory', [IncidentCategoryController::class, 'store'])->name('inccategory.store');
    Route::get('/inccategory/{incidentCategory}/edit', [IncidentCategoryController::class, 'edit'])->name('inccategory.edit');
    Route::put('/inccategory/{incidentCategory}', [IncidentCategoryController::class, 'update'])->name('inccategory.update');
    Route::delete('/inccategory/delete-selected', [IncidentCategoryController::class, 'deleteSelected'])->name('inccategory.deleteSelected');
    /*  
    //DNS category
    Route::get('/dnscategory', [DNSCategoryController::class, 'index'])->name('dnscategory.index');
    Route::get('/dnscategory/create', [DNSCategoryController::class, 'create'])->name('dnscategory.create');
    Route::post('/dnscategory', [DNSCategoryController::class, 'store'])->name('dnscategory.store');
    Route::get('/dnscategory/{dNSCategory}/edit', [DNSCategoryController::class, 'edit'])->name('dnscategory.edit');
    Route::put('/dnscategory/{dNSCategory}', [DNSCategoryController::class, 'update'])->name('dnscategory.update');
    Route::delete('/dnscategory/delete-selected', [DNSCategoryController::class, 'deleteSelected'])->name('dnscategory.deleteSelected');
    
    //VAPT category
    Route::get('/vaptcategory', [VAPTCategoryController::class, 'index'])->name('vaptcategory.index');
    Route::get('/vaptcategory/create', [VAPTCategoryController::class, 'create'])->name('vaptcategory.create');
    Route::post('/vaptcategory', [VAPTCategoryController::class, 'store'])->name('vaptcategory.store');
    Route::get('/vaptcategory/{vAPTCategory}/edit', [VAPTCategoryController::class, 'edit'])->name('vaptcategory.edit');
    Route::put('/vaptcategory/{vAPTCategory}', [VAPTCategoryController::class, 'update'])->name('vaptcategory.update');
    Route::delete('/vaptcategory/delete-selected', [VAPTCategoryController::class, 'deleteSelected'])->name('vaptcategory.deleteSelected');
    
*/

    //Routes for DNS
    Route::get('/DNS', [DNSController::class, 'index'])->name('DNS.index');
    Route::get('/DNS/create', [DNSController::class, 'create'])->name('DNS.create');
    Route::post('/DNS', [DNSController::class, 'store'])->name('DNS.store');
    Route::get('/DNS/{id}/edit', [DNSController::class, 'edit'])->name('DNS.edit');
    Route::put('/DNS/{id}', [DNSController::class, 'update'])->name('DNS.update');
    Route::delete('/DNS/delete-selected', [DNSController::class, 'deleteSelected'])->name('DNS.deleteSelected');
    Route::post('/DNS/copy-selected', [DNSController::class, 'copySelected'])->name('DNS.copySelected');

    //Routes for VAPT
    Route::get('/VAPT', [VAPTController::class, 'index'])->name('VAPT.index');
    Route::get('/VAPT/create', [VAPTController::class, 'create'])->name('VAPT.create');
    Route::post('/VAPT', [VAPTController::class, 'store'])->name('VAPT.store');
    Route::get('/VAPT/{id}/edit', [VAPTController::class, 'edit'])->name('VAPT.edit');
    Route::put('/VAPT/{id}', [VAPTController::class, 'update'])->name('VAPT.update');
    Route::delete('/VAPT/delete-selected', [VAPTController::class, 'deleteSelected'])->name('VAPT.deleteSelected');
    Route::post('/VAPT/copy-selected', [VAPTController::class, 'copySelected'])->name('VAPT.copySelected');

    Route::get('/announcement', [AnnouncementController::class, 'index'])->name('announcement.index');
    Route::get('/announcement/create', [AnnouncementController::class, 'create'])->name('announcement.create');
    Route::post('/announcement', [AnnouncementController::class, 'store'])->name('announcement.store');
    Route::get('/announcement/{announcement}/edit', [AnnouncementController::class, 'edit'])->name('announcement.edit');
    Route::put('/announcement/{announcement}', [AnnouncementController::class, 'update'])->name('announcement.update');
    Route::delete('/announcement/delete-selected', [AnnouncementController::class, 'deleteSelected'])->name('announcement.deleteSelected');
    Route::post('/announcement/copy-selected', [AnnouncementController::class, 'copySelected'])->name('announcement.copySelected');

    Route::get('/announcementcategory', [AnnouncementCategoryController::class, 'index'])->name('announcementcategory.index');
    Route::get('/announcementcategory/create', [AnnouncementCategoryController::class, 'create'])->name('announcementcategory.create');
    Route::post('/announcementcategory', [AnnouncementCategoryController::class, 'store'])->name('announcementcategory.store');
    Route::get('/announcementcategory/{incidentCategory}/edit', [AnnouncementCategoryController::class, 'edit'])->name('announcementcategory.edit');
    Route::put('/announcementcategory/{incidentCategory}', [AnnouncementCategoryController::class, 'update'])->name('announcementcategory.update');
    Route::delete('/announcementcategory/delete-selected', [AnnouncementCategoryController::class, 'deleteSelected'])->name('announcementcategory.deleteSelected');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    //Routes for LAWS AND FRAMEWORK pages
    Route::get('/laws', [LawsFrameworkTbController::class, 'index'])->name('laws.index');
    Route::get('/whatsnew/laws', [LawsFrameworkTbController::class, 'whatsnewindex'])->name('laws.whatsnewindex');
    Route::get('/laws/create', [LawsFrameworkTbController::class, 'create'])->name('laws.create');
    Route::post('/laws', [LawsFrameworkTbController::class, 'store'])->name('laws.store');
    Route::get('/laws/{id}/edit', [LawsFrameworkTbController::class, 'edit'])->name('laws.edit');
    Route::put('/laws/{id}', [LawsFrameworkTbController::class, 'update'])->name('laws.update');
    Route::delete('/laws/delete-selected', [LawsFrameworkTbController::class, 'deleteSelected'])->name('laws.deleteSelected');
    Route::post('/laws/copy-selected', [LawsFrameworkTbController::class, 'copySelected'])->name('laws.copySelected');
    //Route::get('/laws/search', [LawsFrameworkTbController::class, 'search'])->name('laws.search');
    //Route::get('/laws/sort', [LawsFrameworkTbController::class, 'sort'])->name('laws.sort');


    //Routes for Industry References
    Route::get('/industry', [IndustryReferenceController::class, 'index'])->name('industry.index');
    Route::get('/whatsnew/industry', [IndustryReferenceController::class, 'whatsnewindex'])->name('industry.whatsnewindex');
    Route::get('/industry/create', [IndustryReferenceController::class, 'create'])->name('industry.create');
    Route::post('/industry', [IndustryReferenceController::class, 'store'])->name('industry.store');
    Route::get('/industry/{id}/edit', [IndustryReferenceController::class, 'edit'])->name('industry.edit');
    Route::put('/industry/{id}', [IndustryReferenceController::class, 'update'])->name('industry.update');
    Route::delete('/industry/delete-selected', [IndustryReferenceController::class, 'deleteSelected'])->name('industry.deleteSelected');
    Route::post('/industry/copy-selected', [IndustryReferenceController::class, 'copySelected'])->name('industry.copySelected');

    //Routes for Incidents
    Route::get('/incident', [IncidentAnnouncementController::class, 'index'])->name('incident.index');
    Route::get('/whatsnew/incident', [IncidentAnnouncementController::class, 'whatsnewindex'])->name('incident.whatsnewindex');
    Route::get('/incident/create', [IncidentAnnouncementController::class, 'create'])->name('incident.create');
    Route::post('/incident', [IncidentAnnouncementController::class, 'store'])->name('incident.store');
    Route::get('/incident/{id}/edit', [IncidentAnnouncementController::class, 'edit'])->name('incident.edit');
    Route::put('/incident/{id}', [IncidentAnnouncementController::class, 'update'])->name('incident.update');
    Route::delete('/incident/delete-selected', [IncidentAnnouncementController::class, 'deleteSelected'])->name('incident.deleteSelected');
    Route::post('/incident/copy-selected', [IncidentAnnouncementController::class, 'copySelected'])->name('incident.copySelected');


    Route::get('/announcement', [AnnouncementController::class, 'index'])->name('announcement.index');
    Route::get('/whatsnew/announcement', [AnnouncementController::class, 'whatsnewindex'])->name('announcement.whatsnewindex');
    Route::get('/announcement/create', [AnnouncementController::class, 'create'])->name('announcement.create');
    Route::post('/announcement', [AnnouncementController::class, 'store'])->name('announcement.store');
    Route::get('/announcement/{id}/edit', [AnnouncementController::class, 'edit'])->name('announcement.edit');
    Route::put('/announcement/{id}', [AnnouncementController::class, 'update'])->name('announcement.update');
    Route::delete('/announcement/delete-selected', [AnnouncementController::class, 'deleteSelected'])->name('announcement.deleteSelected');
    Route::post('/announcement/copy-selected', [AnnouncementController::class, 'copySelected'])->name('announcement.copySelected');

    
});



require __DIR__ . '/auth.php';
