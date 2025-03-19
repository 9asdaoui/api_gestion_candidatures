<?php

namespace App\Http\Controllers;

use App\Models\offer;
use App\Http\Requests\StoreofferRequest;
use App\Http\Requests\UpdateofferRequest;
use App\Models\Offer as ModelsOffer;
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
        $validated = $request->validate([
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

        try {
            $user = $request->user();

            $validated['user_id'] = $user->id;

            $offer = Offer::create($validated);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }

        return response()->json([
            'offer' => $offer,
        ], 201);
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
             
        $this->authorize('update', $offer);

        $validated =  $request->validate([
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

        $offer->update($validated);

        return response()->json([
           'offer' => "offer",
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
        $this->authorize('delete', $offer); 

        $offer->delete();

        return response()->json(['message' => 'Offer deleted successfully'], 200);
    }
}
