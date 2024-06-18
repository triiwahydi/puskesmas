<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelLiveAntrian extends Model
{
   
    use HasFactory;
    protected $table = 'antrian_live'; // Define the table name

    protected $fillable = [
        'no_antrian',
        'nama',
        'alamat'
    ];
}
