<?php

namespace Src\domain\_Shared\Api\Response;

use Illuminate\Pagination\LengthAwarePaginator;
use Src\domain\File\DTO\FileContentDto;
use Src\domain\File\DTO\FileDto;

class Response
{
    public function mountGetFileResponseApi(?FileDto $fileDto): array
    {
        if(!empty($fileDto)){
            $content = [];

            foreach($fileDto->content as $item) {
                $content[] = [
                    'RptDt' => $item->rptDt,
                    'TckrSymb' => $item->tckrSymb,
                    'MktNm' => $item->mktNm,
                    'SctyCtgyNm' => $item->sctyCtgyNm,
                    'ISIN' => $item->isin,
                    'CrpnNm' => $item->crpnNm,
                ];
            }

            return [
                'result' => [
                    'success' => true,
                    'file_name' => $fileDto->fileName,
                    'sent_at' => $fileDto->sentAt->format('d/m/Y'),
                    'extension' => $fileDto->extension,
                    'content' => $content
                ]
            ];
        }

        return [
            'result' => null
        ];
    }

    public function mountFileContentResponseApi(FileContentDto $fileContentDto)
    {
        return [
            'result' => [
                'success' => true,
                'RptDt' => $fileContentDto->rptDt,
                'TckrSymb' => $fileContentDto->tckrSymb,
                'MktNm' => $fileContentDto->mktNm,
                'SctyCtgyNm' => $fileContentDto->sctyCtgyNm,
                'ISIN' => $fileContentDto->isin,
                'CrpnNm' => $fileContentDto->crpnNm,
            ]
        ];
    }

    public function mountGetFilesResponseApi(LengthAwarePaginator $files)
    {
        return [
            'success' => true,
            'result' => $files
        ];
    }

    public function mountResponseApi(int $code, string $message)
    {
        return [
            'success' => true,
            'message' => $message,
        ];
    }
}
