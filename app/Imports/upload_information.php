<?php

namespace App\Imports;

use App\Models\department;
use App\Models\hashd;
use App\Models\personal_info;
use DateTime;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class upload_information implements ToCollection, WithHeadingRow
{
    /**
     * @param Collection $collection
     */
    public function collection(Collection $rows)
    {

        foreach ($rows as $row) {


            if (!empty($row['id_patient'])) {


                $personal_info_check = personal_info::where('id', $row['id_patient'])->first();

                // dd($department->id);

                if (!$personal_info_check) {
                    // Create a new department if it doesn't exist


                    if ($row['phone'] == null) {
                        $phone  = '0000 000 0000';
                    } else {
                        $phone  = $row['phone'];
                    }

                    if ($row['note'] == null) {
                        $note  = 'لا يوجد';
                    } else {
                        $note  = $row['note'];
                    }



                    $excelbirthday = $row['brithday'];
                    $birthday = date("Y-m-d", strtotime("1900-01-01 +$excelbirthday days"));


                    $excelcheck_date = $row['date'];
                    $check_date = date("Y-m-d", strtotime("1900-01-01 +$excelcheck_date days"));


                    $new_patient =  new personal_info();
                    $new_patient->id = $row['id_patient'];;
                    $new_patient->name = $row['name'];
                    // $new_patient->birthday = $row['brithday'];
                    $new_patient->birthday = $birthday;
                    $new_patient->check_date = $check_date;
                    $new_patient->patient_phone = $phone;
                    $new_patient->type_patient = $row['sex'];
                    $new_patient->note_patient = $note;

                    $new_patient->save();
                }
            }
        }
    }
}
