<?php

namespace Src\domain\File\Entities;

use Src\domain\File\Helpers\FileHelper;

class File
{
    /**
     * @param string $fileName
     * @param string $extension
     * @param \DateTimeImmutable $sentAt
     * @param FileContent[] $content
     */
    public function __construct(
        private ?int $id,
        private string $fileName,
        private string $extension,
        private \DateTimeImmutable $sentAt,
        private array $content
    ){
        FileHelper::validateExtension($this->extension);
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getFileName(): string
    {
        return $this->fileName;
    }

    /**
     * @return string
     */
    public function getExtension(): string
    {
        return $this->extension;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getSentAt(): \DateTimeImmutable
    {
        return $this->sentAt;
    }

    /**
     * @return FileContent[]
     */
    public function getContent(): array
    {
        return $this->content;
    }

    /**
     * @param FileContent $content
     */
    public function addContent(FileContent $content)
    {
        $this->content[] = $content;
    }
}
