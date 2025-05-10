<?php

namespace App\Http\Controllers\File;

use App\Http\Controllers\Controller;
use App\Imports\FileImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Bus;
use Maatwebsite\Excel\Facades\Excel;
use Src\domain\File\Jobs\FileImportJob;

class FileController extends Controller
{
    public function upload(Request $request)
    {
        try{
            $file = $request->file('file');
            $path = $request->file('file')->store('imports');

            $jobs = [];
            $offset = 0;
            $limit = 2000;
            $total = 10000;
            while($offset < $total){
                $jobs[] = new FileImportJob($file->getClientOriginalName(), $path, $offset);
                $offset += $limit;
            }
            Bus::chain($jobs)->dispatch();

            return response()->json([
                'success' => true,
                'message' => 'Importação iniciada com sucesso'
            ]);

        }catch (\Throwable $e){
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }
}
