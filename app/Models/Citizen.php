<?php

namespace App\Models;

// use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Citizen extends Model
{
    use HasFactory;

    protected $hidden = ['password'];
    protected $primaryKey = 'id';

    //citizen can have many sectors
    public function sectors()
    {
        return $this->hasMany(Sector::class);
    }
    //citizen can have many service attendance
    public function serviceAttendances()
    {
        return $this->hasMany(ServiceAttendance::class);
    }



    protected $appends = ['age'];

    public function getAgeAttribute()
    {
        return Carbon::parse($this->attributes['birthdate'])->age;
    }
}
