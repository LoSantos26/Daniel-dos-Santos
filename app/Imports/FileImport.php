<?php

namespace App\Imports;

use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Src\domain\File\Models\FileContentModel;

class FileImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     */
    public function model(array $row)
    {
        $rptDt = Carbon::parse($row['rptdt'])->format('Y-m-d');

        FileContentModel::query()->create([
            'rpt_dt' => $rptDt,
            'tckr_symb' => $row['tckrsymb'],
            'mkt_nm' => $row['mktnm'],
            'scty_ctgy_nm' => $row['sctyctgynm'],
            'isin' => $row['isin'],
            'crpn_nm' => $row['crpnnm']
        ]);
    }

    public function headingRow(): int
    {
        return 2;
    }
}
