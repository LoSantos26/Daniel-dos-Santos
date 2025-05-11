<?php

namespace App\Http\Controllers\File;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Bus;
use Src\domain\_Shared\Api\Error\Error;
use Src\domain\_Shared\Api\Response\Response;
use Src\domain\File\DTO\GetFileByFilterInputDto;
use Src\domain\File\DTO\GetFileContentByFilterInputDto;
use Src\domain\File\Facades\FileFacade;
use Src\domain\File\Jobs\FileImportJob;

class FileController extends Controller
{
    public function getByFilter(Request $request)
    {
        try {
            $fileName = $request->input('name');

            $date = null;
            if(!empty($request->input('date'))){
                $date = new \DateTimeImmutable(Carbon::createFromFormat('d/m/Y', $date)->format('Y-m-d'));
            }

            $input = new GetFileByFilterInputDto(
                $fileName,
                $date
            );

            $output = FileFacade::getFileByFilter($input);

            $response = new Response();
            $responseApi = $response->mountResponseGetFileApi($output);

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

            if(empty($tckrSymb) || empty($rptDt)){
                throw new \Exception('Os parâmetros TckrSym e RptDt precisam ser preenchidos.', 400);
            }

            $input = new GetFileContentByFilterInputDto(
                $tckrSymb,
                $rptDt
            );

            $output = FileFacade::getContentByFilter($input);

            $response = new Response();
            $responseApi = $response->mountFileContentResponseApi($output);

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

            $fileExist = FileFacade::getByName($name);

            if(!empty($fileExist)) {
                throw new \Exception('Arquivo com este nome já existe.', 400);
            }

            $jobs = [];
            $offset = 0;
            $limit = 2000;
            $total = 10000;
            while($offset < $total){
                $jobs[] = new FileImportJob($name, $path, $offset);
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
