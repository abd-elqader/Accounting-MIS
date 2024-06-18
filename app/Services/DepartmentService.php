<?php

namespace App\Services;

use App\Enum\ActivationStatusEnum;
use App\Exceptions\NotFoundException;
use App\Models\Department;
use Illuminate\Database\Eloquent\Builder;
use App\QueryFilters\DepartmentFilters;
use Illuminate\Database\Eloquent\Model;

class DepartmentService extends BaseService
{
    public function __construct(private Department $model){

    }

    public function getModel(): Model
    {
        return $this->model;
    }

    public function queryGet(array $filters = [] , array $withRelations = []) :builder
    {
        $department = $this->getModel()->query()->with($withRelations);
        return (new DepartmentFilters($filters))->apply($department);
    }

    public function getAll(array $filters = [] , array $withRelations =[], $perPage = null ): \Illuminate\Contracts\Pagination\CursorPaginator|\Illuminate\Database\Eloquent\Collection
    {
        if($perPage)
            return $this->queryGet(filters: $filters,withRelations: $withRelations)->cursorPaginate($perPage);
        else
            return $this->queryGet(filters: $filters,withRelations: $withRelations)->get();
    }

    public function getDepartmentsForSelectDropDown(array $filters = []): \Illuminate\Database\Eloquent\Collection|array
    {
        return $this->queryGet(filters: $filters)->select(['id','name'])->get();
    }

    public function store(array $data = []):Department|Model|bool
    {
        $data['is_active'] = isset($data['is_active']) ? ActivationStatusEnum::ACTIVE:ActivationStatusEnum::NOT_ACTIVE;
        $department = $this->getModel()->create($data);
        if (!$department)
            return false ;
        return $department;
    } //end of store

    public function update(int $id, array $data=[])
    {
        $department = $this->findById($id);
        $data['is_active'] = isset($data['is_active']) ? ActivationStatusEnum::ACTIVE:ActivationStatusEnum::NOT_ACTIVE;
        return $department->update($data);
    }

    /**
     * @throws NotFoundException
     */
    public function destroy($id)
    {
        $department = $this->findById($id);
        return $department->delete();
    } //end of delete

    public function status($id)
    {
        $department = $this->findById($id);
        $department->is_active = !$department->is_active;
        return $department->save();

    }//end of status

}
