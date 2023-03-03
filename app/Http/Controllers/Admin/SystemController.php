<?php

declare(strict_types=1);

/**
 * Created by :phpstorm
 * User: qinghe
 * Date: 2022/9/4
 * Time: 13:43
 * File: SystemController.php
 */

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Repositories\SystemRepositoryEloquent;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Prettus\Validator\Exceptions\ValidatorException;

class SystemController extends Controller
{
    /**
     * @var SystemRepositoryEloquent
     */
    protected SystemRepositoryEloquent $system;

    /**
     * SystemController constructor.
     * @param SystemRepositoryEloquent $system
     */
    public function __construct(SystemRepositoryEloquent $system)
    {
        $this->system = $system;
    }

    /**
     * @author qinghe
     * @Time 2022/9/4 13:52
     */
    public function index()
    {
        $system = $this->system->optionList();
        return view('admin.system.index', compact('system'));
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     * @throws ValidatorException
     * @Time 2022/9/4 13:52
     * @author qinghe
     */
    public function store(Request $request)
    {
        if ($this->system->store($request->all())) {
            return redirect()->back()->with('success', '操作成功');
        }
        return redirect()->back()->withErrors('操作失败');
    }
}
