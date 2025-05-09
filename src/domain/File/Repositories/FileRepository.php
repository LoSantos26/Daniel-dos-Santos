<?php

namespace Src\domain\File\Repositories;

use Src\domain\File\Contracts\FileRepositoryInterface;
use Src\domain\File\Entities\File;
use Src\domain\File\Entities\FileContent;

class FileRepository implements FileRepositoryInterface
{
    public function createFile(File $file): File
    {
        // TODO: Implement createFile() method.
    }

    public function getFileByName(string $name): ?File
    {
        // TODO: Implement getFileByName() method.
    }

    public function getContentByFilter(): ?FileContent
    {
        // TODO: Implement getContentByFilter() method.
    }

    private function mapFile(object $fileData): File
    {
        return new File(
            $fileData->id,
            $fileData->file_name,
            $fileData->extension,
            new \DateTimeImmutable($fileData->sent_at),
            []
        );
    }
}
