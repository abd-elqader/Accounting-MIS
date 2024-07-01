<?php

namespace App\Services;

use App\DTO\CustomerServiceInvoice\CustomerServiceInvoiceDTO;
use App\Exceptions\NotFoundException;
use App\Models\customerServiceInvoice;
use App\Models\Service;
use App\Models\Tax;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

use App\QueryFilters\CustomerServiceInvoiceFilters;
use Exception;
use Illuminate\Support\Facades\DB;

class CustomerServiceInvoiceService extends BaseService
{
    public function __construct(private CustomerServiceInvoice $model){

    }

    public function getModel(): Model
    {
        return $this->model;
    }

    public function queryGet(array $filters = [] , array $withRelations = []) :builder
    {
        $customerAddresses = $this->getModel()->query()->with($withRelations);
        return (new CustomerServiceInvoiceFilters($filters))->apply($customerAddresses);
    }

    public function getAll(array $filters = [] , array $withRelations =[], $perPage = null ): \Illuminate\Contracts\Pagination\CursorPaginator|\Illuminate\Database\Eloquent\Collection
    {
        if($perPage)
            return $this->queryGet(filters: $filters,withRelations: $withRelations)->cursorPaginate($perPage);
        else
            return $this->queryGet(filters: $filters,withRelations: $withRelations)->get();
    }

    public function getCustomerServiceInvoicesForSelectDropDown(array $filters = []): \Illuminate\Database\Eloquent\Collection|array
    {
        return $this->queryGet(filters: $filters)->select(['id'])->get();
    }

    public function store(CustomerServiceInvoiceDTO $DTO):Model|bool
    {
        // $data['is_active'] = isset($data['is_active']) ? ActivationStatusEnum::ACTIVE:ActivationStatusEnum::NOT_ACTIVE;
        $invoiceData = $DTO->invoiceData();
        DB::beginTransaction();
        $customerServiceInvoice = $this->getModel()->create($invoiceData);
        $invoiceItemsData = $this->prepareInvoiceItemsData(currency: $invoiceData['currency_id'], invoiceItems: $DTO->invoiceItems());
        if($invoiceItemsData)
            $customerServiceInvoice->customerServiceInvoiceItems()->createMany($invoiceItemsData);
        $invoiceTaxesData = $this->prepareInvoiceTaxesData(invoiceTaxes: $DTO->invoiceTaxes());
        if($invoiceTaxesData)
            $customerServiceInvoice->customerServiceInvoiceTaxs()->createMany($invoiceTaxesData);
        $this->refreshInvoice(invoice: $customerServiceInvoice);
        DB::commit();
        if (!$customerServiceInvoice)
            return false ;
        return $customerServiceInvoice;
    } //end of store


    private function refreshInvoice(customerServiceInvoice $invoice)
    {
        $totalServicesCost = $invoice->customerServiceInvoiceItems()->sum('total_items_cost');
        $totalInvoice = $totalServicesCost;
        $totalTaxes = $invoice->customerServiceInvoiceTaxs()->get();
        foreach($totalTaxes as $tax)
        {
            if($tax->value_type == "amount")
                $totalInvoice = $totalInvoice + $tax->value;
            else
                $totalInvoice = $totalInvoice + $totalInvoice * ($tax->value/100);
        }
        $invoice->total_invoice = $totalInvoice;
        $invoice->save();
        $invoice->refresh();
    }
    private function prepareInvoiceItemsData(string $currency, array $invoiceItems = [])
    {
        $data = [];
        for($i = 0; $i<count($invoiceItems); $i++)
        {
            $service = Service::find($invoiceItems[$i]['service_id']);
            $unitPrice = $service->unitPrices()->where('currency_id', $currency)->first();
            if(!$unitPrice)
                throw new Exception("currrecy not avaliable");
            $servicePrice = $unitPrice->price;
            $data[$i]['service_id'] = $service->id;
            $data[$i]['price'] = $servicePrice;
            $data[$i]['total_items_cost'] = $servicePrice * $invoiceItems[$i]['count'];
            $data[$i]['count'] = $invoiceItems[$i]['count'];
        }
        return $data;
    }

    private function prepareInvoiceTaxesData(array $invoiceTaxes = [])
    {
        $data = [];
        for($i = 0; $i<count($invoiceTaxes); $i++)
        {
            $tax = Tax::find($invoiceTaxes[$i]['tax_id']);
            $data[$i]['tax_id'] = $tax->id;
            $data[$i]['value'] = $tax->value;
            $data[$i]['value_type'] = $tax->value_type;
        }
        return $data;
    }

    public function update(int $id, array $data=[])
    {
        $customer = $this->findById($id);
        // $data['is_active'] = isset($data['is_active']) ? ActivationStatusEnum::ACTIVE:ActivationStatusEnum::NOT_ACTIVE;
        return $customer->update($data);
    }

    /**
     * @throws NotFoundException
     */
    public function destroy($id)
    {
        $customer = $this->findById($id);
        return $customer->delete();
    } //end of delete

    public function status($id)
    {
        $customer = $this->findById($id);
        $customer->is_active = !$customer->is_active;
        return $customer->save();

    }//end of status

}
