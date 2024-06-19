<?php

namespace App\Http\Controllers\Web;

use Exception;
use App\Models\Supplier;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\SupplierContactService;

use App\Services\SupplierAddressesService;
use App\DataTables\SupplierContactsDataTable;
use App\DataTables\SupplierAddressesDataTable;
use App\Http\Requests\StoreSupplierContactRequest;
use App\Http\Requests\UpdateSupplierContactRequest;
use App\Http\Requests\StoreSupplierAddressesRequest;
use App\Http\Requests\UpdateSupplierAddressesRequest;


class SupplierContactController extends Controller
{
    public function __construct(private SupplierContactService $supplierContactService)
    {

    }

    public function index(SupplierContactsDataTable $dataTable, Request $request)
    {
        // userCan(request: $request, permission: 'view_site');
        $filters = array_filter($request->get('filters', []), function ($value) {
            return ($value !== null && $value !== false && $value !== '');
        });
        return $dataTable->with(['filters'=>$filters])->render('layouts.Dashboard.supplier_contacts.index');
    }//end of index

    public function edit(Request $request, $id)
    {
        // userCan(request: $request, permission: 'edit_site');
        try{
            $supplier_contact = $this->supplierContactService->findById(id: $id);
            return view('layouts.Dashboard.supplier_contacts.edit', compact('supplier_contact'));
        }catch(Exception $e){
            dd($e);
            return redirect()->back()->with("message", __('lang.something_went_wrong'));
        }
        
    }//end of create

    public function create(Request $request)
    {

        // userCan(request: $request, permission: 'create_site');
        return view('layouts.dashboard.supplier_contacts.create');
    }//end of create

    public function store(StoreSupplierContactRequest $request)
    {

        // userCan(request: $request, permission: 'create_site');
        try {
            $this->supplierContactService->store(data: $request->validated());
            return redirect()->route('supplier_contacts.index')->with('message', __('lang.success_operation'));
        } catch (Exception $e) {
            dd($e);
            return redirect()->back()->with('message', $e->getMessage());
        }
    }//end of store

    public function update(UpdateSupplierContactRequest $request, $id)
    {
        // userCan(request: $request, permission: 'edit_site');
        try {
            $this->supplierContactService->update($id, $request->validated());
            return redirect()->route('supplier_contacts.index')->with('message', __('lang.success_operation'));
        } catch (\Exception $e) {
            return redirect()->back()->with("message", $e->getMessage());
        }
    } //end of update

    public function destroy(Request $request, $id)
    {
        // userCan(request: $request, permission: 'delete_site');
        try {
            $result = $this->supplierContactService->destroy($id);
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
            $supplierContact = $this->supplierContactService->findById(id: $id);
            return view('layouts.dashboard.supplier_contacts.show', compact('supplierContact'));
        }catch(Exception $e){
            dd($e);
            return redirect()->back()->with("message", __('lang.something_went_wrong'));
        }
    } //end of show

}
