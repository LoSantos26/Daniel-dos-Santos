<?php

namespace Src\domain\File\DTO;

use Src\domain\File\Helpers\FileHelper;

class FileDto
{
    /**
     * @param int|null $id
     * @param string $fileName
     * @param string $extension
     * @param \DateTimeImmutable $sentAt
     * @param FileContentDto[] $content
     */
    public function __construct(
        public ?int $id,
        public string $fileName,
        public string $extension,
        public \DateTimeImmutable $sentAt,
        public array $content
    ){
        FileHelper::validateExtension($this->extension);;
    }
}
