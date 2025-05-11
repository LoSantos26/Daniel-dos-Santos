<?php

namespace Src\domain\File\Facades;

use Illuminate\Pagination\LengthAwarePaginator;
use Src\domain\File\Actions\CreateFileAction;
use Src\domain\File\Actions\GetFileByFilterAction;
use Src\domain\File\Actions\GetFileByNameAction;
use Src\domain\File\Actions\GetFileContentByFilterAction;
use Src\domain\File\DTO\FileContentDto;
use Src\domain\File\DTO\FileDto;
use Src\domain\File\DTO\GetFileByFilterInputDto;
use Src\domain\File\DTO\GetFileContentByFilterInputDto;
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

    /**
     * @param string $name
     * @return FileDto|null
     */
    public static function getByName(string $name): ?FileDto
    {
        $action = new GetFileByNameAction(new FileRepository());
        return $action->execute($name);
    }

    public static function getFileByFilter(GetFileByFilterInputDto $inputDto): ?FileDto
    {
        $action = new GetFileByFilterAction(new FileRepository());
        return $action->execute($inputDto);
    }

    public static function getContentByFilter(GetFileContentByFilterInputDto $inputDto): FileContentDto|LengthAwarePaginator
    {
        $action = new GetFileContentByFilterAction(new FileRepository());
        return $action->execute($inputDto);

    }
}
