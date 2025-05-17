<?php
namespace API\V1\Services;

use API\V1\Interfaces\IProfileService;
use API\V1\Models\ProfileModel;
use API\V1\DTO\Profile\ProfileResponse;

class ProfileService implements IProfileService {
    private ProfileModel $profileModel;

    public function __construct() {
        $this->profileModel = new ProfileModel();
    }

    public function getProfile(string $uuid): ProfileResponse {
        $profileData = $this->profileModel->getUserProfileData($uuid);
        
        if ($profileData === null) {
            throw new \Exception("Profile not found", 404);
        }

        try {
            return new ProfileResponse($profileData);
        } catch (\Exception $e) {
            throw new \Exception("Error processing profile data: " . $e->getMessage(), 500);
        }
    }
}
