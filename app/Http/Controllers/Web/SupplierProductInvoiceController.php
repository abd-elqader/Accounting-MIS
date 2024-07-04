<?php

namespace App\Http\Controllers\Web;

use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\SupplierProductInvoiceService;
use App\DataTables\SupplierProductInvoicesDataTable;
use App\DTO\SupplierProductInvoice\SupplierProductInvoiceDTO;
use App\Http\Requests\StoreSupplierProductInvoiceRequest;
use App\Http\Requests\UpdateSupplierProductInvoiceRequest;


class SupplierProductInvoiceController extends Controller
{
    public function __construct(private SupplierProductInvoiceService $supplierProductInvoiceService)
    {

    }

    public function index(SupplierProductInvoicesDataTable $dataTable, Request $request)
    {
        // userCan(request: $request, permission: 'view_site');
        $filters = array_filter($request->get('filters', []), function ($value) {
            return ($value !== null && $value !== false && $value !== '');
        });
        return $dataTable->with(['filters'=>$filters])->render('layouts.dashboard.supplier_product_invoices.index');
    }//end of index

    public function edit(Request $request, $id)
    {
        // userCan(request: $request, permission: 'edit_site');
        try{
            $supplierProductInvoice = $this->supplierProductInvoiceService->findById(id: $id);
            return view('layouts.dashboard.supplier_product_invoices.edit', compact('supplierProductInvoice'));
        }catch(Exception $e){
            return redirect()->back()->with("message", __('app.something_went_wrong'));
        }
        
    }//end of create

    public function create(Request $request)
    {
        // userCan(request: $request, permission: 'create_site');
        return view('layouts.dashboard.supplier_product_invoices.create');
    }//end of create

    public function store(StoreSupplierProductInvoiceRequest $request)
    {
        // userCan(request: $request, permission: 'create_site');
        try {
            $supplierProductInvoiceDTO = SupplierProductInvoiceDTO::fromRequest($request);
            $this->supplierProductInvoiceService->store(DTO: $supplierProductInvoiceDTO);
            return redirect()->route('supplier_product_invoices.index')->with('message', __('app.success_operation'));
        } catch (Exception $e) {
            return apiResponse(message: $e->getMessage(), code: 422);
        }
    }//end of store

    public function update(UpdateSupplierProductInvoiceRequest $request, $id)
    {
        // userCan(request: $request, permission: 'edit_site');
        try {
            $this->supplierProductInvoiceService->update($id, $request->validated());
            return redirect()->route('supplier_product_invoices.index')->with('message', __('app.success_operation'));
        } catch (\Exception $e) {
            return redirect()->back()->with("message", $e->getMessage());
        }
    } //end of update

    public function destroy(Request $request, $id)
    {
        // userCan(request: $request, permission: 'delete_site');
        try {
            $result = $this->supplierProductInvoiceService->destroy($id);
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
            $supplierProductInvoice = $this->supplierProductInvoiceService->findById(id: $id);
            return view('layouts.dashboard.supplier_product_invoices.show', compact('supplierProductInvoice'));
        }catch(Exception $e){
            dd($e);
            return redirect()->back()->with("message", __('app.something_went_wrong'));
        }
    } //end of show

}
