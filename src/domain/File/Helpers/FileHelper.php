<?php

namespace Src\domain\File\Helpers;

class FileHelper
{
    public const ALLOW_EXTENSIONS = [
        'csv'
    ];

    public static function validateExtension(string $extension): void
    {
        if(!in_array($extension, self::ALLOW_EXTENSIONS)) {
            throw new \Exception('Extensão não permitida.', 400);
        }
    }
}
