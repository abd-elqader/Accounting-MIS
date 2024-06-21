<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'brand',
        'tax',
        'taxable',
        'description',
        'stock',
        'type',
        'daily_income',
        'weekly_income',
        'monthly_income',
        'yearly_income',
        'category_id',
        'department_id',
    ];

    public function unitPrices(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(ProductUnitPrice::class,  'product_id');
    }


}
