<?php

namespace App\Http\Controllers\Web;

use Exception;
use App\Models\Supplier;
use Illuminate\Http\Request;
use App\Services\SupplierService;
use App\Http\Controllers\Controller;
use App\DataTables\SupplierDataTable;
use App\Http\Requests\StoreSupplierRequest;
use App\Http\Requests\UpdateSupplierRequest;


class SupplierController extends Controller
{
    public function __construct(private SupplierService $supplierService)
    {

    }

    public function index(SupplierDataTable $dataTable, Request $request)
    {
        // userCan(request: $request, permission: 'view_site');
        $filters = array_filter($request->get('filters', []), function ($value) {
            return ($value !== null && $value !== false && $value !== '');
        });
        return $dataTable->with(['filters'=>$filters])->render('layouts.dashboard.suppliers.index');
    }//end of index

    public function edit(Request $request, $id)
    {
        // userCan(request: $request, permission: 'edit_site');
        try{
            $supplier = $this->supplierService->findById(id: $id);
            return view('layouts.dashboard.suppliers.edit', compact('supplier'));
        }catch(Exception $e){
            return redirect()->back()->with("message", __('app.something_went_wrong'));
        }
        
    }//end of create

    public function create(Request $request)
    {
        // userCan(request: $request, permission: 'create_site');
        return view('layouts.dashboard.suppliers.create');
    }//end of create

    public function store(StoreSupplierRequest $request)
    {
        // userCan(request: $request, permission: 'create_site');
        try {
            $this->supplierService->store(data: $request->validated());
            return redirect()->route('suppliers.index')->with('message', __('app.success_operation'));
        } catch (Exception $e) {
            return redirect()->back()->with('message', $e->getMessage());
        }
    }//end of store

    public function update(UpdateSupplierRequest $request, $id)
    {
        // userCan(request: $request, permission: 'edit_site');
        try {
            $this->supplierService->update($id, $request->validated());
            return redirect()->route('suppliers.index')->with('message', __('app.success_operation'));
        } catch (\Exception $e) {
            return redirect()->back()->with("message", $e->getMessage());
        }
    } //end of update

    public function destroy(Request $request, $id)
    {
        // userCan(request: $request, permission: 'delete_site');
        try {
            $result = $this->supplierService->destroy($id);
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
            $supplier = $this->supplierService->findById(id: $id);
            return view('layouts.dashboard.suppliers.show', compact('supplier'));
        }catch(Exception $e){
            return redirect()->back()->with("message", __('app.something_went_wrong'));
        }
    } //end of show

}
