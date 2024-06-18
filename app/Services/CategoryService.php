<?php

namespace App\Services;

use App\Enum\ActivationStatusEnum;
use App\Exceptions\NotFoundException;
use App\Models\Category;
use Illuminate\Database\Eloquent\Builder;
use App\QueryFilters\CategoryFilters;
use Illuminate\Database\Eloquent\Model;

class CategoryService extends BaseService
{
    public function __construct(private Category $model){

    }

    public function getModel(): Model
    {
        return $this->model;
    }

    public function queryGet(array $filters = [] , array $withRelations = []) :builder
    {
        $category = $this->getModel()->query()->with($withRelations);
        return (new CategoryFilters($filters))->apply($category);
    }

    public function getAll(array $filters = [] , array $withRelations =[], $perPage = null ): \Illuminate\Contracts\Pagination\CursorPaginator|\Illuminate\Database\Eloquent\Collection
    {
        if($perPage)
            return $this->queryGet(filters: $filters,withRelations: $withRelations)->cursorPaginate($perPage);
        else
            return $this->queryGet(filters: $filters,withRelations: $withRelations)->get();
    }

    public function getCategoriesForSelectDropDown(array $filters = []): \Illuminate\Database\Eloquent\Collection|array
    {
        return $this->queryGet(filters: $filters)->select(['id','name'])->get();
    }

    public function store(array $data = []):Category|Model|bool
    {
        // $data['is_active'] = isset($data['is_active']) ? ActivationStatusEnum::ACTIVE:ActivationStatusEnum::NOT_ACTIVE;
        $category = $this->getModel()->create($data);
        if (!$category)
            return false ;
        return $category;
    } //end of store

    public function update(int $id, array $data=[])
    {
        $category = $this->findById($id);
        // $data['is_active'] = isset($data['is_active']) ? ActivationStatusEnum::ACTIVE:ActivationStatusEnum::NOT_ACTIVE;
        return $category->update($data);
    }

    /**
     * @throws NotFoundException
     */
    public function destroy($id)
    {
        $category = $this->findById($id);
        return $category->delete();
    } //end of delete

    public function status($id)
    {
        $category = $this->findById($id);
        $category->is_active = !$category->is_active;
        return $category->save();

    }//end of status

}
