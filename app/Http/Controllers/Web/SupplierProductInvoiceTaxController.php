<?php

namespace App\Http\Controllers\Web;

use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\SupplierProductInvoiceTaxService;
use App\DataTables\SupplierProductInvoiceTaxDataTable;
use App\Http\Requests\StoreSupplierProductInvoiceTaxRequest;
use App\Http\Requests\UpdateSupplierProductInvoiceTaxRequest;


class SupplierProductInvoiceTaxController extends Controller
{
    public function __construct(private SupplierProductInvoiceTaxService $supplierProductInvoiceTaxService)
    {

    }

    public function index(SupplierProductInvoiceTaxDataTable $dataTable, Request $request)
    {
        // userCan(request: $request, permission: 'view_site');
        $filters = array_filter($request->get('filters', []), function ($value) {
            return ($value !== null && $value !== false && $value !== '');
        });
        return $dataTable->with(['filters'=>$filters])->render('layouts.Dashboard.supplier_product_invoice_taxes.index');
    }//end of index

    public function edit(Request $request, $id)
    {
        // userCan(request: $request, permission: 'edit_site');
        try{
            $supplierProductInvoiceTax = $this->supplierProductInvoiceTaxService->findById(id: $id);
            return view('layouts.Dashboard.supplier_product_invoice_taxes.edit', compact('supplierProductInvoiceTax'));
        }catch(Exception $e){
            dd($e);
            return redirect()->back()->with("message", __('lang.something_went_wrong'));
        }
        
    }//end of create

    public function create(Request $request)
    {
        // userCan(request: $request, permission: 'create_site');
        return view('layouts.dashboard.supplier_product_invoice_taxes.create');
    }//end of create

    public function store(StoreSupplierProductInvoiceTaxRequest $request)
    {
        
        // userCan(request: $request, permission: 'create_site');
        try {
            $this->supplierProductInvoiceTaxService->store(data: $request->validated());
            return redirect()->route('supplier_product_invoice_taxes.index')->with('message', __('lang.success_operation'));
        } catch (Exception $e) {
            dd($e);
            return redirect()->back()->with('message', $e->getMessage());
        }
    }//end of store

    public function update(UpdateSupplierProductInvoiceTaxRequest $request, $id)
    {
        // userCan(request: $request, permission: 'edit_site');
        try {
            $this->supplierProductInvoiceTaxService->update($id, $request->validated());
            return redirect()->route('supplier_product_invoice_taxes.index')->with('message', __('lang.success_operation'));
        } catch (\Exception $e) {
            return redirect()->back()->with("message", $e->getMessage());
        }
    } //end of update

    public function destroy(Request $request, $id)
    {
        // userCan(request: $request, permission: 'delete_site');
        try {
            $result = $this->supplierProductInvoiceTaxService->destroy($id);
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
            $supplierProductInvoiceTax = $this->supplierProductInvoiceTaxService->findById(id: $id);
            return view('layouts.dashboard.supplier_product_invoice_taxes.show', compact('supplierProductInvoiceTax'));
        }catch(Exception $e){
            dd($e);
            return redirect()->back()->with("message", __('lang.something_went_wrong'));
        }
    } //end of show

}
