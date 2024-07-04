<?php

namespace App\Services;

use App\Enum\ActivationStatusEnum;
use App\Exceptions\NotFoundException;
use App\Models\Product;
use App\Models\ProductUnitPrice;
use Illuminate\Database\Eloquent\Builder;
use App\QueryFilters\ProductFilters;
use Illuminate\Database\Eloquent\Model;

class ProductService extends BaseService
{
    public function __construct(
        private Product $model,
        private ProductUnitPrice $productUnitPrice
    
    ){

    }

    public function getModel(): Model
    {
        return $this->model;
    }

    public function queryGet(array $filters = [] , array $withRelations = []) :builder
    {
        $product = $this->getModel()->query()->with($withRelations);
        return (new ProductFilters($filters))->apply($product);
    }

    public function getAll(array $filters = [] , array $withRelations =[], $perPage = null ): \Illuminate\Contracts\Pagination\CursorPaginator|\Illuminate\Database\Eloquent\Collection
    {
        if($perPage)
            return $this->queryGet(filters: $filters,withRelations: $withRelations)->cursorPaginate($perPage);
        else
            return $this->queryGet(filters: $filters,withRelations: $withRelations)->get();
    }

    public function getProductsForSelectDropDown(array $filters = []): \Illuminate\Database\Eloquent\Collection|array
    {
        return $this->queryGet(filters: $filters)->select(['id','name'])->get();
    }

    public function store(array $data = []):Product|Model|bool
    {
        $data['taxable'] = isset($data['taxable']) ? ActivationStatusEnum::ACTIVE:ActivationStatusEnum::NOT_ACTIVE;
        $product = $this->getModel()->create($data);
        $productUnitPricesData = $this->prepareUnitPricesData(data: $data);
        $product->unitPrices()->createMany($productUnitPricesData);
        if (!$product)
            return false ;
        return $product;
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
        $product = $this->findById($id);
        // $data['is_active'] = isset($data['is_active']) ? ActivationStatusEnum::ACTIVE:ActivationStatusEnum::NOT_ACTIVE;
        $data['taxable'] = !isset($data['taxable']) ? ActivationStatusEnum::NOT_ACTIVE:ActivationStatusEnum::ACTIVE;
        $product->update($data);
        $productUnitPricesData = $this->prepareUnitPricesData(data: $data);
        $product->unitPrices()->delete();
        $product->unitPrices()->createMany($productUnitPricesData);


    }

    /**
     * @throws NotFoundException
     */
    public function destroy($id)
    {
        $product = $this->findById($id);
        return $product->delete();
    } //end of delete

    public function status($id)
    {
        $product = $this->findById($id);
        $product->is_active = !$product->is_active;
        return $product->save();

    }//end of status

    public function unitPrices($id)
    {
        $product = $this->productUnitPrice
            ->where('product_id', $id)->get();
            
        return $product;
    }

}
