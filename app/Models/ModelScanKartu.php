<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelScanKartu extends Model
{
   
    use HasFactory;
    protected $table = 'scan_kartu'; // Define the table name

    protected $fillable = [
        'status'
    ];
}
