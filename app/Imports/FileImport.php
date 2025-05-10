<?php

namespace App\Imports;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Src\domain\File\DTO\FileContentDto;
use Src\domain\File\DTO\FileDto;
use Src\domain\File\Facades\FileFacade;

class FileImport implements ToCollection, WithHeadingRow, WithChunkReading, ShouldQueue
{
    use Queueable;

    public function __construct(private string $fileName, private int $offset)
    {}

    public function collection(Collection $collection)
    {
        $contentInputs = [];
        foreach($collection as $row){
            //$rptDt = Carbon::parse($row['rptdt'])->format('Y-m-d');

            $contentInputs[] = new FileContentDto(
                null,
                new \DateTimeImmutable(),
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
            'xlsx',
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
        return 2000;
    }
}
