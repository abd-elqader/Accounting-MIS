<?php

namespace App\Services;

use App\Models\Company;
use App\Models\Country;
use App\Enum\ActivationStatusEnum;
use App\QueryFilters\CompanyFilters;
use App\QueryFilters\CountryFilters;
use App\Exceptions\NotFoundException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class CompanyService extends BaseService
{
    public function __construct(private Company $model){

    }

    public function getModel(): Model
    {
        return $this->model;
    }

    public function queryGet(array $filters = [] , array $withRelations = []) :builder
    {
        $Company = $this->getModel()->query()->with($withRelations);
        return (new CompanyFilters($filters))->apply($Company);
    }

    public function getAll(array $filters = [] , array $withRelations =[], $perPage = null ): \Illuminate\Contracts\Pagination\CursorPaginator|\Illuminate\Database\Eloquent\Collection
    {
        if($perPage)
            return $this->queryGet(filters: $filters,withRelations: $withRelations)->cursorPaginate($perPage);
        else
            return $this->queryGet(filters: $filters,withRelations: $withRelations)->get();
    }

    public function getcompaniesForSelectDropDown(array $filters = []): \Illuminate\Database\Eloquent\Collection|array
    {
        return $this->queryGet(filters: $filters)->select(['id','name'])->get();
    }

    public function store(array $data = []):Country|Model|bool
    {
        // $data['is_active'] = isset($data['is_active']) ? ActivationStatusEnum::ACTIVE:ActivationStatusEnum::NOT_ACTIVE;
        $country = $this->getModel()->create($data);
        if (!$country)
            return false ;
        return $country;
    } //end of store

    public function update(int $id, array $data=[])
    {
        $country = $this->findById($id);
        // $data['is_active'] = isset($data['is_active']) ? ActivationStatusEnum::ACTIVE:ActivationStatusEnum::NOT_ACTIVE;
        return $country->update($data);
    }

    /**
     * @throws NotFoundException
     */
    public function destroy($id)
    {
        $country = $this->findById($id);
        return $country->delete();
    } //end of delete

    public function status($id)
    {
        $country = $this->findById($id);
        $country->is_active = !$country->is_active;
        return $country->save();

    }//end of status

}
