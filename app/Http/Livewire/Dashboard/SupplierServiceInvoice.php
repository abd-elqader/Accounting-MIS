<?php

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;
use App\Services\SupplierService;
use Illuminate\Database\Eloquent\Collection;
use App\Services\SupplierServiceInvoiceService;

class SupplierServiceInvoice extends Component
{
    public Collection|\Illuminate\Support\Collection $invoices;
    public $selected_invoice = null;
    public $field_name = 'SSI_id';

    
    public function mount()
    {
        $this->invoices = app()->make(SupplierServiceInvoiceService::class)->getSupplierServiceInvoicesForSelectDropDown();
    }

    public function render()
    {
        return view('livewire.dashboard.supplier-service-invoice');
    }
}