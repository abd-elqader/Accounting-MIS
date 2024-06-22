<?php

namespace App\DataTables;

use App\Models\CustomerContact;
use App\Models\CustomerAddresses;
use App\Services\CustomerService;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\EloquentDataTable;
use App\Services\CustomerContactService;
use Yajra\DataTables\Services\DataTable;
use App\Services\CustomerAddressesService;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;

class CustomerContactDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
        ->addColumn('action', function(CustomerContact $model){
            return view('layouts.dashboard.customer_contacts.components.actions',compact('model'))->render();
        })
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(CustomerContactService $customerContactService): QueryBuilder
    {
        return $customerContactService->queryGet(filters: $this->filters);
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
            Column::make('id')->title(__('lang.id')),
            Column::make('contact')->title(__('lang.contact')),
            Column::make('type')->title(__('lang.type')),
            Column::make('description')->title(__('lang.description')),
            Column::make('customer_id')->title(__('lang.customer_id')),
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
        return 'Customers_' . date('YmdHis');
    }
}
