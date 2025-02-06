<?php

namespace Database\Seeders;

use App\Models\IncidentCategory;
use App\Models\IndustryCategory;
use App\Models\LawCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $lawCategory = LawCategory::create([
            'name' => 'BSP'
        ]);
        $lawCategory = LawCategory::create([
            'name' => 'CEH'
        ]);
        $lawCategory = LawCategory::create([
            'name' => 'CVE'
        ]);
        $lawCategory = LawCategory::create([
            'name' => 'Data Centers'
        ]);
        $lawCategory = LawCategory::create([
            'name' => 'DBM'
        ]);
        $lawCategory = LawCategory::create([
            'name' => 'DFAR'
        ]);
        $lawCategory = LawCategory::create([
            'name' => 'DOD'
        ]);
        $lawCategory = LawCategory::create([
            'name' => 'FAR'
        ]);
        $lawCategory = LawCategory::create([
            'name' => 'GDPR'
        ]);
        $lawCategory = LawCategory::create([
            'name' => 'HIPAA (HITECH)'
        ]);
        $lawCategory = LawCategory::create([
            'name' => 'IEEE'
        ]);
        $lawCategory = LawCategory::create([
            'name' => 'INCOTERMS'
        ]);
        $lawCategory = LawCategory::create([
            'name' => 'ISO'
        ]);
        $lawCategory = LawCategory::create([
            'name' => 'ITT OR NTC'
        ]);
        $lawCategory = LawCategory::create([
            'name' => 'KEV'
        ]);
        $lawCategory = LawCategory::create([
            'name' => 'KPR'
        ]);
        $lawCategory = LawCategory::create([
            'name' => 'MILSPEC'
        ]);
        $lawCategory = LawCategory::create([
            'name' => 'NIST'
        ]);
        $lawCategory = LawCategory::create([
            'name' => 'NPC'
        ]);
        $lawCategory = LawCategory::create([
            'name' => 'NSA'
        ]);
        $lawCategory = LawCategory::create([
            'name' => 'OSCE'
        ]);
        $lawCategory = LawCategory::create([
            'name' => 'OWASP'
        ]);
        $lawCategory = LawCategory::create([
            'name' => 'OWASP MOB'
        ]);
        $lawCategory = LawCategory::create([
            'name' => 'PCI-DSS'
        ]);
        $lawCategory = LawCategory::create([
            'name' => "Republic Acts & IRR's"
        ]);
        $lawCategory = LawCategory::create([
            'name' => 'SANS'
        ]);
        $lawCategory = LawCategory::create([
            'name' => 'SEC'
        ]);
        $lawCategory = LawCategory::create([
            'name' => 'SWIFT'
        ]);


        $industryCategory = IndustryCategory::create([
            'name' => 'CII'
        ]);
        $industryCategory = IndustryCategory::create([
            'name' => 'CVE'
        ]);
        $industryCategory = IndustryCategory::create([
            'name' => 'DNS'
        ]);
        $industryCategory = IndustryCategory::create([
            'name' => 'GDPR'
        ]);
        $industryCategory = IndustryCategory::create([
            'name' => 'HIPAA'
        ]);
        $industryCategory = IndustryCategory::create([
            'name' => 'IAM'
        ]);
        $industryCategory = IndustryCategory::create([
            'name' => 'ISO'
        ]);
        $industryCategory = IndustryCategory::create([
            'name' => 'KEV'
        ]);
        $industryCategory = IndustryCategory::create([
            'name' => 'KPR'
        ]);
        $industryCategory = IndustryCategory::create([
            'name' => 'MOBILE'
        ]);
        $industryCategory = IndustryCategory::create([
            'name' => 'NIST'
        ]);
        $industryCategory = IndustryCategory::create([
            'name' => 'OWASP'
        ]);
        $industryCategory = IndustryCategory::create([
            'name' => 'OWASP MOB'
        ]);
        $industryCategory = IndustryCategory::create([
            'name' => 'PCI'
        ]);
        $industryCategory = IndustryCategory::create([
            'name' => 'SANS'
        ]);
        $industryCategory = IndustryCategory::create([
            'name' => 'WEB'
        ]);

        $incidentCategory = IncidentCategory::create([
            'name' => 'CARD FRAUD'
        ]);
        $incidentCategory = IncidentCategory::create([
            'name' => 'CI'
        ]);
        $incidentCategory = IncidentCategory::create([
            'name' => 'CLOUD'
        ]);
        $incidentCategory = IncidentCategory::create([
            'name' => 'GDPR'
        ]);
        $incidentCategory = IncidentCategory::create([
            'name' => 'HACKING'
        ]);
        $incidentCategory = IncidentCategory::create([
            'name' => 'HIPAA'
        ]);
        $incidentCategory = IncidentCategory::create([
            'name' => 'HOSTING'
        ]);
        $incidentCategory = IncidentCategory::create([
            'name' => 'IDENTITY'
        ]);
        $incidentCategory = IncidentCategory::create([
            'name' => 'ISO'
        ]);
        $incidentCategory = IncidentCategory::create([
            'name' => 'NATION STATE'
        ]);
        $incidentCategory = IncidentCategory::create([
            'name' => 'NIST'
        ]);
        $incidentCategory = IncidentCategory::create([
            'name' => 'PCI'
        ]);
        $incidentCategory = IncidentCategory::create([
            'name' => 'RANSOMWARE'
        ]);

    }
}
