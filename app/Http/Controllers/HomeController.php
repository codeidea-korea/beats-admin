<?php

namespace App\Http\Controllers;

use App\Service\DashBoardServiceImpl;
use Illuminate\Contracts\View\Factory;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Session;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    private $request;
    private $dashBoardService;

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->dashBoardService = new DashBoardServiceImpl();

        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $params = $this->request->input();
        $params['menuCode'] = "AD010000";

        return view('home',[
            'params' =>$params
        ]);

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function adminHome()
    {
        return view('adminHome');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function managerHome()
    {
        return view('managerHome');
    }

    public function test()
    {
        $params = $this->request->input();
        $params['menuCode'] = "AD030100";
        return view('test',[
            'params' => $params
        ]);
    }
}
