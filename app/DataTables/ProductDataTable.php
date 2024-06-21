<?php

namespace App\DataTables;

use App\Models\Product;
use App\Models\Site;
use App\Services\ProductService;
use App\Services\SiteService;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class ProductDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
        ->addColumn('action', function(Product $model){
            return view('layouts.dashboard.products.components.actions',compact('model'))->render();
        })
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(ProductService $service): QueryBuilder
    {
        return $service->queryGet(filters: $this->filters);
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('products-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    //->dom('Bfrtip')
                    ->orderBy(1)
                    ->selectStyleSingle()
                    ->buttons([
                        // Button::make('excel'),
                        // Button::make('csv'),
                        // Button::make('pdf'),
                        // Button::make('print'),
                        // Button::make('reset'),
                        // Button::make('reload')
                    ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('id')->title(__('lang.id')),
            Column::make('name')->title(__('lang.name')),
            Column::make('brand')->title(__('lang.brand')),
            Column::make('tax')->title(__('lang.tax')),
            Column::make('taxable')->title(__('lang.taxable')),
            Column::make('description')->title(__('lang.description')),
            Column::make('stock')->title(__('lang.stock')),
            // Column::make('type')->title(__('lang.type')),
            Column::make('daily_income')->title(__('lang.daily_income')),
            Column::make('weekly_income')->title(__('lang.weekly_income')),
            Column::make('monthly_income')->title(__('lang.monthly_income')),
            Column::make('yearly_income')->title(__('lang.yearly_income')),
            Column::make('category_id')->title(__('lang.category')),
            Column::make('department_id')->title(__('lang.department')),
            Column::computed('action')
                ->title(__('lang.actions'))
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Products_' . date('YmdHis');
    }
}
