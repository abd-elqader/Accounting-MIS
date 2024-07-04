<?php

namespace App\Http\Controllers\Web;

use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\BranchAddressesService;
use App\DataTables\BranchAddressesDataTable;
use App\Http\Requests\BranchAddressStoreRequest;
use App\Http\Requests\BranchAddressUpdateRequest;



class BranchAddressController extends Controller
{
    public function __construct(private BranchAddressesService $branchAddressService)
    {

    }

    public function index(BranchAddressesDataTable $dataTable, Request $request)
    {
        // userCan(request: $request, permission: 'view_site');
        $filters = array_filter($request->get('filters', []), function ($value) {
            return ($value !== null && $value !== false && $value !== '');
        });
        return $dataTable->with(['filters'=>$filters])->render('layouts.dashboard.branch_addresses.index');
    }//end of index

    public function edit(Request $request, $id)
    {
        // userCan(request: $request, permission: 'edit_site');
        try{
            $branch_address = $this->branchAddressService->findById(id: $id);
            return view('layouts.dashboard.branch_addresses.edit', compact('branch_address'));
        }catch(Exception $e){
            dd($e);
            return redirect()->back()->with("message", __('app.something_went_wrong'));
        }
        
    }//end of create

    public function create(Request $request)
    {
        // dd($request->all());
        // userCan(request: $request, permission: 'create_site');
        return view('layouts.dashboard.branch_addresses.create');
    }//end of create

    public function store(BranchAddressStoreRequest $request)
    {

        // userCan(request: $request, permission: 'create_site');
        try {
            $this->branchAddressService->store(data: $request->validated());
            return redirect()->route('branch_addresses.index')->with('message', __('app.success_operation'));
        } catch (Exception $e) {
            dd($e);
            return redirect()->back()->with('message', $e->getMessage());
        }
    }//end of store

    public function update(BranchAddressUpdateRequest $request, $id)
    {
        // userCan(request: $request, permission: 'edit_site');
        try {
            $this->branchAddressService->update($id, $request->validated());
            return redirect()->route('branch_addresses.index')->with('message', __('app.success_operation'));
        } catch (\Exception $e) {
            return redirect()->back()->with("message", $e->getMessage());
        }
    } //end of update

    public function destroy(Request $request, $id)
    {
        // userCan(request: $request, permission: 'delete_site');
        try {
            $result = $this->branchAddressService->destroy($id);
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
            $branch_address = $this->branchAddressService->findById(id: $id);
            return view('layouts.dashboard.branch_addresses.show', compact('branch_address'));
        }catch(Exception $e){
            return redirect()->back()->with("message", __('app.something_went_wrong'));
        }
    } //end of show

}
