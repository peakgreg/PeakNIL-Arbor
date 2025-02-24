-- Insert a test API key (key: test-api-key-123)
INSERT INTO `api_keys` (`api_key_hash`, `name`, `is_active`, `rate_limit`, `requests_made`) 
VALUES (
    'a7c230f6c6d47276172894613e1359b47ee47087e8c71f0635eb28ad7fc19e8c', -- SHA-256 hash of 'test-api-key-123'
    'Test API Key',
    1,
    1000,
    0
);
