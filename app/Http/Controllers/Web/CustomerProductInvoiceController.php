<?php

namespace App\Http\Controllers\Web;

use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\CustomerProductInvoiceService;
use App\DataTables\CustomerProductInvoicesDataTable;
use App\DTO\CustomerProductInvoice\CustomerProductInvoiceDTO;
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
        return $dataTable->with(['filters'=>$filters])->render('layouts.dashboard.customer_product_invoices.index');
    }//end of index

    public function edit(Request $request, $id)
    {
        // userCan(request: $request, permission: 'edit_site');
        try{
            $customerProductInvoice = $this->customerProductInvoiceService->findById(id: $id);
            return view('layouts.dashboard.customer_product_invoices.edit', compact('customerProductInvoice'));
        }catch(Exception $e){
            return redirect()->back()->with("message", __('app.something_went_wrong'));
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
            $customerProductInvoiceDTO = CustomerProductInvoiceDTO::fromRequest($request);
            $this->customerProductInvoiceService->store(DTO: $customerProductInvoiceDTO);
            session()->flash('message', __('app.success_operation'));
            return response()->json(['message' => __('app.success_operation')], 200); // HTTP 200 OK
            // return redirect()->route('customer_product_invoices.index')->with('message', __('app.success_operation'));
        } catch (Exception $e) {
            session()->flash('error', __('app.error_operation'));
            return response()->json(['message' => __('app.error_operation')], 422); // HTTP 422 Unprocessable Entity
            // return apiResponse(message: $e->getMessage(), code: 422);
        }
    }//end of store

    public function update(UpdateCustomerProductInvoiceRequest $request, $id)
    {
        // userCan(request: $request, permission: 'edit_site');
        try {
            $this->customerProductInvoiceService->update($id, $request->validated());
            return redirect()->route('customer_product_invoices.index')->with('message', __('app.success_operation'));
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
            $customerProductInvoice = $this->customerProductInvoiceService->findById(id: $id);
            return view('layouts.dashboard.customer_product_invoices.show', compact('customerProductInvoice'));
        }catch(Exception $e){
            dd($e);
            return redirect()->back()->with("message", __('app.something_went_wrong'));
        }
    } //end of show

}
