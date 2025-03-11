<?php

namespace App\Http\Controllers;

use App\Models\offer;
use App\Http\Requests\StoreofferRequest;
use App\Http\Requests\UpdateofferRequest;
use Illuminate\Http\Request;

class OfferController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $offers = Offer::all();
        // return $offers;
        return response()->json($offers);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'company_name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'salary' => 'nullable|numeric',
            'employment_type' => 'required|in:Full-time,Part-time,Contract,Freelance,Internship',
            'experience_level' => 'nullable|in:Entry-level,Mid-level,Senior,Manager,Executive',
            'required_skills' => 'nullable|json',
            'deadline' => 'nullable|date',
            'is_active' => 'boolean',
            'image' => 'nullable|string|max:255',
            'user_id' => 'required|exists:users,id',
        ]);

        $offer = Offer::create($request->all());

        return $offer;
    }

    /**
     * Display the specified resource.
     */
    public function show(offer $offer)
    {
        return response()->json($offer);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateofferRequest $request, offer $offer)
    {
        $offer->update($request->all());

        return response()->json($offer);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(offer $offer)
    {
        $offer->delete();

        return response()->json(['message' => 'Offer deleted successfully'], 200);
    }
}
