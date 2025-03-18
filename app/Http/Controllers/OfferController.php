<?php

namespace App\Http\Controllers;

use App\Models\offer;
use App\Http\Requests\StoreofferRequest;
use App\Http\Requests\UpdateofferRequest;
use Illuminate\Http\Request;

/**
 * Controller for managing job offers
 */
class OfferController extends Controller
{
    /**
     * Display a listing of the resource.
     * 
     * @OA\Get(
     *     path="/api/offers",
     *     summary="List all offers",
     *     @OA\Response(response=200, description="Successful")
     * )
     */
    public function index()
    {
        $offers = Offer::all();
        // return $offers;
        return response()->json($offers);
    }

    /**
     * Store a newly created resource in storage.
     * 
     * @OA\Post(
     *     path="/api/offers",
     *     summary="Create a new offer",
     *     @OA\Response(response=201, description="Offer created"),
     *     @OA\Response(response=422, description="Validation error")
     * )
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
     * 
     * @OA\Get(
     *     path="/api/offers/{offer}",
     *     summary="Get a specific offer",
     *     @OA\Parameter(
     *         name="offer",
     *         in="path",
     *         required=true,
     *         description="Offer ID"
     *     ),
     *     @OA\Response(response=200, description="Successful"),
     *     @OA\Response(response=404, description="Not found")
     * )
     */
    public function show(offer $offer)
    {
        return response()->json($offer);
    }

    /**
     * Update the specified resource in storage.
     * 
     * @OA\Put(
     *     path="/api/offers/{offer}",
     *     summary="Update an existing offer",
     *     @OA\Parameter(
     *         name="offer",
     *         in="path",
     *         required=true,
     *         description="Offer ID"
     *     ),
     *     @OA\Response(response=200, description="Successful"),
     *     @OA\Response(response=404, description="Not found"),
     *     @OA\Response(response=422, description="Validation error")
     * )
     */
    public function update(Request  $request, offer $offer)
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
        ]);

        $offer->update($request->all());

        return response()->json([
           'offer' => $offer,
        ],201);
    }

    /**
     * Remove the specified resource from storage.
     * 
     * @OA\Delete(
     *     path="/api/offers/{offer}",
     *     summary="Delete an offer",
     *     @OA\Parameter(
     *         name="offer",
     *         in="path",
     *         required=true,
     *         description="Offer ID"
     *     ),
     *     @OA\Response(response=200, description="Successful"),
     *     @OA\Response(response=404, description="Not found")
     * )
     */
    public function destroy(offer $offer)
    {
        $offer->delete();

        return response()->json(['message' => 'Offer deleted successfully'], 200);
    }
}
