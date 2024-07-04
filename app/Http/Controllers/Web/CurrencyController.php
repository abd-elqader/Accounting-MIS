<?php

namespace App\Http\Controllers\Web;

use App\DataTables\CurrencyDataTable;
use App\DataTables\SitesDataTable;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CurrencyStoreRequest;
use App\Http\Requests\CurrencyUpdateRequest;
use App\Http\Requests\Web\SiteStoreRequest;
use App\Http\Requests\Web\SiteUpdateRequest;
use App\Services\CurrencyService;
use App\Services\SiteService;
use Exception;

class CurrencyController extends Controller
{
    public function __construct(private CurrencyService $currencyService)
    {

    }

    public function index(CurrencyDataTable $dataTable, Request $request)
    {
        // userCan(request: $request, permission: 'view_site');
        $filters = array_filter($request->get('filters', []), function ($value) {
            return ($value !== null && $value !== false && $value !== '');
        });
        return $dataTable->with(['filters'=>$filters])->render('layouts.dashboard.currencies.index');
    }//end of index

    public function edit(Request $request, $id)
    {
        // userCan(request: $request, permission: 'edit_site');
        try{
            $site = $this->currencyService->findById(id: $id);
            return view('Dashboard.currencies.edit', compact('site'));
        }catch(Exception $e){
            return redirect()->back()->with("message", __('app.something_went_wrong'));
        }
        
    }//end of create

    public function create(Request $request)
    {
        // userCan(request: $request, permission: 'create_site');
        return view('layouts.dashboard.currencies.create');
    }//end of create

    public function store(CurrencyStoreRequest $request)
    {
        // userCan(request: $request, permission: 'create_site');
        try {
            $this->currencyService->store(data: $request->validated());
            return redirect()->route('currencies.index')->with('message', __('app.success_operation'));
        } catch (Exception $e) {
            return redirect()->back()->with('message', $e->getMessage());
        }
    }//end of store

    public function update(CurrencyUpdateRequest $request, $id)
    {
        // userCan(request: $request, permission: 'edit_site');
        try {
            $this->currencyService->update($id, $request->validated());
            return redirect()->route('currencies.index')->with('message', __('app.success_operation'));
        } catch (\Exception $e) {
            return redirect()->back()->with("message", $e->getMessage());
        }
    } //end of update

    public function destroy(Request $request, $id)
    {
        // userCan(request: $request, permission: 'delete_site');
        try {
            $result = $this->currencyService->destroy($id);
            if(!$result)
                return apiResponse(message: trans('app.not_found'),code: 404);
            return apiResponse(message: trans('app.success_operation'));
        } catch (\Exception $e) {
            return apiResponse(message: $e->getMessage(),code: 422);
        }
    } //end of destroy

    public function show(Request $request, $id)
    {
        // userCan(request: $request, permission: 'view_site');
        try{
            $currrency = $this->currencyService->findById(id: $id);
            return view('layouts.dashboard.currencies.show', compact('currency'));
        }catch(Exception $e){
            return redirect()->back()->with("message", __('app.something_went_wrong'));
        }
    } //end of show

}
