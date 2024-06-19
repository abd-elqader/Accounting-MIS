<?php

namespace App\Http\Controllers\Web;

use Exception;
use App\Models\Supplier;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\SupplierAddressesService;
use App\Http\Requests\StoreSupplierRequest;
use App\Http\Requests\UpdateSupplierRequest;
use App\DataTables\SupplierAddressesDataTable;
use App\Http\Requests\StoreSupplierAddressesRequest;
use App\Http\Requests\UpdateSupplierAddressesRequest;


class SupplierAddressesController extends Controller
{
    public function __construct(private SupplierAddressesService $supplierAddressesService)
    {

    }

    public function index(SupplierAddressesDataTable $dataTable, Request $request)
    {
        // userCan(request: $request, permission: 'view_site');
        $filters = array_filter($request->get('filters', []), function ($value) {
            return ($value !== null && $value !== false && $value !== '');
        });
        return $dataTable->with(['filters'=>$filters])->render('layouts.Dashboard.supplier_addresses.index');
    }//end of index

    public function edit(Request $request, $id)
    {
        // userCan(request: $request, permission: 'edit_site');
        try{
            $supplier_address = $this->supplierAddressesService->findById(id: $id);
            return view('layouts.Dashboard.supplier_addresses.edit', compact('supplier_address'));
        }catch(Exception $e){
            dd($e);
            return redirect()->back()->with("message", __('lang.something_went_wrong'));
        }
        
    }//end of create

    public function create(Request $request)
    {
        // dd($request->all());
        // userCan(request: $request, permission: 'create_site');
        return view('layouts.dashboard.supplier_addresses.create');
    }//end of create

    public function store(StoreSupplierAddressesRequest $request)
    {

        // userCan(request: $request, permission: 'create_site');
        try {
            $this->supplierAddressesService->store(data: $request->validated());
            return redirect()->route('supplier_addresses.index')->with('message', __('lang.success_operation'));
        } catch (Exception $e) {
            dd($e);
            return redirect()->back()->with('message', $e->getMessage());
        }
    }//end of store

    public function update(UpdateSupplierAddressesRequest $request, $id)
    {
        // userCan(request: $request, permission: 'edit_site');
        try {
            $this->supplierAddressesService->update($id, $request->validated());
            return redirect()->route('supplier_addresses.index')->with('message', __('lang.success_operation'));
        } catch (\Exception $e) {
            return redirect()->back()->with("message", $e->getMessage());
        }
    } //end of update

    public function destroy(Request $request, $id)
    {
        // userCan(request: $request, permission: 'delete_site');
        try {
            $result = $this->supplierAddressesService->destroy($id);
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
            $supplierAddresses = $this->supplierAddressesService->findById(id: $id);
            return view('layouts.dashboard.supplier_addresses.show', compact('supplierAddresses'));
        }catch(Exception $e){
            return redirect()->back()->with("message", __('lang.something_went_wrong'));
        }
    } //end of show

}
