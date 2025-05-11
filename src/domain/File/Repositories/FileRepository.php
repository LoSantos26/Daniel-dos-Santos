<?php

namespace Src\domain\File\Repositories;

use Illuminate\Support\Carbon;
use Src\domain\File\Contracts\FileRepositoryInterface;
use Src\domain\File\Entities\File;
use Src\domain\File\Entities\FileContent;
use Src\domain\File\Models\FileContentModel;
use Src\domain\File\Models\FilesModel;

class FileRepository implements FileRepositoryInterface
{
    public function createFile(File $file): File
    {
        $fileModel = FilesModel::query()
            ->updateOrCreate([
                'file_name' => $file->getFileName()
            ],
            [
                'extension' => $file->getExtension(),
                'sent_at' => $file->getSentAt()->format('Y-m-d')
            ]);

        foreach($file->getContent() as $content){
            FileContentModel::query()
                ->create([
                    'file_id' => $fileModel->id,
                    'rpt_dt' => $content->getRptDt()->format('Y-m-d'),
                    'tckr_symb' => $content->getTckrSymb(),
                    'mkt_nm' => $content->getMktNm(),
                    'scty_ctgy_nm' => $content->getSctyCtgyNm(),
                    'isin' => $content->getIsin(),
                    'crpn_nm' => $content->getCrpnNm()
            ]);
        }

        return $this->mapFile($fileModel);
    }

    public function getFileByFilter(array $filter): ?File
    {
        $query = FilesModel::query();

        if(!empty($filter['file_name'])){
            $query->where('file_name', '=', $filter['file_name']);
        }

        if(!empty($filter['sent_at'])){
            $sentAt = Carbon::parse($filter['sent_at'])->format('Y-m-d');
            $query->where('sent_at', '=', $sentAt);
        }

        $fileModel = $query->first();

        if(empty($fileModel)){
            return null;
        }

        return $this->mapFile($fileModel);
    }

    public function getFileByName(string $name): ?File
    {
        $fileModel = FilesModel::query()
            ->where('file_name', '=', $name)
            ->first();

        if(empty($fileModel)){
            return null;
        }

        return $this->mapFile($fileModel);
    }

    public function getContentByFilter(): ?FileContent
    {
        // TODO: Implement getContentByFilter() method.
    }

    private function mapFile(object $fileData): File
    {
        $contentData = [];

        foreach($fileData->content as $content){
            $contentData[] = new FileContent(
                $content->id,
                new \DateTimeImmutable($content->rpt_dt),
                $content->tckr_symb,
                $content->mkt_nm,
                $content->scty_ctgy_nm,
                $content->isin,
                $content->crpn_nm
            );
        }

        return new File(
            $fileData->id,
            $fileData->file_name,
            $fileData->extension,
            new \DateTimeImmutable($fileData->sent_at),
            $contentData
        );
    }
}
