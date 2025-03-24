<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * @OA\Info(
 *     version="1.0.0",
 *     title="Candidate Management API",
 *     description="API for managing job offers and applications",
 *     @OA\Contact(
 *         name="API Support",
 *         email="your-email@example.com"
 *     )
 * )
 * 
 * @OA\Server(
 *     url=L5_SWAGGER_CONST_HOST,
 *     description="API Server"
 * )
 * 
 * @OA\SecurityScheme(
 *     securityScheme="jwt",
 *     type="http",
 *     scheme="bearer"
 * )
 */

 
class OpenApiConfig extends Controller
{
    //
}
