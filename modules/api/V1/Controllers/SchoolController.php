<?php
namespace API\V1\Controllers;

use API\Core\Request;
use API\Core\Response;
use API\V1\Services\SchoolService;

class SchoolController {
    private SchoolService $schoolService;

    public function __construct() {
        $this->schoolService = new SchoolService();
    }

    public function getSchool(Request $request): void {
        try {
            // Validate request parameters
            $validationRules = [
                "id" => [
                    "required" => true,
                    "message" => "School ID is required"
                ]
            ];

            $errors = $request->validate($validationRules);
            if (!empty($errors)) {
                Response::badRequest("Validation failed", $errors)->send();
                return;
            }

            // Get school data
            $id = $request->getParam("id");
            $schoolResponse = $this->schoolService->getSchool($id);

            // Send response
            Response::success($schoolResponse->toArray(), "School retrieved successfully")->send();

        } catch (\Exception $e) {
            $code = $e->getCode();
            if (!in_array($code, [400, 401, 403, 404, 429])) {
                $code = 500;
            }

            error_log("School API Error: " . $e->getMessage());
            Response::error($e->getMessage(), $code)->send();
        }
    }
}
