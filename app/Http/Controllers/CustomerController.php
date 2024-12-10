<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Http\Facades\File;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $customers = Customer::all(); 
        return view('customer.index',compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('customer.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $customer = new Customer;
        $customer->name = $request->input('name');
        $customer->email = $request->input('email');
        $customer->phone = $request->input('phone');
        $customer->address = $request->input('address');

        $customer->save();
        return redirect()->back()->with('status', 'Create successful customers');
    }

    /**
     * Display the specified resource.
     */
    // public function show(Customer $customer)
    // {
    //     //
    // }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer,$id)
    {
        $customers = Customer::find($id); 
        return view ('customer.edit',compact('customers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $customers = Customer::find($id); 
        $customers->name = $request->input('name');
        $customers->email = $request->input('email');
        $customers->phone = $request->input('phone');
        $customers->address = $request->input('address');

        $customers->update();
        return redirect()->back()->with('status', 'Update successful customers');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer,$id)
    {
        $customers = Customer::find($id); 
        $customers->delete();
        return redirect()->back()->with('status', 'Delete successful customers');

    }
}
