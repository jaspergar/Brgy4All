<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brgy_Worker extends Model
{
    use HasFactory;

    // protected $hidden = ['brgy_worker_password'];
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'brgy_worker_username', 'brgy_worker_fullname', 'brgy_worker_email', 'brgy_worker_password'];
}
