<?php

namespace App\Http\Controllers\Web;

use App\DataTables\IndustryDataTable;
use App\DataTables\SitesDataTable;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\IndustryStoreRequest;
use App\Http\Requests\IndustryUpdateRequest;
use App\Http\Requests\Web\SiteStoreRequest;
use App\Http\Requests\Web\SiteUpdateRequest;
use App\Services\IndustryService;
use App\Services\SiteService;
use Exception;

class IndustryController extends Controller
{
    public function __construct(private IndustryService $industryService)
    {

    }

    public function index(IndustryDataTable $dataTable, Request $request)
    {
        // userCan(request: $request, permission: 'view_site');
        $filters = array_filter($request->get('filters', []), function ($value) {
            return ($value !== null && $value !== false && $value !== '');
        });
        return $dataTable->with(['filters'=>$filters])->render('layouts.Dashboard.industries.index');
    }//end of index

    public function edit(Request $request, $id)
    {
        // userCan(request: $request, permission: 'edit_site');
        try{
            $site = $this->industryService->findById(id: $id);
            return view('Dashboard.industries.edit', compact('site'));
        }catch(Exception $e){
            return redirect()->back()->with("message", __('lang.something_went_wrong'));
        }
        
    }//end of create

    public function create(Request $request)
    {
        // userCan(request: $request, permission: 'create_site');
        return view('layouts.dashboard.industries.create');
    }//end of create

    public function store(IndustryStoreRequest $request)
    {
        // userCan(request: $request, permission: 'create_site');
        try {
            $this->industryService->store(data: $request->validated());
            return redirect()->route('industries.index')->with('message', __('lang.success_operation'));
        } catch (Exception $e) {
            return redirect()->back()->with('message', $e->getMessage());
        }
    }//end of store

    public function update(IndustryUpdateRequest $request, $id)
    {
        // userCan(request: $request, permission: 'edit_site');
        try {
            $this->industryService->update($id, $request->validated());
            return redirect()->route('industries.index')->with('message', __('lang.success_operation'));
        } catch (\Exception $e) {
            return redirect()->back()->with("message", $e->getMessage());
        }
    } //end of update

    public function destroy(Request $request, $id)
    {
        // userCan(request: $request, permission: 'delete_site');
        try {
            $result = $this->industryService->destroy($id);
            if(!$result)
                return apiResponse(message: trans('lang.not_found'),code: 404);
            return apiResponse(message: trans('lang.success_operation'));
        } catch (\Exception $e) {
            return apiResponse(message: $e->getMessage(),code: 422);
        }
    } //end of destroy

    public function show(Request $request, $id)
    {
        // userCan(request: $request, permission: 'view_site');
        try{
            $currrency = $this->industryService->findById(id: $id);
            return view('layouts.dashboard.industries.show', compact('industry'));
        }catch(Exception $e){
            return redirect()->back()->with("message", __('lang.something_went_wrong'));
        }
    } //end of show

}
