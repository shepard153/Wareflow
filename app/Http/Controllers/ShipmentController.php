<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;

class ShipmentController extends Controller
{
    /**
     * @return Response
     */
    public function index(): Response
    {
        return Inertia::render('Shipments');
    }

    /**
     * @return Response
     */
    public function create(): Response
    {
        // You can pass any necessary data to the view if needed
        return Inertia::render('Shipments/Create');
    }

    public function store(Request $request)
    {
        // Validate the form data
        $validatedData = $request->validate([
            'product_id' => 'required|exists:products,id',
            'contact_id' => 'required|exists:contacts,id',
            'warehouse_id' => 'required|exists:warehouses,id',
            'quantity' => 'required|integer|min:1',
            'shipment_date' => 'required|date',
            'recipient_name' => 'required|string',
            'recipient_address' => 'nullable|string',
            'tracking_number' => 'nullable|string',
        ]);

        // Create a new shipment using the validated data
        Shipment::create($validatedData);

        // Optionally, you can add success messages or redirect to a success page
        return redirect()->route('shipments.index')->with('success', 'Shipment created successfully!');
    }
}
