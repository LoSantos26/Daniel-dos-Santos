<?php

namespace App\Http\Controllers\File;

use App\Http\Controllers\Controller;
use App\Imports\FileImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Bus;
use Maatwebsite\Excel\Facades\Excel;
use Src\domain\_Shared\Api\Error\Error;
use Src\domain\_Shared\Api\Response\Response;
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

            $response = new Response();
            $reponseApi = $response->mountResponseApi(200,'Importação iniciada com sucesso');

            return response()->json($reponseApi);

        }catch (\Throwable $e){
            $error = new Error();
            $errorApi = $error->mountErrorApi($e->getCode(), $e->getMessage());

            return response()->json($errorApi, 500);
        }
    }
}
