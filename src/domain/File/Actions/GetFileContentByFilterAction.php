<?php

namespace Src\domain\File\Actions;

use Illuminate\Pagination\LengthAwarePaginator;
use Src\domain\File\Contracts\FileRepositoryInterface;
use Src\domain\File\DTO\FileContentDto;
use Src\domain\File\DTO\FileDto;
use Src\domain\File\DTO\GetFileByFilterInputDto;
use Src\domain\File\DTO\GetFileContentByFilterInputDto;
use Src\domain\File\Entities\FileContent;
use Src\domain\File\Mappers\FileMapper;

class GetFileContentByFilterAction
{
    public function __construct(private FileRepositoryInterface $fileRepository)
    { }

    public function execute(GetFileContentByFilterInputDto $inputDto): FileContentDto|LengthAwarePaginator
    {
        $file = $this->fileRepository->getContentByFilter($inputDto->toArray());

        if($file instanceof FileContent) {
            return FileMapper::entityToDtoContent($file);
        }

        $file->getCollection()->transform(function ($file) {
            return FileMapper::entityToDto($file);
        });

        return $file;
    }
}
