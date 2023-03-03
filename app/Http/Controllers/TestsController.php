<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Http\Response;
use Illuminate\View\View;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\TestCreateRequest;
use App\Http\Requests\TestUpdateRequest;
use App\Repositories\TestRepositories;
use App\Validators\TestValidator;

/**
 * Class TestsController.
 *
 * @package namespace App\Http\Controllers;
 */
class TestsController extends Controller
{
    /**
     * @var TestRepositories
     */
    protected $repository;

    /**
     * @var TestValidator
     */
    protected TestValidator $validator;

    /**
     * TestsController constructor.
     *
     * @param TestRepositories $repository
     * @param TestValidator $validator
     */
    public function __construct(TestRepositories $repository, TestValidator $validator)
    {
        $this->repository = $repository;
        $this->validator  = $validator;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|JsonResponse|View
     */
    public function index()
    {
        $this->repository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
        $tests = $this->repository->all();

        if (request()->wantsJson()) {
            return response()->json([
                'data' => $tests,
            ]);
        }

        return view('tests.index', compact('tests'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  TestCreateRequest $request
     *
     * @return JsonResponse
     *
     */
    public function store(TestCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $test = $this->repository->create($request->all());

            $response = [
                'message' => 'Test created.',
                'data'    => $test->toArray(),
            ];

            if ($request->wantsJson()) {
                return response()->json($response);
            }

            return redirect()->back()->with('message', $response['message']);
        } catch (ValidatorException $e) {
            if ($request->wantsJson()) {
                return response()->json([
                    'error'   => true,
                    'message' => $e->getMessageBag()
                ]);
            }

            return redirect()->back()->withErrors($e->getMessageBag())->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return Application|Factory|JsonResponse|View
     */
    public function show(int $id)
    {
        $test = $this->repository->find($id);

        if (request()->wantsJson()) {
            return response()->json([
                'data' => $test,
            ]);
        }

        return view('tests.show', compact('test'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return Application|Factory|View
     */
    public function edit(int $id)
    {
        $test = $this->repository->find($id);

        return view('tests.edit', compact('test'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  TestUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(TestUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $test = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'Test updated.',
                'data'    => $test->toArray(),
            ];

            if ($request->wantsJson()) {

                return response()->json($response);
            }

            return redirect()->back()->with('message', $response['message']);
        } catch (ValidatorException $e) {

            if ($request->wantsJson()) {

                return response()->json([
                    'error'   => true,
                    'message' => $e->getMessageBag()
                ]);
            }

            return redirect()->back()->withErrors($e->getMessageBag())->withInput();
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $deleted = $this->repository->delete($id);

        if (request()->wantsJson()) {

            return response()->json([
                'message' => 'Test deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'Test deleted.');
    }
}
