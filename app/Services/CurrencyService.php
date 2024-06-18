<?php

namespace App\Services;

use App\Enum\ActivationStatusEnum;
use App\Exceptions\NotFoundException;
use App\Models\Currency;
use Illuminate\Database\Eloquent\Builder;
use App\QueryFilters\CurrencyFilters;
use Illuminate\Database\Eloquent\Model;

class CurrencyService extends BaseService
{
    public function __construct(private Currency $model){

    }

    public function getModel(): Model
    {
        return $this->model;
    }

    public function queryGet(array $filters = [] , array $withRelations = []) :builder
    {
        $currency = $this->getModel()->query()->with($withRelations);
        return (new CurrencyFilters($filters))->apply($currency);
    }

    public function getAll(array $filters = [] , array $withRelations =[], $perPage = null ): \Illuminate\Contracts\Pagination\CursorPaginator|\Illuminate\Database\Eloquent\Collection
    {
        if($perPage)
            return $this->queryGet(filters: $filters,withRelations: $withRelations)->cursorPaginate($perPage);
        else
            return $this->queryGet(filters: $filters,withRelations: $withRelations)->get();
    }

    public function getCurrenciesForSelectDropDown(array $filters = []): \Illuminate\Database\Eloquent\Collection|array
    {
        return $this->queryGet(filters: $filters)->select(['id','name'])->get();
    }

    public function store(array $data = []):Currency|Model|bool
    {
        $data['is_active'] = isset($data['is_active']) ? ActivationStatusEnum::ACTIVE:ActivationStatusEnum::NOT_ACTIVE;
        $currency = $this->getModel()->create($data);
        if (!$currency)
            return false ;
        return $currency;
    } //end of store

    public function update(int $id, array $data=[])
    {
        $currency = $this->findById($id);
        $data['is_active'] = isset($data['is_active']) ? ActivationStatusEnum::ACTIVE:ActivationStatusEnum::NOT_ACTIVE;
        return $currency->update($data);
    }

    /**
     * @throws NotFoundException
     */
    public function destroy($id)
    {
        $currency = $this->findById($id);
        return $currency->delete();
    } //end of delete

    public function status($id)
    {
        $currency = $this->findById($id);
        $currency->is_active = !$currency->is_active;
        return $currency->save();

    }//end of status

}
