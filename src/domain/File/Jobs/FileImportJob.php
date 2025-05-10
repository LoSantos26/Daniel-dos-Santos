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

    /**
     * Create a new job instance.
     */
    public function __construct(private string $fileName, private string $filePath, private int $offset)
    {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Excel::import(new FileImport($this->fileName, $this->offset), $this->filePath, null, \Maatwebsite\Excel\Excel::CSV);
    }
}
