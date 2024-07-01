<?php

namespace App\Services;

use App\DTO\CustomerProductInvoice\CustomerProductInvoiceDTO;
use App\Exceptions\NotFoundException;
use App\Models\customerProductInvoice;
use App\Models\Product;
use App\Models\Tax;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

use App\QueryFilters\CustomerProductInvoiceFilters;
use Exception;
use Illuminate\Support\Facades\DB;

class CustomerProductInvoiceService extends BaseService
{
    public function __construct(private CustomerProductInvoice $model){

    }

    public function getModel(): Model
    {
        return $this->model;
    }

    public function queryGet(array $filters = [] , array $withRelations = []) :builder
    {
        $customerAddresses = $this->getModel()->query()->with($withRelations);
        return (new CustomerProductInvoiceFilters($filters))->apply($customerAddresses);
    }

    public function getAll(array $filters = [] , array $withRelations =[], $perPage = null ): \Illuminate\Contracts\Pagination\CursorPaginator|\Illuminate\Database\Eloquent\Collection
    {
        if($perPage)
            return $this->queryGet(filters: $filters,withRelations: $withRelations)->cursorPaginate($perPage);
        else
            return $this->queryGet(filters: $filters,withRelations: $withRelations)->get();
    }

    public function getCustomerProductInvoicesForSelectDropDown(array $filters = []): \Illuminate\Database\Eloquent\Collection|array
    {
        return $this->queryGet(filters: $filters)->select(['id'])->get();
    }

    public function store(CustomerProductInvoiceDTO $DTO):Model|bool
    {
        // $data['is_active'] = isset($data['is_active']) ? ActivationStatusEnum::ACTIVE:ActivationStatusEnum::NOT_ACTIVE;
        $invoiceData = $DTO->invoiceData();
        DB::beginTransaction();
        $customerProductInvoice = $this->getModel()->create($invoiceData);
        $invoiceItemsData = $this->prepareInvoiceItemsData(currency: $invoiceData['currency_id'], invoiceItems: $DTO->invoiceItems());
        if($invoiceItemsData)
            $customerProductInvoice->customerProductInvoiceItems()->createMany($invoiceItemsData);
        $invoiceTaxesData = $this->prepareInvoiceTaxesData(invoiceTaxes: $DTO->invoiceTaxes());
        if($invoiceTaxesData)
            $customerProductInvoice->customerProductInvoiceTaxs()->createMany($invoiceTaxesData);
        $this->refreshInvoice(invoice: $customerProductInvoice);
        DB::commit();
        if (!$customerProductInvoice)
            return false ;
        return $customerProductInvoice;
    } //end of store


    private function refreshInvoice(customerProductInvoice $invoice)
    {
        $totalProductsCost = $invoice->customerProductInvoiceItems()->sum('total_items_cost');
        $totalInvoice = $totalProductsCost;
        $totalTaxes = $invoice->customerProductInvoiceTaxs()->get();
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
