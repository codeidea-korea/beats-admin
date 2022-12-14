<?php

namespace App\Http\Controllers;

use App\Service\SoundSourceServiceImpl;
use Response;
use Illuminate\Http\Request;
use Session;
use Illuminate\Support\Facades\File;
use Illuminate\Http\UploadedFile;
use App\Http\Requests\StoreFileRequest;
use Symfony\Component\HttpKernel\Exception\HttpException;

class SoundSourceController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    private $request;
    private $soundSorceService;

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->soundSorceService = new SoundSourceServiceImpl();

        $this->middleware('auth');
    }

    public function getSoundSourceList()
    {
        $params = $this->request->input();
        $params['menuCode'] = "AD060600";

        $params['progress_rate'] = $params['progress_rate'] ?? '';
        $params['common_composition'] = $params['common_composition'] ?? '';
        $params['sales_status'] = $params['sales_status'] ?? '';
        $params['open_status'] = $params['open_status'] ?? '';
        $params['search_text'] = $params['search_text'] ?? '';
        $params['page'] = $params['page'] ?? '1';
        $params['limit'] = $params['limit'] ?? '10';

        $resultData = $this->soundSorceService->getSoundSourceListPaging($params);

        $totalCount = $this->soundSorceService->getSoundSourceTotal($params);
        $totalCount = $totalCount[0]->cnt;
        $params['totalCnt'] = $totalCount;

        return view('contents.soundSource.soundSourceList',[
            'params' => $params
            ,'searchData' => $params
            ,'musicList' => $resultData
           ,'totalCount' => $totalCount

        ]);
    }

}
