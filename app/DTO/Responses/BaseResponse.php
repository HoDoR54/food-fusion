<?php

namespace App\DTO\Responses;

class BaseResponse
{
    private bool $success;
    private string $message;
    private int $status_code;
    private mixed $data;

    public function __construct(bool $success, string $message, int $status_code, mixed $data = null)
    {
        $this->success = $success;
        $this->message = $message;
        $this->status_code = $status_code;
        $this->data = $data;
    }

    public function toArray(): array
    {
        return [
            'success' => $this->success,
            'message' => $this->message,
            'status_code' => $this->status_code,
            'data' => $this->convertToArray($this->data),
        ];
    }

    private function convertToArray($data)
    {
        if (is_null($data)) {
            return null;
        }
        
        if (is_array($data)) {
            return array_map([$this, 'convertToArray'], $data);
        }
        
        if (is_object($data) && method_exists($data, 'toArray')) {
            return $data->toArray();
        }
        
        return $data;
    }
}