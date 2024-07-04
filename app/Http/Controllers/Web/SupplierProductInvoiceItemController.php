<?php

namespace App\Http\Controllers\Web;

use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\SupplierProductInvoiceItemService;
use App\DataTables\SupplierProductInvoiceItemDataTable;
use App\Http\Requests\StoreSupplierProductInvoiceItemRequest;
use App\Http\Requests\UpdateSupplierProductInvoiceItemRequest;


class SupplierProductInvoiceItemController extends Controller
{
    public function __construct(private SupplierProductInvoiceItemService $supplierProductInvoiceItemService)
    {

    }

    public function index(SupplierProductInvoiceItemDataTable $dataTable, Request $request)
    {
        // userCan(request: $request, permission: 'view_site');
        $filters = array_filter($request->get('filters', []), function ($value) {
            return ($value !== null && $value !== false && $value !== '');
        });
        return $dataTable->with(['filters'=>$filters])->render('layouts.dashboard.supplier_product_invoice_items.index');
    }//end of index

    public function edit(Request $request, $id)
    {
        // userCan(request: $request, permission: 'edit_site');
        try{
            $supplierProductInvoiceItem = $this->supplierProductInvoiceItemService->findById(id: $id);
            return view('layouts.dashboard.supplier_product_invoice_items.edit', compact('supplierProductInvoiceItem'));
        }catch(Exception $e){
            dd($e);
            return redirect()->back()->with("message", __('app.something_went_wrong'));
        }
        
    }//end of create

    public function create(Request $request)
    {
        // userCan(request: $request, permission: 'create_site');
        return view('layouts.dashboard.supplier_product_invoice_items.create');
    }//end of create

    public function store(StoreSupplierProductInvoiceItemRequest $request)
    {
        
        // userCan(request: $request, permission: 'create_site');
        try {
            $this->supplierProductInvoiceItemService->store(data: $request->validated());
            return redirect()->route('supplier_product_invoice_items.index')->with('message', __('app.success_operation'));
        } catch (Exception $e) {
            dd($e);
            return redirect()->back()->with('message', $e->getMessage());
        }
    }//end of store

    public function update(UpdateSupplierProductInvoiceItemRequest $request, $id)
    {
        // userCan(request: $request, permission: 'edit_site');
        try {
            $this->supplierProductInvoiceItemService->update($id, $request->validated());
            return redirect()->route('supplier_product_invoice_items.index')->with('message', __('app.success_operation'));
        } catch (\Exception $e) {
            return redirect()->back()->with("message", $e->getMessage());
        }
    } //end of update

    public function destroy(Request $request, $id)
    {
        // userCan(request: $request, permission: 'delete_site');
        try {
            $result = $this->supplierProductInvoiceItemService->destroy($id);
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
            $supplierProductInvoiceItem = $this->supplierProductInvoiceItemService->findById(id: $id);
            return view('layouts.dashboard.supplier_product_invoice_items.show', compact('supplierProductInvoiceItem'));
        }catch(Exception $e){
            dd($e);
            return redirect()->back()->with("message", __('app.something_went_wrong'));
        }
    } //end of show

}
