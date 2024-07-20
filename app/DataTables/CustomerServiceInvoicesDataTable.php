<?php

namespace App\DataTables;

use Yajra\DataTables\Html\Column;
use App\Models\CustomerServiceInvoice;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Services\DataTable;
use App\Services\customerServiceInvoiceService;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;

class CustomerServiceInvoicesDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
        ->addColumn('action', function(CustomerServiceInvoice $model){
            return view('layouts.dashboard.customer_service_invoices.components.actions',compact('model'))->render();
        })
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(CustomerServiceInvoiceService $customerServiceInvoiceService): QueryBuilder
    {
        return $customerServiceInvoiceService->queryGet(filters: $this->filters);
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('customers-table')
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
            Column::make('creation_date')->title(__('app.creation_date')),
            Column::make('customer_id')->title(__('app.customer_id')),
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
        return 'customers_' . date('YmdHis');
    }
}
