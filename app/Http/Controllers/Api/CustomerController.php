<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CustomerController extends Controller
{
    // List all customers
    public function index()
    {
        return Customer::with('orders')->get();
    }

    // Show single customer
    public function show($id)
    {
        $customer = Customer::with('orders')->find($id);
        if (!$customer) {
            return response()->json(['message' => 'Customer not found'], 404);
        }
        return $customer;
    }

    // Create new customer
    public function store(Request $request)
    {
        $request->validate([
            'consumer_name' => 'required|string|max:255',
            'email' => 'required|email|unique:customers,email',
            'password' => 'required|string|min:6',
            'phone_number' => 'nullable|string',
            'address' => 'nullable|string',
        ]);

        $customer = Customer::create([
            'consumer_name' => $request->consumer_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone_number' => $request->phone_number,
            'address' => $request->address,
        ]);

        return response()->json($customer, 201);
    }

    // Update existing customer
    public function update(Request $request, $id)
    {
        $customer = Customer::find($id);
        if (!$customer) {
            return response()->json(['message' => 'Customer not found'], 404);
        }

        $customer->update($request->only('consumer_name', 'email', 'phone_number', 'address'));

        if ($request->password) {
            $customer->password = Hash::make($request->password);
            $customer->save();
        }

        return response()->json($customer);
    }

    // Delete customer
    public function destroy($id)
    {
        $customer = Customer::find($id);
        if (!$customer) {
            return response()->json(['message' => 'Customer not found'], 404);
        }

        $customer->delete();

        return response()->json(['message' => 'Customer deleted successfully']);
    }
}
