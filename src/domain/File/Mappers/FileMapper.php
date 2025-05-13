<?php

namespace Src\domain\File\Mappers;

use Src\domain\File\DTO\FileContentDto;
use Src\domain\File\DTO\FileDto;
use Src\domain\File\Entities\File;
use Src\domain\File\Entities\FileContent;

class FileMapper
{
    public static function dtoToEntity(FileDto $fileDto)
    {
        $fileContent = [];
        foreach($fileDto->content as $content){
            $fileContent[] = new FileContent(
                $content->id,
                $content->rptDt,
                $content->tckrSymb,
                $content->mktNm,
                $content->sctyCtgyNm,
                $content->isin,
                $content->crpnNm
            );
        }

        return new File(
            $fileDto->id,
            $fileDto->fileName,
            $fileDto->extension,
            new \DateTimeImmutable($fileDto->sentAt),
            $fileContent
        );
    }

    public static function entityToDto(File $file)
    {
        $fileContent = [];
        foreach($file->getContent() as $content){
            $fileContent[] = new FileContentDto(
                $content->getId(),
                $content->getRptDt(),
                $content->getTckrSymb(),
                $content->getMktNm(),
                $content->getSctyCtgyNm(),
                $content->getIsin(),
                $content->getCrpnNm()
            );
        }

        return new FileDto(
            $file->getId(),
            $file->getFileName(),
            $file->getExtension(),
            $file->getSentAt(),
            $fileContent
        );
    }

    public static function entityToDtoContent(FileContent $content)
    {
        return new FileContentDto(
            $content->getId(),
            $content->getRptDt(),
            $content->getTckrSymb(),
            $content->getMktNm(),
            $content->getSctyCtgyNm(),
            $content->getIsin(),
            $content->getCrpnNm()
        );
    }
}
