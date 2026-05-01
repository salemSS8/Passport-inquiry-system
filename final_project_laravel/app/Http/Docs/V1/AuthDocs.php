<?php

namespace App\Http\Docs\V1;

use OpenApi\Attributes as OA;

class AuthDocs
{
    #[OA\Post(
        path: "/api/v1/login",
        summary: "Authenticate user and return token",
        tags: ["Authentication"]
    )]
    #[OA\RequestBody(
        required: true,
        content: new OA\JsonContent(
            required: ["email", "password"],
            properties: [
                new OA\Property(property: "email", type: "string", format: "email", example: "user@example.com"),
                new OA\Property(property: "password", type: "string", format: "password", example: "password")
            ]
        )
    )]
    #[OA\Response(
        response: 200,
        description: "Login successful",
        content: new OA\JsonContent(
            properties: [
                new OA\Property(property: "user", type: "object"),
                new OA\Property(property: "token", type: "string")
            ]
        )
    )]
    #[OA\Response(response: 422, description: "Validation error")]
    public function login() {}

    #[OA\Post(
        path: "/api/v1/logout",
        summary: "Revoke user tokens",
        tags: ["Authentication"],
        security: [["sanctum" => []]]
    )]
    #[OA\Response(response: 200, description: "Logged out successfully")]
    public function logout() {}
}
