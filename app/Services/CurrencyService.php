<?php

namespace App\Services;

use App\Models\Currency;
use App\QueryFilters\CurrencyFilters;
use App\Exceptions\NotFoundException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class CurrencyService extends BaseService
{

    public function __construct(
        public Currency $model
        
        )
    {
    }

    public function getModel(): Currency
    {
        return $this->model;
    }

    public function queryGet(array $filters = [],array $withRelations = []): builder
    {
        $result = $this->getQuery()->with($withRelations);
        return (new CurrencyFilters($filters))->apply($result);
    }

    public function CurrencyQueryBuilder(array $filters = [], array $withRelations = []): Builder
    {
        $countries = $this->getQuery()->with($withRelations);
        return $countries->filter(new CurrencyFilters($filters));
    }

    public function getCurrenciesForSelectDropDown(array $filters = []): \Illuminate\Database\Eloquent\Collection|array
    {
        return $this->queryGet(filters: $filters)->select(['id','name'])->get();
    }

    public function datatable(array $filters = [], array $withRelations = [])
    {
        $countries = $this->getQuery()->with($withRelations);
        return (new CurrencyFilters($filters))->apply($countries);
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
        $Currency = $this->findById($id);
        $Currency->update($data);
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
