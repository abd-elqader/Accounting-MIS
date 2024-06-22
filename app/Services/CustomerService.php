<?php

namespace App\Services;

use App\Enum\ActivationStatusEnum;
use App\Exceptions\NotFoundException;
use App\Models\Customer;
use Illuminate\Database\Eloquent\Builder;
use App\QueryFilters\CustomerFilters;
use Illuminate\Database\Eloquent\Model;

class CustomerService extends BaseService
{
    public function __construct(private Customer $model){

    }

    public function getModel(): Model
    {
        return $this->model;
    }

    public function queryGet(array $filters = [] , array $withRelations = []) :builder
    {
        $Customer = $this->getModel()->query()->with($withRelations);
        return (new CustomerFilters($filters))->apply($Customer);
    }

    public function getAll(array $filters = [] , array $withRelations =[], $perPage = null ): \Illuminate\Contracts\Pagination\CursorPaginator|\Illuminate\Database\Eloquent\Collection
    {
        if($perPage)
            return $this->queryGet(filters: $filters,withRelations: $withRelations)->cursorPaginate($perPage);
        else
            return $this->queryGet(filters: $filters,withRelations: $withRelations)->get();
    }

    public function getCustomersForSelectDropDown(array $filters = []): \Illuminate\Database\Eloquent\Collection|array
    {
        return $this->queryGet(filters: $filters)->select(['id','contact_name'])->get();
    }

    public function store(array $data = []):Customer|Model|bool
    {
        // $data['is_active'] = isset($data['is_active']) ? ActivationStatusEnum::ACTIVE:ActivationStatusEnum::NOT_ACTIVE;
        $Customer = $this->getModel()->create($data);
        if (!$Customer)
            return false ;
        return $Customer;
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
