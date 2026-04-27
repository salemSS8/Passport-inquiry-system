<?php

namespace App\Http\Docs\V1;

use OpenApi\Attributes as OA;

class InquiryDocs
{
    #[OA\Get(
        path: "/api/v1/inquiry/{identifier}",
        summary: "Inquire about passport status",
        tags: ["Inquiry"]
    )]
    #[OA\Parameter(
        name: "identifier",
        in: "path",
        description: "Tracking Number or National ID",
        required: true,
        schema: new OA\Schema(type: "string")
    )]
    #[OA\Response(
        response: 200,
        description: "Application found"
    )]
    #[OA\Response(response: 404, description: "Application not found")]
    public function show() {}
}
