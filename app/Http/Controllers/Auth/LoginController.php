<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Service\LangManageServiceImpl;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Service\AdminAuthorityServiceImpl;
use Response;
use Illuminate\Http\Request;
use Session;


class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    private $request;
    private $adminAuthorityService;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->adminAuthorityService = new AdminAuthorityServiceImpl();

        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request)
    {
        $input = $request->all();

        $this->validate($request, [
            'id' => 'required',
            'password' => 'required',
        ]);

        if(auth()->attempt(array('id' => $input['id'], 'password' => $input['password'])))
        {
            $aParams['group_code']=auth()->user()->group_code;
            $authData = $this->adminAuthorityService->getAdmGroupAuthList($aParams);
            session(['ADMINMENULISTAUTH'=>$authData->auth_arr]);
            // 메뉴 session에 저장
            $menuList = $this->adminAuthorityService->getAdmMenuList();
            session(['ADMINMENULIST'=>$menuList]);

            //if (auth()->user()->type == 'admin') {
            //    return redirect()->route('admin.home');
            //}else if (auth()->user()->type == 'manager') {
            //    return redirect()->route('manager.home');
            //}else{
            //    return redirect()->route('home');
            //}

            if (auth()->user()->type == 'admin') {
                return redirect()->route('home');
            }else{
                return redirect()->route('home');
            }

        }else{
            return redirect()->route('login')
                ->with('error','Email-Address And Password Are Wrong.');
        }

    }

}
