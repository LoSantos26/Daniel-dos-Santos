<?php

namespace Src\domain\File\Actions;

use Src\domain\File\Contracts\FileRepositoryInterface;
use Src\domain\File\DTO\FileDto;
use Src\domain\File\Entities\File;

class CreateFileAction
{
    public function __construct(private FileRepositoryInterface $fileRepository)
    { }

    public function execute(FileDto $fileDto): File
    {
        $file = $this->fileRepository->getFileByName($fileDto->fileName);

        if(!empty($file)) {
            throw new \Exception('Arquivo com este nome já existe.');
        }


    }
}
