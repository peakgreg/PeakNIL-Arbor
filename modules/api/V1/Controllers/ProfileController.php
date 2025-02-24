<?php
namespace API\V1\Controllers;

use API\Core\Request;
use API\Core\Response;
use API\V1\Services\ProfileService;

class ProfileController {
    private ProfileService $profileService;

    public function __construct() {
        $this->profileService = new ProfileService();
    }

    public function getProfile(Request $request): void {
        try {
            // Validate request parameters
            $validationRules = [
                "uuid" => [
                    "required" => true,
                    "type" => "uuid",
                    "message" => "Invalid UUID format"
                ]
            ];

            $errors = $request->validate($validationRules);
            if (!empty($errors)) {
                Response::badRequest("Validation failed", $errors)->send();
                return;
            }

            // Get profile data
            $uuid = $request->getParam("uuid");
            $profileResponse = $this->profileService->getProfile($uuid);

            // Send response
            Response::success($profileResponse->toArray(), "Profile retrieved successfully")->send();

        } catch (\Exception $e) {
            $code = $e->getCode();
            if (!in_array($code, [400, 401, 403, 404, 429])) {
                $code = 500;
            }

            error_log("Profile API Error: " . $e->getMessage());
            Response::error($e->getMessage(), $code)->send();
        }
    }
}
