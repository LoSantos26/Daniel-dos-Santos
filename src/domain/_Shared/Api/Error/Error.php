<?php

namespace Src\domain\_Shared\Api\Error;

class Error
{
    public function mountErrorApi(int $code, string $message)
    {
        return [
            'success' => false,
            'message' => $message,
        ];
    }
}
