<?php

namespace App\Services;

use App\Exceptions\NotFoundException;
use App\Models\SupplierProductInvoice;
use App\Models\SupplierServiceInvoice;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\QueryFilters\SupplierContactFilters;
use App\QueryFilters\SupplierProductInvoiceFilters;
use App\QueryFilters\SupplierServiceInvoiceFilters;

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
