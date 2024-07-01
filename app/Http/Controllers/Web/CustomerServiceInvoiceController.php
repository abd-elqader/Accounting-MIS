<?php

namespace App\Http\Controllers\Web;

use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\CustomerServiceInvoiceService;
use App\DataTables\CustomerServiceInvoicesDataTable;
use App\DTO\CustomerServiceInvoice\CustomerServiceInvoiceDTO;
use App\Http\Requests\StoreCustomerServiceInvoiceRequest;
use App\Http\Requests\UpdateCustomerServiceInvoiceRequest;


class CustomerServiceInvoiceController extends Controller
{
    public function __construct(private CustomerServiceInvoiceService $customerServiceInvoiceService)
    {

    }

    public function index(CustomerServiceInvoicesDataTable $dataTable, Request $request)
    {
        // userCan(request: $request, permission: 'view_site');
        $filters = array_filter($request->get('filters', []), function ($value) {
            return ($value !== null && $value !== false && $value !== '');
        });
        return $dataTable->with(['filters'=>$filters])->render('layouts.Dashboard.customer_service_invoices.index');
    }//end of index

    public function edit(Request $request, $id)
    {
        // userCan(request: $request, permission: 'edit_site');
        try{
            $customerServiceInvoice = $this->customerServiceInvoiceService->findById(id: $id);
            return view('layouts.Dashboard.customer_service_invoices.edit', compact('customerServiceInvoice'));
        }catch(Exception $e){
            return redirect()->back()->with("message", __('app.something_went_wrong'));
        }
        
    }//end of create

    public function create(Request $request)
    {
        // userCan(request: $request, permission: 'create_site');
        return view('layouts.dashboard.customer_service_invoices.create');
    }//end of create

    public function store(StoreCustomerServiceInvoiceRequest $request)
    {
        // userCan(request: $request, permission: 'create_site');
        try {
            $customerServiceInvoiceDTO = CustomerServiceInvoiceDTO::fromRequest($request);
            $this->customerServiceInvoiceService->store(DTO: $customerServiceInvoiceDTO);
            return redirect()->route('customer_service_invoices.index')->with('message', __('app.success_operation'));
        } catch (Exception $e) {
            return apiResponse(message: $e->getMessage(), code: 422);
        }
    }//end of store

    public function update(UpdateCustomerServiceInvoiceRequest $request, $id)
    {
        // userCan(request: $request, permission: 'edit_site');
        try {
            $this->customerServiceInvoiceService->update($id, $request->validated());
            return redirect()->route('customer_service_invoices.index')->with('message', __('app.success_operation'));
        } catch (\Exception $e) {
            return redirect()->back()->with("message", $e->getMessage());
        }
    } //end of update

    public function destroy(Request $request, $id)
    {
        // userCan(request: $request, permission: 'delete_site');
        try {
            $result = $this->customerServiceInvoiceService->destroy($id);
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
            $customerServiceInvoice = $this->customerServiceInvoiceService->findById(id: $id);
            return view('layouts.dashboard.customer_service_invoices.show', compact('customerServiceInvoice'));
        }catch(Exception $e){
            dd($e);
            return redirect()->back()->with("message", __('app.something_went_wrong'));
        }
    } //end of show

}
