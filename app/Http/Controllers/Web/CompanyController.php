<?php

namespace App\Http\Controllers\Web;

use App\DataTables\CompanyDataTable;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CompanyStoreRequest;
use App\Http\Requests\CompanyUpdateRequest;
use App\Services\CompanyService;
use Exception;

class CompanyController extends Controller
{
    public function __construct(private CompanyService $companyService)
    {

    }

    public function index(CompanyDataTable $dataTable, Request $request)
    {
        // userCan(request: $request, permission: 'view_site');
        $filters = array_filter($request->get('filters', []), function ($value) {
            return ($value !== null && $value !== false && $value !== '');
        });
        return $dataTable->with(['filters'=>$filters])->render('layouts.dashboard.companies.index');
    }//end of index

    public function edit(Request $request, $id)
    {
        // userCan(request: $request, permission: 'edit_site');
        try{
            $company = $this->companyService->findById(id: $id);
            return view('layouts.dashboard.companies.edit', compact('company'));
        }catch(Exception $e){
            dd($e);
            return redirect()->back()->with("message", __('app.something_went_wrong'));
        }
        
    }//end of create

    public function create(Request $request)
    {
        // userCan(request: $request, permission: 'create_site');
        return view('layouts.dashboard.companies.create');
    }//end of create

    public function store(CompanyStoreRequest $request)
    {
        // userCan(request: $request, permission: 'create_site');
        try {
            $this->companyService->store(data: $request->validated());
            return redirect()->route('companies.index')->with('message', __('app.success_operation'));
        } catch (Exception $e) {
            return redirect()->back()->with('message', $e->getMessage());
        }
    }//end of store

    public function update(CompanyUpdateRequest $request, $id)
    {
        // userCan(request: $request, permission: 'edit_site');
        try {
            $this->companyService->update($id, $request->validated());
            return redirect()->route('companies.index')->with('message', __('app.success_operation'));
        } catch (\Exception $e) {
            return redirect()->back()->with("message", $e->getMessage());
        }
    } //end of update

    public function destroy(Request $request, $id)
    {
        // userCan(request: $request, permission: 'delete_site');
        try {
            $result = $this->companyService->destroy($id);
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
            $company = $this->companyService->findById(id: $id);
            return view('layouts.dashboard.companies.show', compact('company'));
        }catch(Exception $e){
            return redirect()->back()->with("message", __('app.something_went_wrong'));
        }
    } //end of show

}
