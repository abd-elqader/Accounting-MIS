<?php

namespace App\Services;

use App\Models\Branch;
use App\Models\BranchAddresses;
use App\Exceptions\NotFoundException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\QueryFilters\BranchAddressFilters;

class BranchAddressesService extends BaseService
{
    public function __construct(private BranchAddresses $model){

    }

    public function getModel(): Model
    {
        return $this->model;
    }

    public function queryGet(array $filters = [] , array $withRelations = []) :builder
    {
        $branchAddresses = $this->getModel()->query()->with($withRelations);
        return (new BranchAddressFilters($filters))->apply($branchAddresses);
    }

    public function getAll(array $filters = [] , array $withRelations =[], $perPage = null ): \Illuminate\Contracts\Pagination\CursorPaginator|\Illuminate\Database\Eloquent\Collection
    {
        if($perPage)
            return $this->queryGet(filters: $filters,withRelations: $withRelations)->cursorPaginate($perPage);
        else
            return $this->queryGet(filters: $filters,withRelations: $withRelations)->get();
    }

    public function getBranchesForSelectDropDown(array $filters = []): \Illuminate\Database\Eloquent\Collection|array
    {
        return $this->queryGet(filters: $filters)->select(['id','name'])->get();
    }

    public function store(array $data = []):Branch|Model|bool
    {
        // $data['is_active'] = isset($data['is_active']) ? ActivationStatusEnum::ACTIVE:ActivationStatusEnum::NOT_ACTIVE;
        $branch = $this->getModel()->create($data);
        if (!$branch)
            return false ;
        return $branch;
    } //end of store

    public function update(int $id, array $data=[])
    {
        $branch = $this->findById($id);
        // $data['is_active'] = isset($data['is_active']) ? ActivationStatusEnum::ACTIVE:ActivationStatusEnum::NOT_ACTIVE;
        return $branch->update($data);
    }

    /**
     * @throws NotFoundException
     */
    public function destroy($id)
    {
        $branch = $this->findById($id);
        return $branch->delete();
    } //end of delete

    public function status($id)
    {
        $branch = $this->findById($id);
        $branch->is_active = !$branch->is_active;
        return $branch->save();

    }//end of status

}
