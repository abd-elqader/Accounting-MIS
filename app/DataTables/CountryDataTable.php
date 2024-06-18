<?php

namespace App\DataTables;


use App\Models\Country;
use App\Services\CountryService;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;

class CountryDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     * @return \Yajra\DataTables\EloquentDataTable
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->setRowId('id')
            // ->editColumn('name', function (Country $country) {
            //     return $country->name;
            // })
            // ->editColumn('code', function (country $country) {
            //     return $country->code;
            // })
            ->addColumn('action', function (Country $country) {
                return view(
                    'layouts.dashboard.countries.components._actions',
                    ['model' => $country,'url'=>route('countries.destroy',$country->id)]
                );
            })
            ;
    }

    /**
     * @param CountryService $model
     * @return QueryBuilder
     */
    public function query(CountryService $countryService): QueryBuilder
    {
        $filters = $this->filters ?? [];
        $withRelations = $this->withRelations ?? [];

        return $countryService->datatable(filters: $filters, withRelations: $withRelations);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('country-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    //->dom('Bfrtip')
                    ->orderBy(0)
                    ->selectStyleSingle()
                    ->buttons([
                        Button::make('reload')
                    ]);
    }

    /**
     * Get the dataTable columns definition.
     *
     * @return array
     */
    public function getColumns(): array
    {
        return [
            Column::make('id')->title("#"),
            Column::make('name')->title(trans('app.name'))->orderable(false),
            Column::make('code')->title(trans('app.code'))->orderable(false),
            Column::make('slug')->title(trans('app.slug'))->orderable(false),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->addClass('text-center'),
        ];

    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename(): string
    {
        return 'Countries_' . date('YmdHis');
    }
}

// php artisan cache:clear
// php artisan config:clear
// php artisan route:clear
// php artisan view:clear
