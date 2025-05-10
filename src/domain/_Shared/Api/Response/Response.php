<?php

namespace Src\domain\_Shared\Api\Response;

class Response
{
    public function mountResponseApi(int $code, string $message)
    {
        return [
            'code' => $code,
            'message' => $message,
        ];
    }
}
