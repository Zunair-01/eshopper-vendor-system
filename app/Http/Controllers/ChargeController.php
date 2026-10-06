<?php

namespace App\Http\Controllers;

use App\Models\Charge;
use Illuminate\Http\Request;

class ChargeController extends Controller
{
    public function getCharges()
    {
        // Retrieve all charges from the database
        $charges = Charge::all();
        return response()->json($charges);
    }

    // Method to store a new charge
    public function store(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'tax' => 'required|numeric',
            'discount' => 'required|numeric',
            'deliveryCharges' => 'required|numeric',
        ]);

        // Create a new charge record in the database
        $charge = Charge::create([
            'tax' => $request->tax,
            'discount' => $request->discount,
            'delivery_charges' => $request->deliveryCharges,
        ]);

        // Return the newly created charge as a JSON response
        return response()->json($charge, 201);
    }
    public function update(Request $request, $id)
    {
        // Validate the incoming request data
        $request->validate([
            'tax' => 'required|numeric',
            'discount' => 'required|numeric',
            'deliveryCharges' => 'required|numeric',
        ]);

        // Find the charge by ID
        $charge = Charge::findOrFail($id);

        // Update the charge with new data
        $charge->tax = $request->input('tax');
        $charge->discount = $request->input('discount');
        $charge->delivery_charges = $request->input('deliveryCharges');
        $charge->save(); // Save the updated charge

        // Return a response (you can customize this)
        return response()->json(['message' => 'Charges updated successfully!', 'charge' => $charge]);
    }
}
