<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


class MailingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function import(Request $request)
    {
        try {
            $file_path  = self::UploadFile($request->file('mailing'));
            $valid_cpf = $request->valid_cpf ?? '1';
            dispatch(function() use ($file_path, $valid_cpf){
                try {
                    \Maatwebsite\Excel\Facades\Excel::import(new \App\Imports\MailingImport([
                        'valid_cpf' => $valid_cpf
                    ]), storage_path($file_path));
                    unlink(storage_path($file_path));
                } catch (\Exception $exception) {
                    \Log::error('MailingController.import',[
                        'file_path' => storage_path($file_path),
                        'message' => $exception->getMessage()
                    ]);
                }                
            })->onQueue('mailing');
        } catch (\Exception $exception) {
            return [
                'status' => false,
                'error' => $exception->getMessage()
            ];
        }
        return [
            'status' => true,
        ];
    }
    private function UploadFile($file){
        $uploaddir = "mailing";
		$uploadfile1 = "{$uploaddir}/".time().".{$file->extension()}";
		if (!file_exists($uploaddir)) {
		    \File::makeDirectory($uploaddir, 0777, true, true);
		}
		$file->storeAs('./', $uploadfile1, 'local');		
        return "app/{$uploadfile1}";
    }
}
