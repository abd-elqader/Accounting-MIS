<?php

namespace App\Http\Controllers\Web;

use App\DataTables\BranchDataTable;
use App\DataTables\SitesDataTable;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\BranchStoreRequest;
use App\Http\Requests\BranchUpdateRequest;
use App\Http\Requests\Web\SiteStoreRequest;
use App\Http\Requests\Web\SiteUpdateRequest;
use App\Services\BranchService;
use App\Services\SiteService;
use Exception;

class BranchController extends Controller
{
    public function __construct(private BranchService $branchService)
    {

    }

    public function index(BranchDataTable $dataTable, Request $request)
    {
        // userCan(request: $request, permission: 'view_site');
        $filters = array_filter($request->get('filters', []), function ($value) {
            return ($value !== null && $value !== false && $value !== '');
        });
        return $dataTable->with(['filters'=>$filters])->render('layouts.Dashboard.branches.index');
    }//end of index

    public function edit(Request $request, $id)
    {
        // userCan(request: $request, permission: 'edit_site');
        try{
            $branch = $this->branchService->findById(id: $id);
            return view('layouts.Dashboard.branches.edit', compact('branch'));
        }catch(Exception $e){
            return redirect()->back()->with("message", __('app.something_went_wrong'));
        }
        
    }//end of create

    public function create(Request $request)
    {
        // userCan(request: $request, permission: 'create_site');
        return view('layouts.dashboard.branches.create');
    }//end of create

    public function store(BranchStoreRequest $request)
    {

        // userCan(request: $request, permission: 'create_site');
        try {
            $this->branchService->store(data: $request->validated());
            return redirect()->route('branches.index')->with('message', __('app.success_operation'));
        } catch (Exception $e) {
            return redirect()->back()->with('message', $e->getMessage());
        }
    }//end of store

    public function update(BranchUpdateRequest $request, $id)
    {
        // userCan(request: $request, permission: 'edit_site');
        try {
            $this->branchService->update($id, $request->validated());
            return redirect()->route('branches.index')->with('message', __('app.success_operation'));
        } catch (\Exception $e) {
            return redirect()->back()->with("message", $e->getMessage());
        }
    } //end of update

    public function destroy(Request $request, $id)
    {
        // userCan(request: $request, permission: 'delete_site');
        try {
            $result = $this->branchService->destroy($id);
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
            $branch = $this->branchService->findById(id: $id);
            return view('layouts.dashboard.branches.show', compact('branch'));
        }catch(Exception $e){
            return redirect()->back()->with("message", __('app.something_went_wrong'));
        }
    } //end of show

}
