<?php

namespace App\DataTables;

use App\Models\SupplierContact;
use App\Models\SupplierAddresses;
use App\Models\supplierServiceInvoice;
use App\Services\SupplierService;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\EloquentDataTable;
use App\Services\SupplierContactService;
use Yajra\DataTables\Services\DataTable;
use App\Services\SupplierAddressesService;
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
        ->addColumn('action', function(supplierServiceInvoice $model){
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
            Column::make('id')->title(__('lang.id')),
            Column::make('total_invoice')->title(__('lang.total_invoice')),
            Column::make('reversed')->title(__('lang.reversed')),
            Column::make('due_date')->title(__('lang.due_date')),
            Column::make('creation_date')->title(__('lang.creation_date')),
            Column::make('supplier_id')->title(__('lang.supplier_id')),
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
        return 'Suppliers_' . date('YmdHis');
    }
}
