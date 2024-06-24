<?php

namespace App\Http\Controllers\Web;

use App\DataTables\CustomerContactDataTable;
use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\CustomerContactService;

use App\DataTables\CustomerContactsDataTable;
use App\Http\Requests\CustomerContactStoreRequest;
use App\Http\Requests\CustomerContactUpdateRequest;
use App\Http\Requests\StoreCustomerContactRequest;
use App\Http\Requests\UpdateCustomerContactRequest;


class CustomerContactController extends Controller
{
    public function __construct(private CustomerContactService $customerContactService)
    {

    }

    public function index(CustomerContactDataTable $dataTable, Request $request)
    {
        // userCan(request: $request, permission: 'view_site');
        $filters = array_filter($request->get('filters', []), function ($value) {
            return ($value !== null && $value !== false && $value !== '');
        });
        return $dataTable->with(['filters'=>$filters])->render('layouts.Dashboard.customer_contacts.index');
    }//end of index

    public function edit(Request $request, $id)
    {
        // userCan(request: $request, permission: 'edit_site');
        try{
            $customer_contact = $this->customerContactService->findById(id: $id);
            return view('layouts.Dashboard.customer_contacts.edit', compact('customer_contact'));
        }catch(Exception $e){
            dd($e);
            return redirect()->back()->with("message", __('app.something_went_wrong'));
        }
        
    }//end of create

    public function create(Request $request)
    {

        // userCan(request: $request, permission: 'create_site');
        return view('layouts.dashboard.customer_contacts.create');
    }//end of create

    public function store(CustomerContactStoreRequest $request)
    {

        // userCan(request: $request, permission: 'create_site');
        try {
            $this->customerContactService->store(data: $request->validated());
            return redirect()->route('customer_contacts.index')->with('message', __('app.success_operation'));
        } catch (Exception $e) {
            dd($e);
            return redirect()->back()->with('message', $e->getMessage());
        }
    }//end of store

    public function update(CustomerContactUpdateRequest $request, $id)
    {
        // userCan(request: $request, permission: 'edit_site');
        try {
            $this->customerContactService->update($id, $request->validated());
            return redirect()->route('customer_contacts.index')->with('message', __('app.success_operation'));
        } catch (\Exception $e) {
            return redirect()->back()->with("message", $e->getMessage());
        }
    } //end of update

    public function destroy(Request $request, $id)
    {
        // userCan(request: $request, permission: 'delete_site');
        try {
            $result = $this->customerContactService->destroy($id);
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
            $customerContact = $this->customerContactService->findById(id: $id);
            return view('layouts.dashboard.customer_contacts.show', compact('customerContact'));
        }catch(Exception $e){
            dd($e);
            return redirect()->back()->with("message", __('app.something_went_wrong'));
        }
    } //end of show

}
