<?php

namespace App\Http\Controllers\Web;

use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\SupplierServiceInvoiceItemService;
use App\DataTables\SupplierServiceInvoiceItemDataTable;
use App\Http\Requests\StoreSupplierServiceInvoiceItemRequest;
use App\Http\Requests\UpdateSupplierServiceInvoiceItemRequest;


class SupplierServiceInvoiceItemController extends Controller
{
    public function __construct(private SupplierServiceInvoiceItemService $supplierServiceInvoiceItemService)
    {

    }

    public function index(SupplierServiceInvoiceItemDataTable $dataTable, Request $request)
    {
        // userCan(request: $request, permission: 'view_site');
        $filters = array_filter($request->get('filters', []), function ($value) {
            return ($value !== null && $value !== false && $value !== '');
        });
        return $dataTable->with(['filters'=>$filters])->render('layouts.Dashboard.supplier_service_invoice_items.index');
    }//end of index

    public function edit(Request $request, $id)
    {
        // userCan(request: $request, permission: 'edit_site');
        try{
            $supplierServiceInvoiceItem = $this->supplierServiceInvoiceItemService->findById(id: $id);
            return view('layouts.Dashboard.supplier_service_invoice_items.edit', compact('supplierServiceInvoiceItem'));
        }catch(Exception $e){
            dd($e);
            return redirect()->back()->with("message", __('app.something_went_wrong'));
        }
        
    }//end of create

    public function create(Request $request)
    {
        // userCan(request: $request, permission: 'create_site');
        return view('layouts.dashboard.supplier_service_invoice_items.create');
    }//end of create

    public function store(StoreSupplierServiceInvoiceItemRequest $request)
    {
        
        // userCan(request: $request, permission: 'create_site');
        try {
            $this->supplierServiceInvoiceItemService->store(data: $request->validated());
            return redirect()->route('supplier_service_invoice_items.index')->with('message', __('app.success_operation'));
        } catch (Exception $e) {
            dd($e);
            return redirect()->back()->with('message', $e->getMessage());
        }
    }//end of store

    public function update(UpdateSupplierServiceInvoiceItemRequest $request, $id)
    {
        // userCan(request: $request, permission: 'edit_site');
        try {
            $this->supplierServiceInvoiceItemService->update($id, $request->validated());
            return redirect()->route('supplier_service_invoice_items.index')->with('message', __('app.success_operation'));
        } catch (\Exception $e) {
            return redirect()->back()->with("message", $e->getMessage());
        }
    } //end of update

    public function destroy(Request $request, $id)
    {
        // userCan(request: $request, permission: 'delete_site');
        try {
            $result = $this->supplierServiceInvoiceItemService->destroy($id);
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
            $supplierServiceInvoiceItem = $this->supplierServiceInvoiceItemService->findById(id: $id);
            return view('layouts.dashboard.supplier_service_invoice_items.show', compact('supplierServiceInvoiceItem'));
        }catch(Exception $e){
            dd($e);
            return redirect()->back()->with("message", __('app.something_went_wrong'));
        }
    } //end of show

}
