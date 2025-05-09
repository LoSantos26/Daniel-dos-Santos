<?php

namespace App\Http\Controllers\File;

use App\Http\Controllers\Controller;
use App\Imports\FileImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class FileController extends Controller
{
    public function upload(Request $request)
    {
        try{
            $file = $request->file('file');
            Excel::import(new FileImport($file->getClientOriginalName()), $file->path(), null, \Maatwebsite\Excel\Excel::XLSX);

            return response()->json([
                'success' => true,
                'message' => 'foi'
            ]);

        }catch (\Throwable $e){
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }
}
