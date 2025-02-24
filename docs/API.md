# PeakNIL API Documentation

## Overview

The PeakNIL API provides programmatic access to PeakNIL platform data and functionality. The API follows REST principles, uses JSON for data formatting, and implements secure authentication via API keys.

## Getting Started

### 1. Obtain an API Key

To access the API, you'll need an API key. API keys can be generated using the provided script:

```bash
# Generate an API key with default rate limit (1000 requests/hour)
php scripts/generate_api_key.php "Your App Name"

# Generate an API key with custom rate limit
php scripts/generate_api_key.php "Your App Name" 2000
```

The script will output your API key and important information:
```
API Key generated successfully!
Name: Your App Name
Rate Limit: 1000 requests per hour
API Key: your-generated-api-key

IMPORTANT: Store this key securely. It cannot be retrieved later.
```

### 2. Make Your First Request

Once you have your API key, you can start making requests:

```bash
# Example: Get a user's profile
curl -H "X-API-KEY: your-api-key" \
     "http://localhost:8001/api/v1/profile?uuid=user-uuid"

# Example using PHP
<?php
$apiKey = 'your-api-key';
$uuid = 'user-uuid';
$ch = curl_init();
curl_setopt_array($ch, [
    CURLOPT_URL => "http://localhost:8001/api/v1/profile?uuid=$uuid",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HTTPHEADER => [
        "X-API-KEY: $apiKey"
    ]
]);
$response = curl_exec($ch);
$data = json_decode($response, true);
curl_close($ch);

# Example using Python
import requests

api_key = 'your-api-key'
uuid = 'user-uuid'
headers = {'X-API-KEY': api_key}
response = requests.get(
    f'http://localhost:8001/api/v1/profile',
    headers=headers,
    params={'uuid': uuid}
)
data = response.json()

# Example using JavaScript/Node.js
const axios = require('axios');

const apiKey = 'your-api-key';
const uuid = 'user-uuid';

axios.get(`http://localhost:8001/api/v1/profile?uuid=${uuid}`, {
    headers: { 'X-API-KEY': apiKey }
})
.then(response => console.log(response.data))
.catch(error => console.error(error));
```

## Base URL

```
http://localhost:8001/api/v1
```

## Authentication

The API uses API key authentication. All requests must include an `X-API-KEY` header with a valid API key.

```bash
curl -H "X-API-KEY: your-api-key" "http://localhost:8001/api/v1/profile?uuid=user-uuid"
```

### Security Measures

1. **API Key Authentication**
   - Each request must include a valid API key in the `X-API-KEY` header
   - Keys are stored as SHA-256 hashes in the database
   - Invalid or missing keys return 401 Unauthorized responses
   - Keys can be deactivated at any time for security

2. **Rate Limiting**
   - Each API key has a configurable rate limit
   - Limits are tracked per key in the database
   - Exceeding limits returns 429 Too Many Requests
   - Rate limits can be adjusted based on needs

3. **CORS Protection**
   - Cross-Origin Resource Sharing (CORS) headers are implemented
   - Configurable allowed origins, methods, and headers
   - Pre-flight (OPTIONS) requests are properly handled

4. **Input Validation**
   - All input parameters are strictly validated
   - UUID format validation for IDs
   - SQL injection protection via prepared statements
   - XSS protection via proper output encoding

5. **Error Handling**
   - Standardized error responses
   - Detailed error messages in development
   - Sanitized error messages in production
   - All errors are logged for monitoring

## Endpoints

### Profile

#### Get Profile

Retrieves detailed profile information for a user.

```
GET /api/v1/profile
```

**Parameters**

| Name | Type | In | Required | Description |
|------|------|-----|----------|-------------|
| uuid | string | query | Yes | User's UUID |

**Request Example**

```bash
curl -H "X-API-KEY: your-api-key" \
     "http://localhost:8001/api/v1/profile?uuid=user-uuid"
```

**Success Response (200 OK)**

```json
{
    "success": true,
    "code": 200,
    "message": "Profile retrieved successfully",
    "data": {
        "first_name": "string",
        "middle_name": "string|null",
        "last_name": "string",
        "role_id": "integer",
        "gender": "string|null",
        "profile_description": "string|null",
        "tags": "string|null",
        "card_id": "string|null",
        "school_association": "string|null",
        "profile_image_path": "string|null",
        "profile_thumbnail_path": "string|null",
        "profile_image_status": "string|null",
        "cover_image_path": "string|null",
        "cover_image_status": "string|null",
        "position": "string|null",
        "position_abbreviation": "string|null",
        "sport_name": "string|null",
        "sport_abbreviation": "string|null",
        "sport_icon": "string|null",
        "school_nanoid": "string|null",
        "school_name": "string|null",
        "school_mascot": "string|null",
        "school_cover_image_path": "string|null",
        "school_marketplace_logo_path": "string|null",
        "flags": {
            "verified": "boolean",
            "imported": "boolean|null",
            "dynamic_pricing": "boolean",
            "deactivated": "boolean",
            "banned": "boolean"
        },
        "social_media": {
            "instagram_username": "string|null",
            "x_username": "string|null",
            "tiktok_username": "string|null",
            "facebook_username": "string|null",
            "linkedin_username": "string|null",
            "youtube_username": "string|null"
        },
        "instagram_stats": {
            "instagram_follower_count": "integer|null",
            "instagram_following_count": "integer|null",
            "instagram_media_count": "integer|null"
        },
        "tiktok_stats": {
            "tiktok_follower_count": "integer|null",
            "tiktok_following_count": "integer|null",
            "tiktok_verified": "boolean|null",
            "tiktok_signature": "string|null",
            "tiktok_heart_count": "integer|null",
            "tiktok_video_count": "integer|null",
            "tiktok_friend_count": "integer|null"
        },
        "x_stats": {
            "x_follower_count": "integer|null",
            "x_following_count": "integer|null",
            "x_favourites_count": "integer|null",
            "x_verified": "boolean|null",
            "x_signature": "string|null"
        }
    },
    "meta": {
        "version": "string",
        "timestamp": "integer"
    }
}
```

### School

#### Get School

Retrieves detailed information about a school.

```
GET /api/v1/school
```

**Parameters**

| Name | Type | In | Required | Description |
|------|------|-----|----------|-------------|
| id | string | query | Yes | School's nanoid |

**Request Example**

```bash
curl -H "X-API-KEY: your-api-key" \
     "http://localhost:8001/api/v1/school?id=school-nanoid"
```

**Success Response (200 OK)**

```json
{
    "success": true,
    "code": 200,
    "message": "School retrieved successfully",
    "data": {
        "nanoid": "string",
        "name": "string",
        "mascot": "string|null",
        "cover_photo_url_1": "string|null",
        "marketplace_logo": "string|null",
        "description": "string|null",
        "address": "string|null",
        "city": "string|null",
        "state": "string|null",
        "zip": "string|null",
        "phone": "string|null",
        "website": "string|null",
        "email": "string|null",
        "social_media": {
            "facebook": "string|null",
            "instagram": "string|null",
            "twitter": "string|null",
            "tiktok": "string|null",
            "youtube": "string|null"
        },
        "sports": ["integer"],
        "colors": {
            "primary": "string|null",
            "alternate": "string|null",
            "text": "string|null",
            "card1": "string|null",
            "card2": "string|null",
            "button": "string|null",
            "select": "string|null"
        }
    },
    "meta": {
        "version": "string",
        "timestamp": "integer"
    }
}
```

**Error Responses**

| Status Code | Description |
|-------------|-------------|
| 400 | Bad Request - Invalid parameters |
| 401 | Unauthorized - Invalid or missing API key |
| 404 | Not Found - School not found |
| 429 | Too Many Requests - Rate limit exceeded |
| 500 | Internal Server Error |

Error Response Format:
```json
{
    "success": false,
    "code": integer,
    "message": "string",
    "data": [],
    "meta": {
        "version": "string",
        "timestamp": integer
    }
}
```

## Response Headers

All API responses include the following headers:

```
Content-Type: application/json
X-API-Version: 1.0
Access-Control-Allow-Origin: *
Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS
Access-Control-Allow-Headers: Content-Type, X-API-KEY
```

## Rate Limiting

- Default rate limit: 1000 requests per hour per API key
- Rate limit headers included in responses:
  - X-RateLimit-Limit: Maximum requests per hour
  - X-RateLimit-Remaining: Remaining requests for the current hour
  - X-RateLimit-Reset: Unix timestamp when the limit resets

## Architecture

The API follows a clean MVC architecture:

1. **Controllers** (`modules/api/V1/Controllers`)
   - Handle HTTP requests and responses
   - Input validation
   - Route to appropriate services

2. **Services** (`modules/api/V1/Services`)
   - Business logic implementation
   - Data transformation
   - Error handling

3. **Models** (`modules/api/V1/Models`)
   - Database interactions
   - Data access layer
   - Query building

4. **DTOs** (`modules/api/V1/DTO`)
   - Data transfer objects
   - Response formatting
   - Type safety

5. **Middleware** (`modules/api/Middleware`)
   - Authentication
   - Rate limiting
   - CORS handling

## Error Handling

All errors follow a standard format:

```json
{
    "success": false,
    "code": integer,
    "message": "string",
    "data": [],
    "meta": {
        "version": "string",
        "timestamp": integer
    }
}
```

Common error codes:
- 400: Invalid request parameters
- 401: Authentication failure
- 403: Permission denied
- 404: Resource not found
- 429: Rate limit exceeded
- 500: Server error

## Best Practices

1. **Rate Limiting**
   - Implement exponential backoff for retries
   - Cache responses when possible
   - Monitor rate limit headers
   - Consider using a rate limit pool for distributed systems

2. **Error Handling**
   - Always check response status codes
   - Handle rate limiting gracefully
   - Log and monitor errors
   - Implement proper retry logic

3. **Security**
   - Store API keys securely
   - Use HTTPS in production
   - Validate all input data
   - Rotate API keys periodically
   - Monitor for suspicious activity

4. **Performance**
   - Cache frequently accessed data
   - Batch requests when possible
   - Use compression for large responses
   - Monitor response times

## Integration Tips

1. **Environment Management**
   - Use different API keys for development and production
   - Set up proper error logging
   - Monitor rate limit usage
   - Implement proper key rotation

2. **Testing**
   - Test with invalid API keys
   - Test rate limit handling
   - Test error scenarios
   - Use test UUIDs for development

3. **Deployment**
   - Use proper SSL/TLS in production
   - Set up monitoring and alerting
   - Implement proper logging
   - Have a rollback plan

## Support

For API support or to report issues:
- Email: api-support@peaknil.com
- Documentation: https://docs.peaknil.com/api
- Status: https://status.peaknil.com

## API Key Management

### Generating Keys

Use the provided script to generate API keys:

```bash
# Basic usage
php scripts/generate_api_key.php "App Name"

# With custom rate limit
php scripts/generate_api_key.php "App Name" 2000
```

### Key Security

1. Store keys securely
2. Never commit keys to version control
3. Use environment variables
4. Rotate keys periodically
5. Monitor key usage

### Database Schema

The API keys are stored in the `api_keys` table:

```sql
CREATE TABLE api_keys (
    id INT PRIMARY KEY AUTO_INCREMENT,
    api_key_hash VARCHAR(64) NOT NULL,
    name VARCHAR(255) NOT NULL,
    rate_limit INT NOT NULL DEFAULT 1000,
    requests_made INT NOT NULL DEFAULT 0,
    is_active BOOLEAN NOT NULL DEFAULT TRUE,
    created_at DATETIME NOT NULL,
    last_used_at DATETIME
);
```

## Creating New Endpoints

To add a new API endpoint, follow these steps:

1. **Create DTO (Data Transfer Object)**
   - Location: `modules/api/V1/DTO/YourFeature/YourFeatureResponse.php`
   - Purpose: Defines the structure of your API response
   - Example:
   ```php
   namespace API\V1\DTO\YourFeature;

   class YourFeatureResponse {
       private $data;

       public function __construct(array $data) {
           $this->data = $data;
       }

       public function toArray(): array {
           return $this->data;
       }
   }
   ```

2. **Create Interface**
   - Location: `modules/api/V1/Interfaces/IYourFeatureService.php`
   - Purpose: Defines the contract for your service
   - Example:
   ```php
   namespace API\V1\Interfaces;

   use API\V1\DTO\YourFeature\YourFeatureResponse;

   interface IYourFeatureService {
       public function getYourFeature(string $id): YourFeatureResponse;
   }
   ```

3. **Create Model**
   - Location: `modules/api/V1/Models/YourFeatureModel.php`
   - Purpose: Handles database interactions
   - Example:
   ```php
   namespace API\V1\Models;

   use API\Core\Database;

   class YourFeatureModel {
       private \mysqli $db;

       public function __construct() {
           $this->db = Database::getInstance()->getConnection();
       }

       public function getYourFeatureById(string $id): ?array {
           // Database operations
       }
   }
   ```

4. **Create Service**
   - Location: `modules/api/V1/Services/YourFeatureService.php`
   - Purpose: Implements business logic
   - Example:
   ```php
   namespace API\V1\Services;

   use API\V1\Interfaces\IYourFeatureService;
   use API\V1\Models\YourFeatureModel;
   use API\V1\DTO\YourFeature\YourFeatureResponse;

   class YourFeatureService implements IYourFeatureService {
       private YourFeatureModel $model;

       public function __construct() {
           $this->model = new YourFeatureModel();
       }

       public function getYourFeature(string $id): YourFeatureResponse {
           $data = $this->model->getYourFeatureById($id);
           if ($data === null) {
               throw new \Exception("Not found", 404);
           }
           return new YourFeatureResponse($data);
       }
   }
   ```

5. **Create Controller**
   - Location: `modules/api/V1/Controllers/YourFeatureController.php`
   - Purpose: Handles HTTP requests and responses
   - Example:
   ```php
   namespace API\V1\Controllers;

   use API\Core\Request;
   use API\Core\Response;
   use API\V1\Services\YourFeatureService;

   class YourFeatureController {
       private YourFeatureService $service;

       public function __construct() {
           $this->service = new YourFeatureService();
       }

       public function getYourFeature(Request $request): void {
           try {
               $id = $request->getParam("id");
               $response = $this->service->getYourFeature($id);
               Response::success($response->toArray())->send();
           } catch (\Exception $e) {
               Response::error($e->getMessage(), $e->getCode())->send();
           }
       }
   }
   ```

6. **Create Endpoint File**
   - Location: `modules/api/V1/Endpoints/YourFeature/api.yourfeature.php`
   - Purpose: Entry point for the API endpoint
   - Example:
   ```php
   <?php
   require_once __DIR__ . '/../../../../../config/init.php';

   use API\Core\Request;
   use API\Core\Response;
   use API\Middleware\APIAuth;
   use API\V1\Controllers\YourFeatureController;

   try {
       APIAuth::authenticate($db);
       $request = new Request();
       $controller = new YourFeatureController();

       switch ($request->getMethod()) {
           case 'GET':
               $controller->getYourFeature($request);
               break;
           default:
               Response::error('Method not allowed', 405)->send();
       }
   } catch (Exception $e) {
       Response::error($e->getMessage(), $e->getCode())->send();
   }
   ```

7. **Update Documentation**
   - Add your new endpoint to this documentation
   - Include request/response examples
   - Document any new parameters or response fields

### Best Practices for New Endpoints

1. **Naming Conventions**
   - Use PascalCase for classes and interfaces
   - Use camelCase for methods and variables
   - Use snake_case for database fields

2. **Error Handling**
   - Always use appropriate HTTP status codes
   - Provide meaningful error messages
   - Log errors appropriately

3. **Input Validation**
   - Validate all input parameters
   - Use type hints and return types
   - Document parameter requirements

4. **Response Format**
   - Follow the established response structure
   - Include appropriate metadata
   - Use consistent field naming

5. **Security**
   - Always require API key authentication
   - Validate user permissions if applicable
   - Sanitize all input and output

6. **Performance**
   - Optimize database queries
   - Use appropriate indexes
   - Consider caching for frequently accessed data
