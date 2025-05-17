<?php
namespace API\Core;

class Request {
    private array $params;
    private array $headers;
    private string $method;

    public function __construct() {
        $this->params = array_merge($_GET, $_POST);
        $this->headers = $this->getRequestHeaders();
        $this->method = $_SERVER["REQUEST_METHOD"];
    }

    private function getRequestHeaders(): array {
        $headers = [];
        foreach ($_SERVER as $key => $value) {
            if (substr($key, 0, 5) === "HTTP_") {
                $header = str_replace(" ", "-", ucwords(str_replace("_", " ", strtolower(substr($key, 5)))));
                $headers[$header] = $value;
            }
        }
        return $headers;
    }

    public function getParam(string $key, $default = null) {
        return $this->params[$key] ?? $default;
    }

    public function getHeader(string $key, $default = null) {
        return $this->headers[$key] ?? $default;
    }

    public function getMethod(): string {
        return $this->method;
    }

    public function validate(array $rules): array {
        $errors = [];
        foreach ($rules as $field => $rule) {
            if (!isset($this->params[$field])) {
                if (isset($rule["required"]) && $rule["required"]) {
                    $errors[$field] = "Field is required";
                }
                continue;
            }

            $value = $this->params[$field];

            if (isset($rule["pattern"]) && !preg_match($rule["pattern"], $value)) {
                $errors[$field] = $rule["message"] ?? "Invalid format";
            }

            if (isset($rule["type"])) {
                switch ($rule["type"]) {
                    case "uuid":
                        if (!preg_match("/^[a-f0-9]{8}-[a-f0-9]{4}-[1-5][a-f0-9]{3}-[89ab][a-f0-9]{3}-[a-f0-9]{12}$/i", $value)) {
                            $errors[$field] = "Invalid UUID format";
                        }
                        break;
                    case "email":
                        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                            $errors[$field] = "Invalid email format";
                        }
                        break;
                }
            }
        }
        return $errors;
    }
}
