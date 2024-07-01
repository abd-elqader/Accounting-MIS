<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerServiceInvoice extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'customer_service_invoices';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * Upload Path
     */
    const UPLOADPATH = 'images/';

    /**
     * fields that will handle upload document
     */
    const UPLOADFIELDS = [];

    ##--------------------------------- RELATIONSHIPS


    ##--------------------------------- ATTRIBUTES


    ##--------------------------------- CUSTOM FUNCTIONS


    public function CustomerServiceInvoiceItems(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(CustomerServiceInvoiceItem::class,  'CPI_id', );
    }
    public function CustomerServiceInvoiceTaxs(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(CustomerServiceInvoiceTax::class,  'CPI_id', );
    }
}
