<?php

namespace Src\domain\File\Actions;

use Src\domain\File\Contracts\FileRepositoryInterface;
use Src\domain\File\DTO\FileDto;
use Src\domain\File\DTO\GetFileByFilterInputDto;
use Src\domain\File\Mappers\FileMapper;

class GetFileByFilterAction
{
    public function __construct(private FileRepositoryInterface $fileRepository)
    { }

    public function execute(GetFileByFilterInputDto $inputDto): ?FileDto
    {
        $file = $this->fileRepository->getFileByFilter($inputDto->toArray());

        if (empty($file)) {
            return null;
        }

        return FileMapper::entityToDto($file);
    }
}
