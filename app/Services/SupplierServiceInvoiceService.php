<?php

namespace App\Services;

use App\DTO\SupplierServiceInvoice\SupplierServiceInvoiceDTO;
use App\Exceptions\NotFoundException;
use App\Models\supplierServiceInvoice;
use App\Models\Service;
use App\Models\Tax;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

use App\QueryFilters\SupplierServiceInvoiceFilters;
use Exception;
use Illuminate\Support\Facades\DB;

class SupplierServiceInvoiceService extends BaseService
{
    public function __construct(private SupplierServiceInvoice $model){

    }

    public function getModel(): Model
    {
        return $this->model;
    }

    public function queryGet(array $filters = [] , array $withRelations = []) :builder
    {
        $supplierAddresses = $this->getModel()->query()->with($withRelations);
        return (new SupplierServiceInvoiceFilters($filters))->apply($supplierAddresses);
    }

    public function getAll(array $filters = [] , array $withRelations =[], $perPage = null ): \Illuminate\Contracts\Pagination\CursorPaginator|\Illuminate\Database\Eloquent\Collection
    {
        if($perPage)
            return $this->queryGet(filters: $filters,withRelations: $withRelations)->cursorPaginate($perPage);
        else
            return $this->queryGet(filters: $filters,withRelations: $withRelations)->get();
    }

    public function getSupplierServiceInvoicesForSelectDropDown(array $filters = []): \Illuminate\Database\Eloquent\Collection|array
    {
        return $this->queryGet(filters: $filters)->select(['id'])->get();
    }

    public function store(SupplierServiceInvoiceDTO $DTO):Model|bool
    {
        // $data['is_active'] = isset($data['is_active']) ? ActivationStatusEnum::ACTIVE:ActivationStatusEnum::NOT_ACTIVE;
        $invoiceData = $DTO->invoiceData();
        DB::beginTransaction();
        $supplierServiceInvoice = $this->getModel()->create($invoiceData);
        $invoiceItemsData = $this->prepareInvoiceItemsData(currency: $invoiceData['currency_id'], invoiceItems: $DTO->invoiceItems());
        if($invoiceItemsData)
            $supplierServiceInvoice->supplierServiceInvoiceItems()->createMany($invoiceItemsData);
        $invoiceTaxesData = $this->prepareInvoiceTaxesData(invoiceTaxes: $DTO->invoiceTaxes());
        if($invoiceTaxesData)
            $supplierServiceInvoice->supplierServiceInvoiceTaxs()->createMany($invoiceTaxesData);
        $this->refreshInvoice(invoice: $supplierServiceInvoice);
        DB::commit();
        if (!$supplierServiceInvoice)
            return false ;
        return $supplierServiceInvoice;
    } //end of store


    private function refreshInvoice(supplierServiceInvoice $invoice)
    {
        $totalServicesCost = $invoice->supplierServiceInvoiceItems()->sum('total_items_cost');
        $totalTaxes = $invoice->supplierServiceInvoiceTaxs()->get();
        $taxes = 0;
        foreach($totalTaxes as $tax)
        {
            if($tax->value_type == "amount")
                $taxes += $tax->value;
            else
                $taxes += $totalServicesCost * ($tax->value/100);
        }
        $invoice->total_invoice = $totalServicesCost + $taxes;
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
            // $data[$i]['tax'] = $service->taxable ? $service->tax:0;
            // $data[$i]['taxable'] = $service->getRawOriginal('taxable');
            // $data[$i]['total_cost'] = $servicePrice * $invoiceItems[$i]['count'];
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
        $supplier = $this->findById($id);
        // $data['is_active'] = isset($data['is_active']) ? ActivationStatusEnum::ACTIVE:ActivationStatusEnum::NOT_ACTIVE;
        return $supplier->update($data);
    }

    /**
     * @throws NotFoundException
     */
    public function destroy($id)
    {
        $supplier = $this->findById($id);
        return $supplier->delete();
    } //end of delete

    public function status($id)
    {
        $supplier = $this->findById($id);
        $supplier->is_active = !$supplier->is_active;
        return $supplier->save();

    }//end of status

}
