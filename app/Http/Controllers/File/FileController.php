<?php

namespace App\Http\Controllers\File;

use App\Http\Controllers\Controller;
use App\Imports\FileImport;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Bus;
use Maatwebsite\Excel\Facades\Excel;
use Src\domain\_Shared\Api\Error\Error;
use Src\domain\_Shared\Api\Response\Response;
use Src\domain\File\DTO\GetFileByFilterInputDto;
use Src\domain\File\DTO\GetFileContentByFilterInputDto;
use Src\domain\File\Facades\FileFacade;
use Src\domain\File\Helpers\FileHelper;
use Src\domain\File\Jobs\FileImportJob;

class FileController extends Controller
{
    public function getByFilter(Request $request)
    {
        try {
            $fileName = $request->input('name');
            $date = $request->input('date');

            $input = new GetFileByFilterInputDto(
                $fileName,
                $date
            );

            $output = FileFacade::getFileByFilter($input);

            $response = new Response();
            $responseApi = $response->mountGetFileResponseApi($output);

            return response()->json($responseApi);

        }catch (\Throwable $e) {
            $error = new Error();
        $errorApi = $error->mountErrorApi($e->getCode(), $e->getMessage());

            return response()->json($errorApi, 500);
        }
    }

    public function getContentByFilter(Request $request)
    {
        try{
            $tckrSymb = $request->input('TckrSymb');
            $rptDt = $request->input('RptDt');

            if((!empty($tckrSymb) && empty($rptDt)) || (empty($tckrSymb) && !empty($rptDt))){
                throw new \Exception('Os parâmetros TckrSym e RptDt precisam ser preenchidos.', 400);
            }

            $input = new GetFileContentByFilterInputDto(
                $tckrSymb,
                $rptDt
            );

            $output = FileFacade::getContentByFilter($input);

            $response = new Response();
            if($output instanceof LengthAwarePaginator){
                $responseApi = $response->mountGetFilesResponseApi($output);
            }else{
                $responseApi = $response->mountFileContentResponseApi($output);
            }

            return response()->json($responseApi);

        }catch (\Throwable $e) {
            $error = new Error();
            $errorApi = $error->mountErrorApi($e->getCode(), $e->getMessage());

            return response()->json($errorApi, 500);
        }
    }

    public function upload(Request $request)
    {
        try{
            $file = $request->file('file');
            $path = $request->file('file')->store('imports');
            $name = $file->getClientOriginalName();

            $fileInfo = explode('.', $name);
            $fileName = $fileInfo[0];
            $extension = $fileInfo[1];

            $fileExist = FileFacade::getByName($fileName);

            if(!empty($fileExist)) {
                throw new \Exception('Arquivo com este nome já existe.', 400);
            }

            FileHelper::validateExtension($extension);

            //Pegando o total de registros na planilha
            $handle = fopen(storage_path('app/' . $path), 'r');
            $total = 0;

            while (($row = fgetcsv($handle, 0, ',')) !== false) {
                $total++;
            }
            fclose($handle);
            $totalRows = $total - 2;

            $jobs = [];
            $offset = 0;
            $limit = 2000;
            $total = $totalRows;
            while($offset < $total){
                $jobs[] = new FileImportJob($name, $extension, $path, $limit, $offset);
                $offset += $limit;
            }
            Bus::chain($jobs)->dispatch();

            $response = new Response();
            $responseApi = $response->mountResponseApi(200,'Importação iniciada com sucesso');

            return response()->json($responseApi);

        }catch (\Throwable $e){
            $error = new Error();
            $errorApi = $error->mountErrorApi($e->getCode(), $e->getMessage());

            return response()->json($errorApi, 500);
        }
    }
}
