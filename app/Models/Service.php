<?php

namespace App\Models;

// use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Service extends Model
{
    use HasFactory;



    protected $primaryKey = 'id';
    // protected $dateFormat = 'y-m-d';
    protected $fillable = ['id', 'barangay_id', 'user_id', 'serviceType', 'serviceTitle', 'serviceStatus', 'numberOfBeneficiaries', 'serviceDescription', 'serviceImage'];

    //service can have many service attendance
    public function serviceAttendances()
    {
        return $this->hasMany(ServiceAttendance::class);
    }

    public function barangay()
    {
        return $this->belongsTo(Barangay::class);
    }
    public function admin()
    {
        return $this->belongsTo(User::class);
    }
}
