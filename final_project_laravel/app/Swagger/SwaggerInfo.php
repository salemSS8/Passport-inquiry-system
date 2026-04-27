<?php

namespace App\Swagger;

use OpenApi\Attributes as OA;

#[OA\Info(
    title: "Passport Inquiry System API",
    version: "1.0.0",
    description: "API documentation for the Passport Inquiry System"
)]
#[OA\Server(
    url: "http://localhost:8000",
    description: "Local Development Server"
)]
#[OA\SecurityScheme(
    securityScheme: "sanctum",
    type: "http",
    scheme: "bearer"
)]
class SwaggerInfo
{
}
