<?php

namespace App\Services;

use App\Models\Country;
use App\QueryFilters\CountryFilters;
use App\Exceptions\NotFoundException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class CountryService extends BaseService
{

    public function __construct(
        public Country $model
        )
    {
    }

    public function getModel(): Country
    {
        return $this->model;
    }

    public function queryGet(array $filters = [],array $withRelations = []): builder
    {
        $result = $this->getQuery()->with($withRelations);
        return $result->filter(new CountryFilters($filters));
    }

    public function CountryQueryBuilder(array $filters = [], array $withRelations = []): Builder
    {
        $countries = $this->getQuery()->with($withRelations);
        return $countries->filter(new CountryFilters($filters));
    }

    public function getCountryForSelectDropDown(array $filters = []): \Illuminate\Database\Eloquent\Collection|array
    {
        return $this->queryGet(filters: $filters)->select(['id','name'])->get();
    }

    public function datatable(array $filters = [], array $withRelations = [])
    {
        $countries = $this->getQuery()->with($withRelations);
        return (new CountryFilters($filters))->apply($countries);
    }

    /**
     * create new awb status
     * @param array $data
     * @return bool
     */
    public function store($data)
    {
        return $this->model->create($data);
    }

    /**
     * update existing awb status
     * @param array $data
     * @param int $id
     * @return bool
     * @throws NotFoundException
     */
    public function update(int $id, $data): bool
    {
        $country = $this->findById($id);
        $country->update($data);
        return true;
    }

    /**
     * delete existing awb status
     * @param int $id
     * @return bool
     * @throws NotFoundException
     */
    public function destroy(int $id): bool
    {
        $awbStatus = $this->findById($id);
        $awbStatus->delete();
        return true;
    }

    public function findByCode(int $code): Model|Builder|null
    {
        return $this->getQuery()->where('code',$code)->first();
    }
}
