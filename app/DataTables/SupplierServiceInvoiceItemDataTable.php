<?php

namespace App\DataTables;

use Yajra\DataTables\Html\Column;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Services\DataTable;
use App\Models\SupplierServiceInvoiceItem;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use App\Services\SupplierServiceInvoiceItemService;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;

class SupplierServiceInvoiceItemDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
        ->addColumn('action', function(SupplierServiceInvoiceItem $model){
            return view('layouts.dashboard.supplier_service_invoice_items.components.actions',compact('model'))->render();
        })
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(SupplierServiceInvoiceItemService $supplierServiceInvoiceItemService): QueryBuilder
    {
        return $supplierServiceInvoiceItemService->queryGet(filters: $this->filters);
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('suppliers-table')
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
            Column::make('id')->title(__('app.id')),
            Column::make('count')->title(__('app.count')),
            Column::make('price')->title(__('app.price')),
            Column::make('total_items_cost')->title(__('app.total_items_cost')),
            Column::make('SSI_id')->title(__('app.supplier_service_invoice_id')),
            Column::make('service_id')->title(__('app.service_id')),
            Column::computed('action')
                ->title(__('app.actions'))
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
        return 'Suppliers_' . date('YmdHis');
    }
}
