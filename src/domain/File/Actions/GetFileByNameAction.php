<?php

namespace Src\domain\File\Actions;

use Src\domain\File\Contracts\FileRepositoryInterface;
use Src\domain\File\DTO\FileDto;
use Src\domain\File\Mappers\FileMapper;

class GetFileByNameAction
{
    public function __construct(private FileRepositoryInterface $fileRepository)
    { }

    public function execute(string $name): ?FileDto
    {
        $file = $this->fileRepository->getFileByName($name);

        if(empty($file)) {
            return null;
        }

        return FileMapper::entityToDto($file);
    }
}
