<?php

namespace App\Http\Controllers;

use App\Models\competence;
use App\Http\Requests\StorecompetenceRequest;
use App\Http\Requests\UpdatecompetenceRequest;
use Illuminate\Http\Request;

class CompetenceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $competences = Competence::all();
        return response()->json([
            'success' => true,
            'data' => $competences
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return response()->json([
            'message' => 'This endpoint is not applicable for API use'
        ], 404);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
        ]);
        
        try {
            $competence = Competence::where('name', $request->name)->first();
            
            if (!$competence) {
                $competence = Competence::create([
                    'name' => $request->name,
                ]);
            }

            $user = Request()->user();

            $user->competences()->attach($competence->id);

            return response()->json([
            'success' => true,
            'message' => 'Competence assigned successfully',
            'data' => $competence
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
            'success' => false,
            'message' => 'Failed to assign competence',
            'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(competence $competence)
    {
        return response()->json([
            'success' => true,
            'data' => $competence
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(competence $competence)
    {
        return response()->json([
            'message' => 'This endpoint is not applicable for API use'
        ], 404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, competence $competence)
    {
        $request->validate([
            'name' => 'required|string',
        ]);

        try {
            $competence->update([
                'name' => $request->name,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Competence updated successfully',
                'data' => $competence
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update competence',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(competence $competence)
    {
        try {
            $competence->delete();

            return response()->json([
                'success' => true,
                'message' => 'Competence deleted successfully',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete competence',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
