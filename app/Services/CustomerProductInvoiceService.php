<?php

namespace App\Services;

use App\Exceptions\NotFoundException;
use App\Models\customerProductInvoice;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

use App\QueryFilters\CustomerProductInvoiceFilters;


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

    public function store(array $data = []):Model|bool
    {
        // $data['is_active'] = isset($data['is_active']) ? ActivationStatusEnum::ACTIVE:ActivationStatusEnum::NOT_ACTIVE;
        $customer = $this->getModel()->create($data);
        if (!$customer)
            return false ;
        return $customer;
    } //end of store

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
