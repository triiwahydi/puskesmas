<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelKartu extends Model
{
   
    use HasFactory;
    protected $table = 'kartu'; // Define the table name

    protected $fillable = [
        'no_kartu',
        'status',
        'id_pasien',
    ];
}
