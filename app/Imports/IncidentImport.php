<?php

namespace App\Imports;

use App\Models\IncidentAnnouncement;
use App\Models\IncidentCategory;
use App\Models\Publisher;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class IncidentImport implements ToModel, WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function model(array $row)
    {
        //dd($row);
        $categoryId ="";
        $category = IncidentCategory::where('name',trim($row['category']))->first();
        if ($category){
            $categoryId = $category->id;
        }else{
            $category = new IncidentCategory();
            $category->name = trim($row['category']);
            $category->save();
            $categoryId = $category->id;
        }

        $publisherId ="";
        if (trim($row['publisher'])==""){
            $row['publisher'] = "N/A";
        }
        $publisher = Publisher::where('name',trim($row['publisher']))->first();
        if ($publisher){
            $publisherId = $publisher->id;
        }else{
            $publisher = new Publisher();
            $publisher->name = trim($row['publisher']);
            $publisher->save();
            $publisherId = $publisher->id;
        }
        return new IncidentAnnouncement([
            "title" => $row['document_title'],
            "category_id" => $categoryId,
            "publisher_id" => $publisherId,
            "date_incident" => Date::excelToDateTimeObject($row['date_incident'])->format('Y-m-d'),
            "url_link" => $row['url'],
            "description" => $row['description'],
        ]);
    }
}
