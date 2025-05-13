<?php

namespace App\Imports;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Src\domain\File\DTO\FileContentDto;
use Src\domain\File\DTO\FileDto;
use Src\domain\File\Facades\FileFacade;

class FileImport implements ToCollection, WithHeadingRow, WithChunkReading, ShouldQueue, WithCustomCsvSettings, WithBatchInserts
{
    use Queueable;

    public int $tries = 5;
    public int $timeout = 360;

    /**
     * @param string $fileName
     * @param string $extension
     * @param int $limit
     */
    public function __construct(
        private string $fileName,
        private string $extension,
        private int $limit,
        private int $offset
    ){}

    public function collection(Collection $collection)
    {
        $contentInputs = [];
        foreach($collection as $row){
            //$rptDt = Carbon::createFromFormat('Y-m-d', $row['rptdt'])->format('Y-m-d');

            $contentInputs[] = new FileContentDto(
                null,
                $row['rptdt'],
                $row['tckrsymb'],
                $row['mktnm'],
                $row['sctyctgynm'],
                $row['isin'],
                $row['crpnnm']
            );
        }

        $input = new FileDto(
            null,
            $this->fileName,
            $this->extension,
            new \DateTimeImmutable(),
            $contentInputs
        );

        FileFacade::create($input);
    }

    public function headingRow(): int
    {
        return 2;
    }

    public function startRow(): int
    {
        return $this->offset;
    }

    public function chunkSize(): int
    {
        return $this->limit;
    }

    public function batchSize(): int
    {
        return $this->limit;
    }

    public function getCsvSettings(): array
    {
        return [
            'delimiter' => ";"
        ];
    }
}
