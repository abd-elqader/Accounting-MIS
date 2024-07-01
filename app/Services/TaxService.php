<?php

namespace App\Services;

use App\Enum\ActivationStatusEnum;
use App\Exceptions\NotFoundException;
use App\Models\Tax;
use Illuminate\Database\Eloquent\Builder;
use App\QueryFilters\TaxFilters;
use Illuminate\Database\Eloquent\Model;

class TaxService extends BaseService
{
    public function __construct(private Tax $model){

    }

    public function getModel(): Model
    {
        return $this->model;
    }

    public function queryGet(array $filters = [] , array $withRelations = []) :builder
    {
        $tax = $this->getModel()->query()->with($withRelations);
        return (new TaxFilters($filters))->apply($tax);
    }

    public function getAll(array $filters = [] , array $withRelations =[], $perPage = null ): \Illuminate\Contracts\Pagination\CursorPaginator|\Illuminate\Database\Eloquent\Collection
    {
        if($perPage)
            return $this->queryGet(filters: $filters,withRelations: $withRelations)->cursorPaginate($perPage);
        else
            return $this->queryGet(filters: $filters,withRelations: $withRelations)->get();
    }

    public function getTaxesForSelectDropDown(array $filters = []): \Illuminate\Database\Eloquent\Collection|array
    {
        return $this->queryGet(filters: $filters)->select(['id','name'])->get();
    }

    public function store(array $data = []):Tax|Model|bool
    {
        // $data['is_active'] = isset($data['is_active']) ? ActivationStatusEnum::ACTIVE:ActivationStatusEnum::NOT_ACTIVE;
        $tax = $this->getModel()->create($data);
        if (!$tax)
            return false ;
        return $tax;
    } //end of store

    public function update(int $id, array $data=[])
    {
        $tax = $this->findById($id);
        // $data['is_active'] = isset($data['is_active']) ? ActivationStatusEnum::ACTIVE:ActivationStatusEnum::NOT_ACTIVE;
        return $tax->update($data);
    }

    /**
     * @throws NotFoundException
     */
    public function destroy($id)
    {
        $tax = $this->findById($id);
        return $tax->delete();
    } //end of delete

    public function status($id)
    {
        $tax = $this->findById($id);
        $tax->is_active = !$tax->is_active;
        return $tax->save();

    }//end of status

}
