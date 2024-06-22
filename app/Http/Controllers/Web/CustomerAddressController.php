<?php

namespace App\Http\Controllers\Web;

use Exception;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\CustomerAddressService;
use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use App\DataTables\CustomerAddressDataTable;
use App\Http\Requests\CustomerAddressStoreRequest;
use App\Http\Requests\CustomerAddressUpdateRequest;
use App\Http\Requests\StoreCustomerAddressRequest;
use App\Http\Requests\UpdateCustomerAddressRequest;


class CustomerAddressController extends Controller
{
    public function __construct(private CustomerAddressService $customerAddressService)
    {

    }

    public function index(CustomerAddressDataTable $dataTable, Request $request)
    {
        // userCan(request: $request, permission: 'view_site');
        $filters = array_filter($request->get('filters', []), function ($value) {
            return ($value !== null && $value !== false && $value !== '');
        });
        return $dataTable->with(['filters'=>$filters])->render('layouts.Dashboard.customer_addresses.index');
    }//end of index

    public function edit(Request $request, $id)
    {
        // userCan(request: $request, permission: 'edit_site');
        try{
            $customer_address = $this->customerAddressService->findById(id: $id);
            return view('layouts.Dashboard.customer_addresses.edit', compact('customer_address'));
        }catch(Exception $e){
            dd($e);
            return redirect()->back()->with("message", __('lang.something_went_wrong'));
        }
        
    }//end of create

    public function create(Request $request)
    {
        // dd($request->all());
        // userCan(request: $request, permission: 'create_site');
        return view('layouts.dashboard.customer_addresses.create');
    }//end of create

    public function store(CustomerAddressStoreRequest $request)
    {

        // userCan(request: $request, permission: 'create_site');
        try {
            $this->customerAddressService->store(data: $request->validated());
            return redirect()->route('customer_addresses.index')->with('message', __('lang.success_operation'));
        } catch (Exception $e) {
            dd($e);
            return redirect()->back()->with('message', $e->getMessage());
        }
    }//end of store

    public function update(CustomerAddressUpdateRequest $request, $id)
    {
        // userCan(request: $request, permission: 'edit_site');
        try {
            $this->customerAddressService->update($id, $request->validated());
            return redirect()->route('customer_addresses.index')->with('message', __('lang.success_operation'));
        } catch (\Exception $e) {
            return redirect()->back()->with("message", $e->getMessage());
        }
    } //end of update

    public function destroy(Request $request, $id)
    {
        // userCan(request: $request, permission: 'delete_site');
        try {
            $result = $this->customerAddressService->destroy($id);
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
            $customerAddress = $this->customerAddressService->findById(id: $id);
            return view('layouts.dashboard.customer_addresses.show', compact('customerAddress'));
        }catch(Exception $e){
            return redirect()->back()->with("message", __('lang.something_went_wrong'));
        }
    } //end of show

}
