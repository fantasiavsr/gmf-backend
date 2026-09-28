<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    /**
     * Display a listing of the services.
     */
    public function index()
    {
        return response()->json([
            'data' => Service::all(),
        ]);
    }

    /**
     * Store a newly created service in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'included' => 'nullable|array',
            'included.*' => 'string',
            'price' => 'nullable|string',
            'billingPeriod' => 'nullable|string|max:255',
            'duration' => 'nullable|string|max:255',
            'members' => 'nullable|integer|min:0',
        ]);

        $service = Service::create($validated);

        return response()->json([
            'data' => $service,
        ], 201);
    }

    /**
     * Display the specified service.
     */
    public function show(Service $service)
    {
        return response()->json([
            'data' => $service,
        ]);
    }

    /**
     * Update the specified service in storage.
     */
    public function update(Request $request, Service $service)
    {
        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'included' => 'nullable|array',
            'included.*' => 'string',
            'price' => 'nullable|string',
            'billingPeriod' => 'nullable|string|max:255',
            'duration' => 'nullable|string|max:255',
            'members' => 'nullable|integer|min:0',
        ]);

        $service->update($validated);

        return response()->json([
            'data' => $service,
        ]);
    }

    /**
     * Remove the specified service from storage.
     */
    public function destroy(Service $service)
    {
        $service->delete();

        return response()->json([
            'message' => 'Service deleted successfully',
        ]);
    }
}
