<?php

namespace App\Services;

use App\Enum\ActivationStatusEnum;
use App\Exceptions\NotFoundException;
use App\Models\Industry;
use Illuminate\Database\Eloquent\Builder;
use App\QueryFilters\IndustryFilters;
use Illuminate\Database\Eloquent\Model;

class IndustryService extends BaseService
{
    public function __construct(private Industry $model){

    }

    public function getModel(): Model
    {
        return $this->model;
    }

    public function queryGet(array $filters = [] , array $withRelations = []) :builder
    {
        $industry = $this->getModel()->query()->with($withRelations);
        return (new IndustryFilters($filters))->apply($industry);
    }

    public function getAll(array $filters = [] , array $withRelations =[], $perPage = null ): \Illuminate\Contracts\Pagination\CursorPaginator|\Illuminate\Database\Eloquent\Collection
    {
        if($perPage)
            return $this->queryGet(filters: $filters,withRelations: $withRelations)->cursorPaginate($perPage);
        else
            return $this->queryGet(filters: $filters,withRelations: $withRelations)->get();
    }

    public function getIndustriesForSelectDropDown(array $filters = []): \Illuminate\Database\Eloquent\Collection|array
    {
        return $this->queryGet(filters: $filters)->select(['id','name'])->get();
    }

    public function store(array $data = []):Industry|Model|bool
    {
        // $data['is_active'] = isset($data['is_active']) ? ActivationStatusEnum::ACTIVE:ActivationStatusEnum::NOT_ACTIVE;
        $industry = $this->getModel()->create($data);
        if (!$industry)
            return false ;
        return $industry;
    } //end of store

    public function update(int $id, array $data=[])
    {
        $industry = $this->findById($id);
        // $data['is_active'] = isset($data['is_active']) ? ActivationStatusEnum::ACTIVE:ActivationStatusEnum::NOT_ACTIVE;
        return $industry->update($data);
    }

    /**
     * @throws NotFoundException
     */
    public function destroy($id)
    {
        $industry = $this->findById($id);
        return $industry->delete();
    } //end of delete

    public function status($id)
    {
        $industry = $this->findById($id);
        $industry->is_active = !$industry->is_active;
        return $industry->save();

    }//end of status

}
