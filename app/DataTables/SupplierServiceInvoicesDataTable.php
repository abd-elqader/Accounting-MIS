<?php

namespace App\DataTables;

use Yajra\DataTables\Html\Column;
use App\Models\SupplierServiceInvoice;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Services\DataTable;
use App\Services\SupplierServiceInvoiceService;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;

class SupplierServiceInvoicesDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
        ->addColumn('action', function(SupplierServiceInvoice $model){
            return view('layouts.dashboard.supplier_service_invoices.components.actions',compact('model'))->render();
        })
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(SupplierServiceInvoiceService $supplierServiceInvoiceService): QueryBuilder
    {
        return $supplierServiceInvoiceService->queryGet(filters: $this->filters);
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
            Column::make('total_invoice')->title(__('app.total_invoice')),
            Column::make('reversed')->title(__('app.reversed')),
            Column::make('due_date')->title(__('app.due_date')),
            Column::make('created_at')->title(__('app.creation_date')),
            Column::make('supplier_id')->title(__('app.supplier_id')),
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
        return 'suppliers_' . date('YmdHis');
    }
}
