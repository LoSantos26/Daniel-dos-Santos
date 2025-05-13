<?php

namespace Src\domain\File\Repositories;

use Illuminate\Pagination\LengthAwarePaginator;
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
                    'rpt_dt' => $content->getRptDt(),
                    'tckr_symb' => $content->getTckrSymb(),
                    'mkt_nm' => $content->getMktNm(),
                    'scty_ctgy_nm' => $content->getSctyCtgyNm(),
                    'isin' => $content->getIsin(),
                    'crpn_nm' => $content->getCrpnNm()
            ]);
        }

        return $this->mapFile($fileModel);
    }

    public function getAll(): LengthAwarePaginator
    {
        $fileModel = FilesModel::query()->select('files.*');

        $files = $fileModel->paginate(10);
        $files->getCollection()->transform(function ($file) {
            return $this->mapFile($file);
        });

        return $files;
    }

    public function getFileByFilter(array $filter): ?File
    {
        $query = FilesModel::query();

        if(!empty($filter['file_name'])){
            $query->where('file_name', '=', $filter['file_name']);
        }

        if(!empty($filter['sent_at'])){
            $query->where('sent_at', '=', $filter['sent_at']);
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

    public function getContentByFilter(array $filter): FileContent|LengthAwarePaginator|null
    {
        $fileContentModel = FileContentModel::query()
            ->where('tckr_symb', '=', $filter['tckr_symb'])
            ->where('rpt_dt', '=', $filter['rpt_dt'])
            ->first();

        if(empty($fileContentModel)){
            return $this->getAll();
        }

        return $this->mapFileContent($fileContentModel->first());
    }

    private function mapFile(object $fileData): File
    {
        $contentData = [];

        foreach($fileData->content as $content){
            $contentData[] = new FileContent(
                $content->id,
                $content->rpt_dt,
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

    private function mapFileContent(object $contentData): FileContent
    {
        return new FileContent(
            $contentData->id,
            $contentData->rpt_dt,
            $contentData->tckr_symb,
            $contentData->mkt_nm,
            $contentData->scty_ctgy_nm,
            $contentData->isin,
            $contentData->crpn_nm
        );

    }
}
