<?php

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;
use App\Services\CustomerService;
use Illuminate\Database\Eloquent\Collection;
use App\Services\CustomerServiceInvoiceService;

class customerServiceInvoice extends Component
{
    public Collection|\Illuminate\Support\Collection $invoices;
    public $selected_invoice = null;
    public $field_name = 'CSI_id';

    
    public function mount()
    {
        $this->invoices = app()->make(CustomerServiceInvoiceService::class)->getCustomerServiceInvoicesForSelectDropDown();
    }

    public function render()
    {
        return view('livewire.dashboard.customer-service-invoice');
    }
}