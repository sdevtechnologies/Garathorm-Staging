<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\IncidentAnnouncement;
use App\Models\IndustryReference;
use App\Models\LawsFrameworkTb;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        
        $laws =  DB::table('law_category_laws_framework_tb')->get();
        foreach($laws as $law){
            $findLaw = LawsFrameworkTb::withTrashed()->findOrFail($law->laws_framework_tb_id);
            if ($findLaw){
                $findLaw->category_id = $law->law_category_id;
                $findLaw->save();
            }
            
        }

        $industries = DB::table('industry_category_industry_reference')->get();
        foreach($industries as $industry){
            $findIndustry = IndustryReference::withTrashed()->findOrFail($industry->industry_reference_id);
            if ($findIndustry){
                $findIndustry->category_id = $industry->industry_category_id;
                $findIndustry->save();
            }
        }
        
        $incidents = DB::table('incident_category_incident_announcement')->get();
        foreach($incidents as $incident){
            $findIncident = IncidentAnnouncement::withTrashed()->findOrFail($incident->incident_announcement_id);
            if ($findIncident){
                $findIncident->category_id = $incident->incident_category_id;
                $findIncident->save();
            }

            
        }
            
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
