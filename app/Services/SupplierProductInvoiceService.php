<?php

namespace App\Services;

use App\DTO\SupplierProductInvoice\SupplierProductInvoiceDTO;
use App\Exceptions\NotFoundException;
use App\Models\SupplierProductInvoice;
use App\Models\Product;
use App\Models\Tax;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

use App\QueryFilters\SupplierProductInvoiceFilters;
use Exception;
use Illuminate\Support\Facades\DB;

class SupplierProductInvoiceService extends BaseService
{
    public function __construct(private SupplierProductInvoice $model){

    }

    public function getModel(): Model
    {
        return $this->model;
    }

    public function queryGet(array $filters = [] , array $withRelations = []) :builder
    {
        $supplierAddresses = $this->getModel()->query()->with($withRelations);
        return (new SupplierProductInvoiceFilters($filters))->apply($supplierAddresses);
    }

    public function getAll(array $filters = [] , array $withRelations =[], $perPage = null ): \Illuminate\Contracts\Pagination\CursorPaginator|\Illuminate\Database\Eloquent\Collection
    {
        if($perPage)
            return $this->queryGet(filters: $filters,withRelations: $withRelations)->cursorPaginate($perPage);
        else
            return $this->queryGet(filters: $filters,withRelations: $withRelations)->get();
    }

    public function getSupplierProductInvoicesForSelectDropDown(array $filters = []): \Illuminate\Database\Eloquent\Collection|array
    {
        return $this->queryGet(filters: $filters)->select(['id'])->get();
    }

    public function store(SupplierProductInvoiceDTO $DTO):Model|bool
    {
        // $data['is_active'] = isset($data['is_active']) ? ActivationStatusEnum::ACTIVE:ActivationStatusEnum::NOT_ACTIVE;
        $invoiceData = $DTO->invoiceData();
        DB::beginTransaction();
        $supplierProductInvoice = $this->getModel()->create($invoiceData);
        $invoiceItemsData = $this->prepareInvoiceItemsData(currency: $invoiceData['currency_id'], invoiceItems: $DTO->invoiceItems());
        if($invoiceItemsData)
            $supplierProductInvoice->supplierProductInvoiceItems()->createMany($invoiceItemsData);
        $invoiceTaxesData = $this->prepareInvoiceTaxesData(invoiceTaxes: $DTO->invoiceTaxes());
        if($invoiceTaxesData)
            $supplierProductInvoice->supplierProductInvoiceTaxs()->createMany($invoiceTaxesData);
        $this->refreshInvoice(invoice: $supplierProductInvoice);
        DB::commit();
        if (!$supplierProductInvoice)
            return false ;
        return $supplierProductInvoice;
    } //end of store


    private function refreshInvoice(supplierProductInvoice $invoice)
    {
        $totalProductsCost = $invoice->supplierProductInvoiceItems()->sum('total_items_cost');
        $totalTaxes = $invoice->supplierProductInvoiceTaxs()->get();
        $taxes = 0;
        foreach($totalTaxes as $tax)
        {
            if($tax->value_type == "amount")
                $taxes += $tax->value;
            else
                $taxes += $totalProductsCost * ($tax->value/100);
        }
        $invoice->total_invoice = $totalProductsCost + $taxes;
        $invoice->save();
        $invoice->refresh();
    }
    private function prepareInvoiceItemsData(string $currency, array $invoiceItems = [])
    {
        $data = [];
        for($i = 0; $i<count($invoiceItems); $i++)
        {
            $product = Product::find($invoiceItems[$i]['product_id']);
            $unitPrice = $product->unitPrices()->where('currency_id', $currency)->first();
            if(!$unitPrice)
                throw new Exception("currrecy not avaliable");
            $productPrice = $unitPrice->price;
            $data[$i]['product_id'] = $product->id;
            $data[$i]['price'] = $productPrice;
            $data[$i]['total_items_cost'] = $productPrice * $invoiceItems[$i]['count'];
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
