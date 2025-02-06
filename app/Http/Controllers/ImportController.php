<?php

namespace App\Http\Controllers;

use App\Imports\DNSImport;
use App\Imports\IncidentImport;
use App\Imports\LawImport;
use App\Imports\IndustryImport;
use App\Imports\VAPTImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ImportController extends Controller
{
    //

    public function import(Request $request){
        $request->validate([
            'Form' => 'required',
            'file' => 'required|mimes:xlsx,xls',
        ]);

        $file = $request->file('file');
        switch ($request->Form) {
            case 'Law':
                $import = new LawImport;
                break;
            case 'Industry':
                    $import = new IndustryImport;
                    break;
            case 'Incident':
                $import = new IncidentImport;
                break;
            case 'DNS':
                $import = new DNSImport;
                break;
            case 'VAPT':
                $import = new VAPTImport;
                break;
            default:
                # code...
                break;
        }
       
        Excel::import($import,$file);
        return redirect()->route('import.index')->with('success','Imported successfully.');
    }
}
