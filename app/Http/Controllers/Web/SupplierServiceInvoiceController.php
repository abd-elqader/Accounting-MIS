<?php

namespace App\Http\Controllers\Web;

use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\SupplierServiceInvoiceService;
use App\DataTables\SupplierServiceInvoicesDataTable;
use App\DTO\SupplierServiceInvoice\SupplierServiceInvoiceDTO;
use App\Http\Requests\StoreSupplierServiceInvoiceRequest;
use App\Http\Requests\UpdateSupplierServiceInvoiceRequest;


class SupplierServiceInvoiceController extends Controller
{
    public function __construct(private SupplierServiceInvoiceService $supplierServiceInvoiceService)
    {

    }

    public function index(SupplierServiceInvoicesDataTable $dataTable, Request $request)
    {
        // userCan(request: $request, permission: 'view_site');
        $filters = array_filter($request->get('filters', []), function ($value) {
            return ($value !== null && $value !== false && $value !== '');
        });
        return $dataTable->with(['filters'=>$filters])->render('layouts.Dashboard.supplier_service_invoices.index');
    }//end of index

    public function edit(Request $request, $id)
    {
        // userCan(request: $request, permission: 'edit_site');
        try{
            $supplierServiceInvoice = $this->supplierServiceInvoiceService->findById(id: $id);
            return view('layouts.Dashboard.supplier_service_invoices.edit', compact('supplierServiceInvoice'));
        }catch(Exception $e){
            return redirect()->back()->with("message", __('app.something_went_wrong'));
        }
        
    }//end of create

    public function create(Request $request)
    {
        // userCan(request: $request, permission: 'create_site');
        return view('layouts.dashboard.supplier_service_invoices.create');
    }//end of create

    public function store(StoreSupplierServiceInvoiceRequest $request)
    {
        // userCan(request: $request, permission: 'create_site');
        try {
            $supplierServiceInvoiceDTO = SupplierServiceInvoiceDTO::fromRequest($request);
            $this->supplierServiceInvoiceService->store(DTO: $supplierServiceInvoiceDTO);
            return redirect()->route('supplier_service_invoices.index')->with('message', __('app.success_operation'));
        } catch (Exception $e) {
            return apiResponse(message: $e->getMessage(), code: 422);
        }
    }//end of store

    public function update(UpdateSupplierServiceInvoiceRequest $request, $id)
    {
        // userCan(request: $request, permission: 'edit_site');
        try {
            $this->supplierServiceInvoiceService->update($id, $request->validated());
            return redirect()->route('supplier_service_invoices.index')->with('message', __('app.success_operation'));
        } catch (\Exception $e) {
            return redirect()->back()->with("message", $e->getMessage());
        }
    } //end of update

    public function destroy(Request $request, $id)
    {
        // userCan(request: $request, permission: 'delete_site');
        try {
            $result = $this->supplierServiceInvoiceService->destroy($id);
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
            $supplierServiceInvoice = $this->supplierServiceInvoiceService->findById(id: $id);
            return view('layouts.dashboard.supplier_service_invoices.show', compact('supplierServiceInvoice'));
        }catch(Exception $e){
            dd($e);
            return redirect()->back()->with("message", __('app.something_went_wrong'));
        }
    } //end of show

}
