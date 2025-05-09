<?php

namespace Src\domain\File\Facades;

use Src\domain\File\Actions\CreateFileAction;
use Src\domain\File\DTO\FileDto;
use Src\domain\File\Repositories\FileRepository;

class FileFacade
{
    /**
     * @param FileDto $fileDto
     * @return FileDto
     * @throws \Exception
     */
    public static function create(FileDto $fileDto): FileDto
    {
        $action = new CreateFileAction(new FileRepository());
        return $action->execute($fileDto);
    }
}
