<?php

namespace App\Http\Controllers;

use App\Models\Application;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
/**
 * Controller for managing applications
 */
    public function index()
    {
        $applications = Application::all();
        if ($applications->isEmpty()) {
            return response()->json(['message' => 'No applications found'], 404);
        }
        return response()->json($applications);
    }

    /**
     * @OA\Get(
     *     path="/api/applications/{id}",
     *     summary="Get application by ID",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Successful"),
     *     @OA\Response(response=404, description="Application not found")
     * )
     */
    public function show($id)
    {
        $application = Application::find($id);
        if (!$application) {
            return response()->json(['message' => 'Application not found'], 404);
        }
        return response()->json($application);
    }

    /**
     * @OA\Post(
     *     path="/api/applications",
     *     summary="Create a new application",
     *     @OA\Response(response=201, description="Application created"),
     *     @OA\Response(response=422, description="Validation error")
     * )
     */
    public function store(Request $request)
    {
        $request->validate([
            'offer_id' => 'required|exists:offers,id',
            'user_id' => 'required|exists:users,id',
            'resume' => 'required|file|mimes:pdf,doc,docx|max:2048',
        ]);

        $resumePath = $request->file('resume')->store('resumes', 'public');

        $application = Application::create([
            'offer_id' => $request->offer_id,
            'user_id' => $request->user_id,
            'resume_path' => $resumePath
        ]);

        return response()->json($application, 201);
    }

    /**
     * @OA\Delete(
     *     path="/api/applications/{id}",
     *     summary="Delete an application",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=204, description="Application deleted"),
     *     @OA\Response(response=404, description="Application not found")
     * )
     */
    public function destroy($id)
    {
        $application = Application::findOrFail($id);
        
        // Delete resume file
        if (file_exists(public_path('storage/' . $application->resume_path))) {
            unlink(public_path('storage/' . $application->resume_path));
        }
        
        $application->delete();
        
        return response()->json(null, 204);
    }

    /**
     * @OA\Get(
     *     path="/api/showResume/{id}",
     *     summary="Download application resume",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Resume downloaded"),
     *     @OA\Response(response=404, description="Application not found")
     * )
     */
    public function showResume($id)
    {
        $application = Application::find($id);
        if (!$application) {
            return response()->json(['message' => 'Application not found'], 404);
        }
        return response()->download(public_path('storage/' . $application->resume_path));
    }
}
