<?php

namespace App\Services;

use App\Exceptions\NotFoundException;
use Illuminate\Database\Eloquent\Model;
use App\Http\Livewire\Dashboard\Customer;
use App\Models\CustomerServiceInvoiceTax;
use App\Models\SupplierServiceInvoiceTax;
use Illuminate\Database\Eloquent\Builder;
use App\QueryFilters\CustomerServiceInvoiceTaxFilters;
use App\QueryFilters\SupplierServiceInvoiceTaxFilters;

class CustomerServiceInvoiceTaxService extends BaseService
{
    public function __construct(private CustomerServiceInvoiceTax $model){

    }

    public function getModel(): Model
    {
        return $this->model;
    }

    public function queryGet(array $filters = [] , array $withRelations = []) :builder
    {
        $supplierAddresses = $this->getModel()->query()->with($withRelations);
        return (new CustomerServiceInvoiceTaxFilters($filters))->apply($supplierAddresses);
    }

    public function getAll(array $filters = [] , array $withRelations =[], $perPage = null ): \Illuminate\Contracts\Pagination\CursorPaginator|\Illuminate\Database\Eloquent\Collection
    {
        if($perPage)
            return $this->queryGet(filters: $filters,withRelations: $withRelations)->cursorPaginate($perPage);
        else
            return $this->queryGet(filters: $filters,withRelations: $withRelations)->get();
    }

    public function getCountriesForSelectDropDown(array $filters = []): \Illuminate\Database\Eloquent\Collection|array
    {
        return $this->queryGet(filters: $filters)->select(['id','name'])->get();
    }

    public function store(array $data = []):Model|bool
    {
        // $data['is_active'] = isset($data['is_active']) ? ActivationStatusEnum::ACTIVE:ActivationStatusEnum::NOT_ACTIVE;
        $Supplier = $this->getModel()->create($data);
        if (!$Supplier)
            return false ;
        return $Supplier;
    } //end of store

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
