<?php

namespace App\Services;

use App\Enum\ActivationStatusEnum;
use App\Exceptions\NotFoundException;
use App\Models\Service;
use Illuminate\Database\Eloquent\Builder;
use App\QueryFilters\ServiceFilters;
use Illuminate\Database\Eloquent\Model;

class ServiceService extends BaseService
{
    public function __construct(private Service $model){

    }

    public function getModel(): Model
    {
        return $this->model;
    }

    public function queryGet(array $filters = [] , array $withRelations = []) :builder
    {
        $service = $this->getModel()->query()->with($withRelations);
        return (new ServiceFilters($filters))->apply($service);
    }

    public function getAll(array $filters = [] , array $withRelations =[], $perPage = null ): \Illuminate\Contracts\Pagination\CursorPaginator|\Illuminate\Database\Eloquent\Collection
    {
        if($perPage)
            return $this->queryGet(filters: $filters,withRelations: $withRelations)->cursorPaginate($perPage);
        else
            return $this->queryGet(filters: $filters,withRelations: $withRelations)->get();
    }

    public function getServicesForSelectDropDown(array $filters = []): \Illuminate\Database\Eloquent\Collection|array
    {
        return $this->queryGet(filters: $filters)->select(['id','name'])->get();
    }

    public function store(array $data = []):Service|Model|bool
    {
        $data['taxable'] = isset($data['taxable']) ? ActivationStatusEnum::ACTIVE:ActivationStatusEnum::NOT_ACTIVE;
        $service = $this->getModel()->create($data);
        $serviceUnitPricesData = $this->prepareUnitPricesData(data: $data);
        $service->unitPrices()->createMany($serviceUnitPricesData);
        if (!$service)
            return false ;
        return $service;
    } //end of store

    private function prepareUnitPricesData(array $data): array
    {
        $relativesData = [];
        if(isset($data['unit_prices_price']))
            for($i = 0; $i< count($data['unit_prices_price']); $i++)
            {
                $relativesData[$i]['price'] = $data['unit_prices_price'][$i];
                $relativesData[$i]['currency_id'] = $data['unit_prices_currency_id'][$i];
            }
        
        return $relativesData;
    }
    public function update(int $id, array $data=[])
    {
        $service = $this->findById($id);
        // $data['is_active'] = isset($data['is_active']) ? ActivationStatusEnum::ACTIVE:ActivationStatusEnum::NOT_ACTIVE;
        $service->update($data);
        $serviceUnitPricesData = $this->prepareUnitPricesData(data: $data);
        $service->unitPrices()->delete();
        $service->unitPrices()->createMany($serviceUnitPricesData);


    }

    /**
     * @throws NotFoundException
     */
    public function destroy($id)
    {
        $service = $this->findById($id);
        return $service->delete();
    } //end of delete

    public function status($id)
    {
        $service = $this->findById($id);
        $service->is_active = !$service->is_active;
        return $service->save();

    }//end of status

}
