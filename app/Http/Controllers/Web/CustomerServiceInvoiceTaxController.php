<?php

namespace App\Http\Controllers\Web;

use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\CustomerServiceInvoiceTaxService;
use App\DataTables\CustomerServiceInvoiceTaxDataTable;
use App\Http\Requests\StorecustomerServiceInvoiceTaxRequest;
use App\Http\Requests\UpdatecustomerServiceInvoiceTaxRequest;

class CustomerServiceInvoiceTaxController extends Controller
{
    public function __construct(private CustomerServiceInvoiceTaxService $customerServiceInvoiceTaxService)
    {

    }

    public function index(CustomerServiceInvoiceTaxDataTable $dataTable, Request $request)
    {
        // userCan(request: $request, permission: 'view_site');
        $filters = array_filter($request->get('filters', []), function ($value) {
            return ($value !== null && $value !== false && $value !== '');
        });
        return $dataTable->with(['filters'=>$filters])->render('layouts.Dashboard.customer_service_invoice_taxes.index');
    }//end of index

    public function edit(Request $request, $id)
    {
        // userCan(request: $request, permission: 'edit_site');
        try{
            $customerServiceInvoiceTax = $this->customerServiceInvoiceTaxService->findById(id: $id);
            return view('layouts.Dashboard.customer_service_invoice_taxes.edit', compact('customerServiceInvoiceTax'));
        }catch(Exception $e){
            dd($e);
            return redirect()->back()->with("message", __('app.something_went_wrong'));
        }
        
    }//end of create

    public function create(Request $request)
    {

        
        // userCan(request: $request, permission: 'create_site');
        return view('layouts.dashboard.customer_service_invoice_taxes.create');
    }//end of create

    public function store(StoreCustomerServiceInvoiceTaxRequest $request)
    {
        // userCan(request: $request, permission: 'create_site');
        try {
            $this->customerServiceInvoiceTaxService->store(data: $request->validated());
            return redirect()->route('customer_service_invoice_taxes.index')->with('message', __('app.success_operation'));
        } catch (Exception $e) {
            dd($e);
            return redirect()->back()->with('message', $e->getMessage());
        }
    }//end of store

    public function update(UpdateCustomerServiceInvoiceTaxRequest $request, $id)
    {
        // userCan(request: $request, permission: 'edit_site');
        try {
            $this->customerServiceInvoiceTaxService->update($id, $request->validated());
            return redirect()->route('customer_service_invoice_taxes.index')->with('message', __('app.success_operation'));
        } catch (\Exception $e) {
            return redirect()->back()->with("message", $e->getMessage());
        }
    } //end of update

    public function destroy(Request $request, $id)
    {
        // userCan(request: $request, permission: 'delete_site');
        try {
            $result = $this->customerServiceInvoiceTaxService->destroy($id);
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
            $customerServiceInvoiceTax = $this->customerServiceInvoiceTaxService->findById(id: $id);
            return view('layouts.dashboard.customer_service_invoice_taxes.show', compact('customerServiceInvoiceTax'));
        }catch(Exception $e){
            dd($e);
            return redirect()->back()->with("message", __('app.something_went_wrong'));
        }
    } //end of show

}
