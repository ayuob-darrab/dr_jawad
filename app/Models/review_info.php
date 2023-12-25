<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class review_info extends Model
{
    use HasFactory;
    protected $table = 'review_info';
    protected $fillable =  [
        'id', 'patient_id', 'path', 'code', 'check_date',
    ];






    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'updated_at', 'created_at',
    ];


    public function patient_show_name()
    {

        // $decryptedDepartmentId = AesHelper::encrypt_information($this->department_id);
        return $this->belongsTo('App\Models\personal_info', 'patient_id', 'id'); //->where('id', $decryptedDepartmentId);
    }

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [];
}
