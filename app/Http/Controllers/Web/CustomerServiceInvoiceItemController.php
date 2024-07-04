<?php

namespace App\Http\Controllers\Web;

use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\CustomerServiceInvoiceItemService;
use App\DataTables\CustomerServiceInvoiceItemDataTable;
use App\Http\Requests\StoreCustomerServiceInvoiceItemRequest;
use App\Http\Requests\UpdateCustomerServiceInvoiceItemRequest;


class CustomerServiceInvoiceItemController extends Controller
{
    public function __construct(private CustomerServiceInvoiceItemService $customerServiceInvoiceItemService)
    {

    }

    public function index(CustomerServiceInvoiceItemDataTable $dataTable, Request $request)
    {
        // userCan(request: $request, permission: 'view_site');
        $filters = array_filter($request->get('filters', []), function ($value) {
            return ($value !== null && $value !== false && $value !== '');
        });
        return $dataTable->with(['filters'=>$filters])->render('layouts.dashboard.customer_service_invoice_items.index');
    }//end of index

    public function edit(Request $request, $id)
    {
        // userCan(request: $request, permission: 'edit_site');
        try{
            $customerServiceInvoiceItem = $this->customerServiceInvoiceItemService->findById(id: $id);
            return view('layouts.dashboard.customer_service_invoice_items.edit', compact('customerServiceInvoiceItem'));
        }catch(Exception $e){
            dd($e);
            return redirect()->back()->with("message", __('app.something_went_wrong'));
        }
        
    }//end of create

    public function create(Request $request)
    {
        // userCan(request: $request, permission: 'create_site');
        return view('layouts.dashboard.customer_service_invoice_items.create');
    }//end of create

    public function store(StoreCustomerServiceInvoiceItemRequest $request)
    {
        
        // userCan(request: $request, permission: 'create_site');
        try {
            $this->customerServiceInvoiceItemService->store(data: $request->validated());
            return redirect()->route('customer_service_invoice_items.index')->with('message', __('app.success_operation'));
        } catch (Exception $e) {
            dd($e);
            return redirect()->back()->with('message', $e->getMessage());
        }
    }//end of store

    public function update(UpdateCustomerServiceInvoiceItemRequest $request, $id)
    {
        // userCan(request: $request, permission: 'edit_site');
        try {
            $this->customerServiceInvoiceItemService->update($id, $request->validated());
            return redirect()->route('customer_service_invoice_items.index')->with('message', __('app.success_operation'));
        } catch (\Exception $e) {
            return redirect()->back()->with("message", $e->getMessage());
        }
    } //end of update

    public function destroy(Request $request, $id)
    {
        // userCan(request: $request, permission: 'delete_site');
        try {
            $result = $this->customerServiceInvoiceItemService->destroy($id);
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
            $customerServiceInvoiceItem = $this->customerServiceInvoiceItemService->findById(id: $id);
            return view('layouts.dashboard.customer_service_invoice_items.show', compact('customerServiceInvoiceItem'));
        }catch(Exception $e){
            dd($e);
            return redirect()->back()->with("message", __('app.something_went_wrong'));
        }
    } //end of show

}
