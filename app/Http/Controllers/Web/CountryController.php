<?php

namespace App\Http\Controllers\Web;

use Exception;
use App\Models\Country;
use Illuminate\Http\Request;
use App\Services\CountryService;
use Illuminate\Support\Facades\DB;
use App\DataTables\CountryDataTable;
use App\Http\Controllers\Controller;
use App\Exceptions\NotFoundException;
use App\Http\Requests\StoreCountryRequest;
use App\Http\Requests\UpdateCountryRequest;

class CountryController extends Controller
{
    public function __construct(protected CountryService $countryService)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(CountryDataTable $countryDataTable, Request $request)
    {
        try {
            $filters = array_filter($request->get('filters', []), function ($value) {
                return ($value !== null && $value !== false && $value !== '');
            });
            $withRelation = [];

            return $countryDataTable->with(['filters' => $filters, 'withRelation' => $withRelation])->render('layouts.dashboard.countries.index');
        } catch (Exception $e) {
            $toast = [
                'type' => 'error',
                'title' => 'error',
                'message' => $e->getMessage()
            ];
            return back()->with('toast', $toast);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('layouts.dashboard.countries.create', get_defined_vars());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCountryRequest $request)
    {
        DB::beginTransaction();
        $data = $request->validated();
        $this->countryService->store($data);
        DB::commit();
        $toast = [
            'type' => 'success',
            'title' => 'success',
            'message' => trans('app.success_operation')
        ];
        return to_route('countries.index')->with(['toast' => $toast]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Country $country)
    {
        return view('layouts.dashboard.countries.show', get_defined_vars());
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id)
    {
        try {
            $country = $this->countryService->findById(id: $id);
            return view('layouts.dashboard.countries.edit',  get_defined_vars());
        } catch (Exception | NotFoundException $exception) {
            
            $toast = [
                'type' => 'error',
                'title' => 'error',
                'message' => $exception->getMessage()
            ];
            return back()->with('toast', $toast);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCountryRequest $request, int $id)
    {
        try {
            $data = $request->validated();
            $this->countryService->update($id, $data);
            $toast = [
                'type' => 'success',
                'title' => 'success',
                'message' => trans('app.user_updated_successfully')
            ];
            return to_route('countries.index')->with('toast', $toast);
        } catch (\Exception $e) {
            dd($e);
            $toast = [
                'type' => 'error',
                'title' => 'error',
                'message' => trans('app.there_is_an_error')
            ];
            return back()->with('toast', $toast);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Country $country)
    {
        $country->delete();
        return to_route('layouts.dashboard.countries.index')->with('success', __('keywords.deleted_successfully'));
    }
}
