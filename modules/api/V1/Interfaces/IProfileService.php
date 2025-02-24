<?php
namespace API\V1\Interfaces;

use API\V1\DTO\Profile\ProfileResponse;

interface IProfileService {
    /**
     * Get user profile by UUID
     * 
     * @param string $uuid User UUID
     * @return ProfileResponse
     * @throws \Exception If profile not found or other errors
     */
    public function getProfile(string $uuid): ProfileResponse;
}
