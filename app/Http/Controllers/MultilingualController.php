<?php

namespace App\Http\Controllers;

use App\Service\LangManageServiceImpl;
use Illuminate\Contracts\Validation\ValidatorAwareRule;
use Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Session;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;






class MultilingualController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    private $request;
    private $adminAuthorityService;

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->langManageService = new LangManageServiceImpl();

        $this->middleware('auth');
    }
    public function langManage()
    {
        $params = $this->request->input();
        $params['menuCode'] = "AD000100";
        $params['type'] = $params['type'] ?? 0;
        $params['page'] = $params['page'] ?? 1;
        $params['limit'] = $params['limit'] ?? 10;
        $langList = $this->langManageService->getLangList($params);
        $langTotal = $this->langManageService->getLangTotal($params);
        //$totalCount = $adminTotal->cnt;
        $params['totalCnt'] = $langTotal->cnt;
        return view('multilingual.langManage',[
            'params' => $params
            ,'langList' => $langList
        ]);
    }

    public function setLangUpdate(){
        $params = $this->request->input();

        $sqlParam['idx'] = $params['idx'];
        $sqlParam['lang_code'] = $params['lang_code'];
        $sqlParam['lang_value'] = $params['lang_value'];

        $langCheck = $this->langManageService->getLangCheck($params);
        if($langCheck->cnt == 0){
            $result =  $this->langManageService->setLangUpdate($sqlParam);
            if($result){
                return array(
                    'resultCode' => 'SUCCESS'
                    ,'resultMessage' => '언어 정보가 수정되었습니다.'
                );
            }else{
                return array(
                    'resultCode' => 'FAIL'
                    ,'resultMessage' => '처리 실패'
                );
            }
        }else{
            return array(
                'resultCode' => 'FAIL'
            ,'resultMessage' => '언어 항목이 변경전과 동일합니다. 변경후 확인버튼을 눌러주세요.'
            );
        }

    }


    public function menuManage($siteCode)
    {

        $params = $this->request->input();
        $params['siteCode'] = $siteCode;
        $params['menuCode'] = "AD000200";


        $beatSomeoneMenuList = $this->langManageService->getBeatSomeoneMenuList($params);
        $bybeatMenuList = $this->langManageService->getByBeatMenuList($params);


        return view('multilingual.menuManage',[
            'params' => $params
            ,'beatSomeoneMenuList' => $beatSomeoneMenuList
            ,'bybeatMenuList' => $bybeatMenuList
        ]);
    }

    public function menuUploadExcel(){
        $params = $this->request->input();
        $params['excelCodeUp'] = $params['excelCodeUp'] ?? "01";

        $folderName = '/excel/'.date("Y/m/d").'/';
        $files = $this->request->file('excelFile');

        $sqlData['file_name'] = $files->getClientOriginalName();
        $sqlData['ext'] = $files->getClientOriginalExtension();
        $sqlData['hash_name'] = $files->hashName();
        $sqlData['file_url'] =  $folderName;
        $files->storeAs($folderName, $files->getClientOriginalName(), 'public');
        $excelFile =  storage_path('app/public'.$sqlData['file_url'].$sqlData['file_name']);

        $reader = IOFactory::createReader("Xlsx");
        $spreadsheet = $reader->load($excelFile);
        $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

        $this->langManageService->clearMenu($params);

        $i=0;
        $sqlParams['excelCodeUp']=$params['excelCodeUp'];
        foreach ($sheetData as $jbexplode) {
            if($i > 0){
                $sqlParams['menu_code'] =  $jbexplode['A'];
                $sqlParams['lang_kr']   =  $jbexplode['B'];
                $sqlParams['lang_en']   =  $jbexplode['C'];
                $sqlParams['lang_ch']   =  $jbexplode['D'];
                $sqlParams['lang_jp']   =  $jbexplode['E'];
                $this->langManageService->setMenuInsert($sqlParams);
            }
            $i++;
        }

        return redirect('/multilingual/menuManage/'.$params['excelCodeUp']);


    }
    public function menuDownloadExcel(){

        $params = $this->request->input();
        $params['siteCode'] = $params['siteCode'] ?? '01';

        if($params['siteCode'] =="01"){
            $menuList = $this->langManageService->getByBeatMenuList($params);
        }elseif($params['siteCode'] =="02"){
            $menuList = $this->langManageService->getBeatSomeoneMenuList($params);
        }

        return view('multilingual.menuExcel',[
            'params' => $params
            ,'menuList' => $menuList
        ]);

    }

    public function setMenuManage(){
        $params = $this->request->input();
        $sqlParam = array();
        $result=0;

        $arDataCount = count($params['lang_kr']);

        for($i=0;$i<$arDataCount;$i++){
            $sqlParam = null;
            $sqlParam['menu_index'] = $params['menu_index'][$i];
            $sqlParam['lang_kr'] = $params['lang_kr'][$i];
            $sqlParam['lang_en'] = $params['lang_en'][$i];
            $sqlParam['lang_ch'] = $params['lang_ch'][$i];
            $sqlParam['lang_jp'] = $params['lang_jp'][$i];

            if($params['siteCode']=="01"){
                $result =  $this->langManageService->setByBeatMenuList($sqlParam);
            }elseif($params['siteCode']=="02"){
                $result =  $this->langManageService->setBeatSomeoneMenuList($sqlParam);
            }
        }
        if($result){
            return redirect('/multilingual/menuManage/'.$params['siteCode'])->with('alert', '수정되었습니다.');
        }else{
            return redirect()->back()->with('alert', '등록/수정에 실패하였습니다. \n관리자에게 문의 바랍니다.');
        }

    }

}
