<?php
namespace API\Core;

class Response {
    private int $statusCode;
    private array $headers;
    private array $data;

    public function __construct(int $statusCode = 200) {
        $this->statusCode = $statusCode;
        $this->headers = [
            "Content-Type" => "application/json",
            "X-API-Version" => "1.0"
        ];
        $this->data = [
            "success" => ($statusCode >= 200 && $statusCode < 300),
            "code" => $statusCode,
            "message" => "",
            "data" => [],
            "meta" => [
                "version" => "1.0",
                "timestamp" => time()
            ]
        ];
    }

    public function setHeader(string $key, string $value): self {
        $this->headers[$key] = $value;
        return $this;
    }

    public function setData(array $data): self {
        $this->data["data"] = $data;
        return $this;
    }

    public function setMessage(string $message): self {
        $this->data["message"] = $message;
        return $this;
    }

    public function setMeta(array $meta): self {
        $this->data["meta"] = array_merge($this->data["meta"], $meta);
        return $this;
    }

    public function send(): void {
        http_response_code($this->statusCode);

        foreach ($this->headers as $key => $value) {
            header("$key: $value");
        }

        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
        header("Access-Control-Allow-Headers: Content-Type, X-API-KEY");

        if ($_SERVER["REQUEST_METHOD"] === "OPTIONS") {
            exit(0);
        }

        echo json_encode($this->data);
        exit;
    }

    public static function success(array $data = [], string $message = "Success", int $code = 200): self {
        $response = new self($code);
        return $response->setData($data)->setMessage($message);
    }

    public static function error(string $message, int $code = 400, array $data = []): self {
        $response = new self($code);
        return $response->setData($data)->setMessage($message);
    }

    public static function notFound(string $message = "Not Found"): self {
        return self::error($message, 404);
    }

    public static function unauthorized(string $message = "Unauthorized"): self {
        return self::error($message, 401);
    }

    public static function forbidden(string $message = "Forbidden"): self {
        return self::error($message, 403);
    }

    public static function badRequest(string $message = "Bad Request", array $data = []): self {
        return self::error($message, 400, $data);
    }

    public static function serverError(string $message = "Internal Server Error"): self {
        return self::error($message, 500);
    }
}
