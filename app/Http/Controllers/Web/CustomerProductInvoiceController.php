<?php

namespace App\Http\Controllers\Web;

use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\CustomerProductInvoiceService;
use App\DataTables\CustomerProductInvoicesDataTable;
use App\Http\Requests\StoreCustomerProductInvoiceRequest;
use App\Http\Requests\UpdateCustomerProductInvoiceRequest;


class CustomerProductInvoiceController extends Controller
{
    public function __construct(private CustomerProductInvoiceService $customerProductInvoiceService)
    {

    }

    public function index(CustomerProductInvoicesDataTable $dataTable, Request $request)
    {
        // userCan(request: $request, permission: 'view_site');
        $filters = array_filter($request->get('filters', []), function ($value) {
            return ($value !== null && $value !== false && $value !== '');
        });
        return $dataTable->with(['filters'=>$filters])->render('layouts.Dashboard.customer_product_invoices.index');
    }//end of index

    public function edit(Request $request, $id)
    {
        // userCan(request: $request, permission: 'edit_site');
        try{
            $customerProductInvoice = $this->customerProductInvoiceService->findById(id: $id);
            return view('layouts.Dashboard.customer_product_invoices.edit', compact('customerProductInvoice'));
        }catch(Exception $e){
            return redirect()->back()->with("message", __('lang.something_went_wrong'));
        }
        
    }//end of create

    public function create(Request $request)
    {
        // userCan(request: $request, permission: 'create_site');
        return view('layouts.dashboard.customer_product_invoices.create');
    }//end of create

    public function store(StoreCustomerProductInvoiceRequest $request)
    {
        // userCan(request: $request, permission: 'create_site');
        try {
            $this->customerProductInvoiceService->store(data: $request->validated());
            return redirect()->route('customer_product_invoices.index')->with('message', __('lang.success_operation'));
        } catch (Exception $e) {
            dd($e);
            return redirect()->back()->with('message', $e->getMessage());
        }
    }//end of store

    public function update(UpdateCustomerProductInvoiceRequest $request, $id)
    {
        // userCan(request: $request, permission: 'edit_site');
        try {
            $this->customerProductInvoiceService->update($id, $request->validated());
            return redirect()->route('customer_product_invoices.index')->with('message', __('lang.success_operation'));
        } catch (\Exception $e) {
            return redirect()->back()->with("message", $e->getMessage());
        }
    } //end of update

    public function destroy(Request $request, $id)
    {
        // userCan(request: $request, permission: 'delete_site');
        try {
            $result = $this->customerProductInvoiceService->destroy($id);
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
            $customerProductInvoice = $this->customerProductInvoiceService->findById(id: $id);
            return view('layouts.dashboard.customer_product_invoices.show', compact('customerProductInvoice'));
        }catch(Exception $e){
            dd($e);
            return redirect()->back()->with("message", __('lang.something_went_wrong'));
        }
    } //end of show

}
