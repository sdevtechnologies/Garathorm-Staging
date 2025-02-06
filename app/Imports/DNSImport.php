<?php

namespace App\Imports;

use App\Models\DNS;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class DNSImport implements ToModel, WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function model(array $row)
    {
        //dd($row);
        return new DNS([
            "title" => $row['document_title'],
            "category" => $row['category'],
            "date_issue" => Date::excelToDateTimeObject($row['date_issue'])->format('Y-m-d'),
            "url_link" => $row['url'],
            "description" => $row['description'],
        ]);
    }
}
