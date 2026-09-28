<?php

namespace App\Http\Controllers;

use App\Models\PricingPlan;
use Illuminate\Http\Request;

class PricingPlanController extends Controller
{
    /**
     * Display a listing of the pricing plans.
     */
    public function index()
    {
        return response()->json([
            'data' => PricingPlan::all(),
        ]);
    }

    /**
     * Store a newly created pricing plan in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'nullable|string',
            'billingPeriod' => 'nullable|string|max:255',
            'benefits' => 'nullable|array',
            'benefits.*' => 'string',
            'duration' => 'nullable|string|max:255',
        ]);

        $pricingPlan = PricingPlan::create($validated);

        return response()->json([
            'data' => $pricingPlan,
        ], 201);
    }

    /**
     * Display the specified pricing plan.
     */
    public function show(PricingPlan $pricing)
    {
        return response()->json([
            'data' => $pricing,
        ]);
    }

    /**
     * Update the specified pricing plan in storage.
     */
    public function update(Request $request, PricingPlan $pricing)
    {
        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'nullable|string',
            'billingPeriod' => 'nullable|string|max:255',
            'benefits' => 'nullable|array',
            'benefits.*' => 'string',
            'duration' => 'nullable|string|max:255',
        ]);

        $pricing->update($validated);

        return response()->json([
            'data' => $pricing,
        ]);
    }

    /**
     * Remove the specified pricing plan from storage.
     */
    public function destroy(PricingPlan $pricing)
    {
        $pricing->delete();

        return response()->json([
            'message' => 'Pricing plan deleted successfully',
        ]);
    }
}
