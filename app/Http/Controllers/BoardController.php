<?php

namespace App\Http\Controllers;

use App\Service\BoardServiceImpl;
use Illuminate\Contracts\View\Factory;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Session;

class BoardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    private $request;
    private $adminBoardService;

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->adminBoardService = new BoardServiceImpl();

        $this->middleware('auth');
    }
    public function getBoardList()
    {
        $params = $this->request->input();
        $boardData = $this->adminBoardService->getBoardList($params);

        return view('admin.noticeBoard.list',[
            'boardData' => $boardData
        ]);
    }
    public function getBoardView($bidx)
    {
        $params = $this->request->input();
        $boardData = $this->adminBoardService->getBoardView($params, $bidx);

        return view('admin.noticeBoard.view',[
            'boardData' => $boardData
        ]);
    }

    public function getBoardWrite()
    {
        $params = $this->request->input();

        return view('admin.noticeBoard.write');
    }

    public function BoardAdd()
    {
        $params = $this->request->input();
        $boardData = $this->adminBoardService->BoardAdd($params);

        return redirect('/admin/board/view/'.$boardData);
    }

    public function BoardUpdate()
    {
        $params = $this->request->input();
        $boardData = $this->adminBoardService->BoardUpdate($params);

        return redirect('/admin/board/list');
    }

    public function BoardDelete()
    {
        $params = $this->request->input();
        $boardData = $this->adminBoardService->BoardDelete($params);

        return redirect('/admin/board/list');
    }
}
