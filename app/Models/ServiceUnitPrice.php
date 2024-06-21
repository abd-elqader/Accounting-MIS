<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceUnitPrice extends Model
{
    use HasFactory;

    protected $fillable = [
        'price',
        'service_id',
        'currency_id',
    ];
}
