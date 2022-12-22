<?php

namespace App\Http\Controllers;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Response;
use Session;
use Illuminate\Support\Facades\Storage;

class DownloadController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    private $request;


    public function __construct(Request $request)
    {
        $this->request = $request;


    }

    public function downloadFile()
    {
        $params = $this->request->input();

        return \Storage::disk('s3')->download($params['furl'],$params['fileName'] );
    }

}
