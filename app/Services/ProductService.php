<?php

namespace App\Services;

use App\Enum\ActivationStatusEnum;
use App\Exceptions\NotFoundException;
use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use App\QueryFilters\ProductFilters;
use Illuminate\Database\Eloquent\Model;

class ProductService extends BaseService
{
    public function __construct(private Product $model){

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
        if (!$product)
            return false ;
        return $product;
    } //end of store

    public function update(int $id, array $data=[])
    {
        $product = $this->findById($id);
        // $data['is_active'] = isset($data['is_active']) ? ActivationStatusEnum::ACTIVE:ActivationStatusEnum::NOT_ACTIVE;
        return $product->update($data);
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

}
