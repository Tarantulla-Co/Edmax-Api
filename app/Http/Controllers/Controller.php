<?php

namespace App\Http\Controllers;

use OpenApi\Annotations as OA;

/**
 * @OA\Info(
 *     title="Busanga API",
 *     version="1.0.0",
 *     description="API documentation for Busanga application",
 *     @OA\Contact(
 *         email="support@busanga.com"
 *     )
 * )
 * 
 * @OA\Server(
 *     url=L5_SWAGGER_CONST_HOST,
 *     description="API Server"
 * )
 * 
 * @OA\Tag(
 *     name="Authentication",
 *     description="User authentication endpoints"
 * )
 * 
 * @OA\Tag(
 *     name="Data",
 *     description="Data retrieval endpoints"
 * )
 * 
 * @OA\Schema(
 *     schema="User",
 *     type="object",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="name", type="string", example="John Doe"),
 *     @OA\Property(property="email", type="string", format="email", example="john@example.com"),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time")
 * )
 * 
 * @OA\Schema(
 *     schema="Error",
 *     type="object",
 *     @OA\Property(property="message", type="string", example="Error message"),
 *     @OA\Property(property="status", type="string", example="error"),
 *     @OA\Property(property="code", type="integer", example=400)
 * )
 * 
 * @OA\Schema(
 *     schema="Success",
 *     type="object",
 *     @OA\Property(property="message", type="string", example="Success message"),
 *     @OA\Property(property="status", type="string", example="success"),
 *     @OA\Property(property="code", type="integer", example=200)
 * )
 */
abstract class Controller
{
    //
}