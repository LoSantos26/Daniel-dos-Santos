<?php

namespace Src\domain\File\DTO;

class FileDto
{
    /**
     * @param string $fileName
     * @param string $extension
     * @param \DateTimeImmutable $sentAt
     * @param FileContentDto[] $content
     */
    public function __construct(
        public string $fileName,
        public string $extension,
        public \DateTimeImmutable $sentAt,
        public array $content
    ){ }
}
