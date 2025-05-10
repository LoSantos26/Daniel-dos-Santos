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

            $offset = 0;
            $limit = 2000;
            $total = 10000;
            while($offset < $total){
                Excel::import(new FileImport($file->getClientOriginalName(), $offset), $file->path(), null, \Maatwebsite\Excel\Excel::CSV);
                $offset += $limit;
            }

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
