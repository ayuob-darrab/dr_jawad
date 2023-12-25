<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class personal_info extends Model
{
    use HasFactory;
    protected $table = 'personal_info';
    protected $fillable =  [
        'id','name', 'birthday', 'check_date', 'note_patient', 'type_patient', 'patient_phone',
    ];





    // public function dep_show_name()
    public function patient_show_name()
    {

        // $decryptedDepartmentId = AesHelper::encrypt_information($this->department_id);
        return $this->belongsTo('App\Models\personal_info', 'patient_id', 'id'); //->where('id', $decryptedDepartmentId);
    }

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'updated_at', 'created_at',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [];
}
