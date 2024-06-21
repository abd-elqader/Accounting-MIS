<?php

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;
use Illuminate\Database\Eloquent\Collection;
use App\Services\SupplierProductInvoiceService;


class SupplierProductInvoice extends Component
{
    public Collection|\Illuminate\Support\Collection $invoices;
    public $selected_invoice = null;
    public $field_name = 'SPI_id';

    
    public function mount()
    {
        $this->invoices = app()->make(SupplierProductInvoiceService::class)->getSupplierProductInvoicesForSelectDropDown();
    }

    public function render()
    {
        return view('livewire.dashboard.supplier-product-invoice');
    }
}