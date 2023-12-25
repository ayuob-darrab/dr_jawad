<?php

namespace App\Imports;

use App\Models\department;
use App\Models\review_info;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;


class upload_department implements ToCollection, WithHeadingRow
{
    /**
     * @param Collection $collection
     */
    public function collection(Collection $rows)
    {


        foreach ($rows as $row) {
            if (!empty($row['pat_image'])) {

                // Create a new department if it doesn't exist

                $excelcheck_date = $row['date'];
                $check_date = date("Y-m-d", strtotime("1900-01-01 +$excelcheck_date days"));


                $file = $row['imagename'] . '.'.'PNG';
                $patient_visit =  new review_info();
                $patient_visit->patient_id = $row['pat_image'];
                $patient_visit->check_date = $check_date;
                $patient_visit->path = $file;

                $patient_visit->save();
            }
        }
    }
}
