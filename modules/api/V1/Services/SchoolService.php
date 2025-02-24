<?php
namespace API\V1\Services;

use API\V1\Interfaces\ISchoolService;
use API\V1\Models\SchoolModel;
use API\V1\DTO\School\SchoolResponse;

class SchoolService implements ISchoolService {
    private SchoolModel $schoolModel;

    public function __construct() {
        $this->schoolModel = new SchoolModel();
    }

    public function getSchool(string $id): SchoolResponse {
        $schoolData = $this->schoolModel->getSchoolByNanoId($id);
        
        if ($schoolData === null) {
            throw new \Exception("School not found", 404);
        }

        try {
            return new SchoolResponse($schoolData);
        } catch (\Exception $e) {
            throw new \Exception("Error processing school data: " . $e->getMessage(), 500);
        }
    }
}
