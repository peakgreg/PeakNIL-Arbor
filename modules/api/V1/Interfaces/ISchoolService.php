<?php
namespace API\V1\Interfaces;

use API\V1\DTO\School\SchoolResponse;

interface ISchoolService {
    /**
     * Get school by nanoid
     * 
     * @param string $id School nanoid
     * @return SchoolResponse
     * @throws \Exception If school not found or other errors
     */
    public function getSchool(string $id): SchoolResponse;
}
