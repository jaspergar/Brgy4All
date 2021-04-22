<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sector extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';

    //A sector can be have in citizen
    public function citizen()
    {
        return $this->belongsTo(Citizen::class);
    }
}
