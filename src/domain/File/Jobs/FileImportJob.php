<?php

namespace Src\domain\File\Jobs;

use App\Imports\FileImport;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Maatwebsite\Excel\Facades\Excel;

class FileImportJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 5;
    public int $timeout = 360;

    /**
     * @param string $fileName
     * @param string $filePath
     * @param int $limit
     * @param int $offset
     */
    public function __construct(
        private string $fileName,
        private string $fileExtension,
        private string $filePath,
        private int $limit,
        private int $offset
    ){}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $readerType = \Maatwebsite\Excel\Excel::CSV;

        Excel::import(new FileImport($this->fileName, $this->fileExtension, $this->limit, $this->offset), $this->filePath, null, $readerType);
    }
}
