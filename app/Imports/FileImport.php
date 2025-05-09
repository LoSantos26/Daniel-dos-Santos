<?php

namespace App\Imports;

use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Src\domain\File\Models\FileModel;

class FileImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     */
    public function model(array $row)
    {
        $rptDt = Carbon::parse($row['rptdt'])->format('Y-m-d');

        FileModel::query()->create([
            'rpt_dt' => $rptDt
        ]);
    }
}
