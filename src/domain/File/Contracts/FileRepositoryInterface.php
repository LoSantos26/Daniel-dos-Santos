<?php

namespace Src\domain\File\Contracts;

use Illuminate\Pagination\LengthAwarePaginator;
use Src\domain\File\Entities\File;
use Src\domain\File\Entities\FileContent;

interface FileRepositoryInterface
{
    public function getAll(): LengthAwarePaginator;

    public function getFileByName(string $name): ?File;

    public function createFile(File $file): File;

    public function getFileByFilter(array $filter): ?File;

    public function getContentByFilter(array $filter): FileContent|LengthAwarePaginator|null;
}
