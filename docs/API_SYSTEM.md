# PeakNIL API System Documentation

This document provides a comprehensive overview of the PeakNIL API system, including its architecture, endpoints, authentication, and usage examples.

## Table of Contents

1. [API Overview](#api-overview)
2. [API Architecture](#api-architecture)
3. [Authentication](#authentication)
4. [Rate Limiting](#rate-limiting)
5. [API Endpoints](#api-endpoints)
6. [Request and Response Format](#request-and-response-format)
7. [Error Handling](#error-handling)
8. [API Key Management](#api-key-management)
9. [CORS Support](#cors-support)
10. [API Security](#api-security)
11. [Integration Examples](#integration-examples)
12. [Best Practices](#best-practices)
13. [Creating New Endpoints](#creating-new-endpoints)
14. [API Versioning](#api-versioning)
15. [Support and Troubleshooting](#support-and-troubleshooting)

## API Overview

The PeakNIL API provides programmatic access to PeakNIL platform data and functionality. The API follows REST principles, uses JSON for data formatting, and implements secure authentication via API keys.

Key features of the API include:
- RESTful architecture
- JSON data format
- API key authentication
- Rate limiting
- Comprehensive error handling
- CORS support for cross-origin requests
- Versioned endpoints

## API Architecture

The API follows a clean MVC (Model-View-Controller) architecture:

1. **Controllers** (`modules/api/V1/Controllers`)
   - Handle HTTP requests and responses
   - Validate input parameters
   - Route to appropriate services
   - Format responses

2. **Services** (`modules/api/V1/Services`)
   - Implement business logic
   - Transform data
   - Handle errors
   - Interact with models

3. **Models** (`modules/api/V1/Models`)
   - Handle database interactions
   - Implement data access layer
   - Build and execute queries
   - Return data to services

4. **DTOs** (`modules/api/V1/DTO`)
   - Define data transfer objects
   - Format response data
   - Ensure type safety
   - Standardize response structure

5. **Middleware** (`modules/api/Middleware`)
   - Handle authentication
   - Implement rate limiting
   - Process CORS headers
   - Validate requests

6. **Core** (`modules/api/Core`)
   - Provide base functionality
   - Handle database connections
   - Process requests and responses
   - Manage error handling

## Authentication

The API uses API key authentication for all requests. Each request must include an `X-API-KEY` header with a valid API key.

### API Key Format

API keys are 32-character alphanumeric strings. Example:
```
X-API-KEY: a1b2c3d4e5f6g7h8i9j0k1l2m3n4o5p6
```

### API Key Storage

API keys are stored as SHA-256 hashes in the database for security. The original API key is only shown once when generated and cannot be retrieved later.

### Authentication Process

1. The client includes the API key in the `X-API-KEY` header
2. The API middleware extracts the key and hashes it
3. The hash is compared to stored hashes in the database
4. If a match is found, the request is authenticated
5. If no match is found, a 401 Unauthorized response is returned

### Implementation Details

Authentication is implemented in the `modules/api/Middleware/APIAuth.php` file:

```php
class APIAuth {
    public static function authenticate($db) {
        // Get API key from header
        $apiKey = self::getApiKeyFromHeader();
        
        if (!$apiKey) {
            throw new Exception("API key is required", 401);
        }
        
        // Hash the API key
        $apiKeyHash = hash('sha256', $apiKey);
        
        // Check if API key exists and is active
        $stmt = $db->prepare("
            SELECT id, name, rate_limit, requests_made, is_active 
            FROM api_keys 
            WHERE api_key_hash = ? AND is_active = 1
        ");
        
        $stmt->bind_param('s', $apiKeyHash);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows === 0) {
            throw new Exception("Invalid API key", 401);
        }
        
        $apiKeyData = $result->fetch_assoc();
        
        // Check rate limit
        if ($apiKeyData['requests_made'] >= $apiKeyData['rate_limit']) {
            throw new Exception("Rate limit exceeded", 429);
        }
        
        // Update request count
        $updateStmt = $db->prepare("
            UPDATE api_keys 
            SET requests_made = requests_made + 1, 
                last_used_at = NOW() 
            WHERE id = ?
        ");
        
        $updateStmt->bind_param('i', $apiKeyData['id']);
        $updateStmt->execute();
        
        // Set rate limit headers
        header("X-RateLimit-Limit: {$apiKeyData['rate_limit']}");
        header("X-RateLimit-Remaining: " . ($apiKeyData['rate_limit'] - $apiKeyData['requests_made'] - 1));
        
        return $apiKeyData;
    }
    
    private static function getApiKeyFromHeader() {
        $headers = getallheaders();
        return $headers['X-API-KEY'] ?? null;
    }
}
```

## Rate Limiting

The API implements rate limiting to prevent abuse and ensure fair usage:

### Rate Limit Configuration

- Default rate limit: 1000 requests per hour per API key
- Custom rate limits can be configured per API key
- Rate limits are tracked in the database

### Rate Limit Headers

All API responses include rate limit headers:
- `X-RateLimit-Limit`: Maximum requests per hour
- `X-RateLimit-Remaining`: Remaining requests for the current hour
- `X-RateLimit-Reset`: Unix timestamp when the limit resets

### Rate Limit Exceeded

When a rate limit is exceeded, the API returns a 429 Too Many Requests response with a message indicating when the limit will reset.

### Implementation Details

Rate limiting is implemented in the `modules/api/Middleware/APIAuth.php` file as part of the authentication process.

## API Endpoints

The API provides the following endpoints:

### Profile Endpoint

Retrieves detailed profile information for a user.

```
GET /api/v1/profile
```

**Parameters**

| Name | Type | In | Required | Description |
|------|------|-----|----------|-------------|
| uuid | string | query | Yes | User's UUID |

**Response**

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

### School Endpoint

Retrieves detailed information about a school.

```
GET /api/v1/school
```

**Parameters**

| Name | Type | In | Required | Description |
|------|------|-----|----------|-------------|
| id | string | query | Yes | School's nanoid |

**Response**

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

## Request and Response Format

### Request Format

API requests should follow these guidelines:

- Use appropriate HTTP methods (GET, POST, PUT, DELETE)
- Include the `X-API-KEY` header for authentication
- Use query parameters for GET requests
- Use JSON in the request body for POST and PUT requests
- Set the `Content-Type` header to `application/json` for requests with a body

### Response Format

All API responses follow a standard format:

```json
{
    "success": boolean,
    "code": integer,
    "message": "string",
    "data": object|array,
    "meta": {
        "version": "string",
        "timestamp": integer
    }
}
```

- `success`: Boolean indicating if the request was successful
- `code`: HTTP status code
- `message`: Human-readable message describing the result
- `data`: Response data (object or array)
- `meta`: Metadata about the response
  - `version`: API version
  - `timestamp`: Unix timestamp of the response

### Response Headers

All API responses include the following headers:

```
Content-Type: application/json
X-API-Version: 1.0
Access-Control-Allow-Origin: *
Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS
Access-Control-Allow-Headers: Content-Type, X-API-KEY
```

## Error Handling

The API implements comprehensive error handling:

### Error Response Format

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

### Common Error Codes

| Status Code | Description |
|-------------|-------------|
| 400 | Bad Request - Invalid parameters |
| 401 | Unauthorized - Invalid or missing API key |
| 403 | Forbidden - Insufficient permissions |
| 404 | Not Found - Resource not found |
| 429 | Too Many Requests - Rate limit exceeded |
| 500 | Internal Server Error |

### Error Logging

All API errors are logged for monitoring and debugging purposes. Logs include:
- Error code and message
- Request details (method, URL, parameters)
- API key information
- Timestamp
- Stack trace (in development)

### Implementation Details

Error handling is implemented in the `modules/api/Core/Response.php` file:

```php
class Response {
    public static function success($data = [], $message = "Success", $code = 200) {
        return new self(true, $code, $message, $data);
    }
    
    public static function error($message = "Error", $code = 500, $data = []) {
        return new self(false, $code, $message, $data);
    }
    
    public function send() {
        http_response_code($this->code);
        header('Content-Type: application/json');
        
        echo json_encode([
            'success' => $this->success,
            'code' => $this->code,
            'message' => $this->message,
            'data' => $this->data,
            'meta' => [
                'version' => '1.0',
                'timestamp' => time()
            ]
        ]);
        
        exit;
    }
}
```

## API Key Management

### Generating API Keys

API keys can be generated using the provided script:

```bash
# Generate an API key with default rate limit (1000 requests/hour)
php scripts/generate_api_key.php "Your App Name"

# Generate an API key with custom rate limit
php scripts/generate_api_key.php "Your App Name" 2000
```

The script will output the API key and important information:
```
API Key generated successfully!
Name: Your App Name
Rate Limit: 1000 requests per hour
API Key: your-generated-api-key

IMPORTANT: Store this key securely. It cannot be retrieved later.
```

### API Key Database Schema

API keys are stored in the `api_keys` table:

```sql
CREATE TABLE `api_keys` (
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

### API Key Security

1. Store keys securely
2. Never commit keys to version control
3. Use environment variables
4. Rotate keys periodically
5. Monitor key usage

## CORS Support

The API implements Cross-Origin Resource Sharing (CORS) to allow requests from different domains:

### CORS Headers

```
Access-Control-Allow-Origin: *
Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS
Access-Control-Allow-Headers: Content-Type, X-API-KEY
```

### Preflight Requests

The API properly handles OPTIONS preflight requests with appropriate CORS headers.

### Implementation Details

CORS support is implemented in the `modules/api/Middleware/CORS.php` file:

```php
class CORS {
    public static function handle() {
        // Allow from any origin
        header("Access-Control-Allow-Origin: *");
        
        // Allow specific methods
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
        
        // Allow specific headers
        header("Access-Control-Allow-Headers: Content-Type, X-API-KEY");
        
        // Handle preflight requests
        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            http_response_code(200);
            exit;
        }
    }
}
```

## API Security

The API implements several security measures:

### API Key Authentication

- Each request must include a valid API key in the `X-API-KEY` header
- Keys are stored as SHA-256 hashes in the database
- Invalid or missing keys return 401 Unauthorized responses
- Keys can be deactivated at any time for security

### Rate Limiting

- Each API key has a configurable rate limit
- Limits are tracked per key in the database
- Exceeding limits returns 429 Too Many Requests
- Rate limits can be adjusted based on needs

### Input Validation

- All input parameters are strictly validated
- UUID format validation for IDs
- SQL injection protection via prepared statements
- XSS protection via proper output encoding

### Error Handling

- Standardized error responses
- Detailed error messages in development
- Sanitized error messages in production
- All errors are logged for monitoring

## Integration Examples

### PHP Example

```php
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
```

### Python Example

```python
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
```

### JavaScript Example

```javascript
const axios = require('axios');

const apiKey = 'your-api-key';
const uuid = 'user-uuid';

axios.get(`http://localhost:8001/api/v1/profile?uuid=${uuid}`, {
    headers: { 'X-API-KEY': apiKey }
})
.then(response => console.log(response.data))
.catch(error => console.error(error));
```

## Best Practices

### Rate Limiting

- Implement exponential backoff for retries
- Cache responses when possible
- Monitor rate limit headers
- Consider using a rate limit pool for distributed systems

### Error Handling

- Always check response status codes
- Handle rate limiting gracefully
- Log and monitor errors
- Implement proper retry logic

### Security

- Store API keys securely
- Use HTTPS in production
- Validate all input data
- Rotate API keys periodically
- Monitor for suspicious activity

### Performance

- Cache frequently accessed data
- Batch requests when possible
- Use compression for large responses
- Monitor response times

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

## API Versioning

The API uses versioning to ensure backward compatibility:

### Version Format

The API version is included in the URL path:
```
/api/v1/profile
```

### Version Changes

- Major version changes (v1 to v2) may include breaking changes
- Minor version changes are backward compatible
- Version-specific documentation is provided for each major version

### Version Headers

All API responses include a version header:
```
X-API-Version: 1.0
```

## Support and Troubleshooting

For API support or to report issues:
- Email: api-support@peaknil.com
- Documentation: https://docs.peaknil.com/api
- Status: https://status.peaknil.com

### Common Issues

1. **401 Unauthorized**
   - Check that your API key is valid
   - Ensure the API key is included in the X-API-KEY header
   - Verify the API key is active in the database

2. **429 Too Many Requests**
   - Check your rate limit usage
   - Implement exponential backoff for retries
   - Consider requesting a higher rate limit

3. **400 Bad Request**
   - Verify your request parameters
   - Check parameter types and formats
   - Ensure required parameters are included

4. **404 Not Found**
   - Verify the resource ID exists
   - Check the endpoint URL
   - Ensure you're using the correct API version
