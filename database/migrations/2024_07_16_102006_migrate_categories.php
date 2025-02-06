<?php

use App\Models\IncidentAnnouncement;
use App\Models\IndustryReference;
use App\Models\LawsFrameworkTb;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        //get existing laws entry and migrate categories to multiple;
        /*
        $laws = LawsFrameworkTb::withTrashed()->get();
        foreach($laws as $law){
            DB::table('law_category_laws_framework_tb')->insert([
                'laws_framework_tb_id' => $law->id,
                'law_category_id' => $law->category_id
            ]);
        }

        $industries = IndustryReference::withTrashed()->get();
        foreach($industries as $industry){
            DB::table('industry_category_industry_reference')->insert([
                'industry_reference_id' => $industry->id,
                'industry_category_id' => $industry->category_id
            ]);
        }
        $incidents = IncidentAnnouncement::withTrashed()->get();
        foreach($incidents as $incident){
            DB::table('incident_category_incident_announcement')->insert([
                'incident_announcement_id' => $incident->id,
                'incident_category_id' => $incident->category_id
            ]);
        }

        
        */

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
