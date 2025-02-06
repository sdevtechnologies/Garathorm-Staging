<?php

namespace App\Imports;

use App\Models\IndustryCategory;
use App\Models\IndustryReference;
use App\Models\Publisher;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class IndustryImport implements ToModel, WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function model(array $row)
    {
        //dd($row);
        //dd($row);
        $categoryId ="";
        $category = IndustryCategory::where('name',trim($row['category']))->first();
        if ($category){
            $categoryId = $category->id;
        }else{
            $category = new IndustryCategory();
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
        return new IndustryReference([
            "title" => $row['document_title'],
            "category_id" => $categoryId,
            "publisher_id" => $publisherId,
            "date_published" => Date::excelToDateTimeObject($row['date_published'])->format('Y-m-d'),
            "url_link" => $row['url'],
            "description" => $row['description'],
        ]);
    }
}
