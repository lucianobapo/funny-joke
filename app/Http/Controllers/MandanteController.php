<?php

namespace App\Http\Controllers;

use App\Services\MandanteService;
use Illuminate\Http\Request;

use App\Http\Requests;

class MandanteController extends Controller
{
    /**
     * Create a new controller instance.
     *
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @param MandanteService $mandanteService
     * @return \Illuminate\Http\Response
     */
    public function index(MandanteService $mandanteService)
    {
        $this->authorize($mandanteService->dataModelInstance());

        return view('dataIndex')->with([
            'data' => $mandanteService->getAll(),
            'dataModelInstance' => $mandanteService->dataModelInstance(),
            'routePrefix' => 'mandante',
            'fields' => $mandanteService->getFillableFields(),
            'customFormAttr' => [
                'route' => ['mandante.store'],
                'files'=>false,
            ],
        ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort(403);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void|\Illuminate\Http\Response
     * @throws \Throwable
     */
    public function store(Request $request, MandanteService $mandanteService)
    {
        $this->authorize($mandanteService->dataModelInstance());

        $this->validate($request, $mandanteService->getValidationRules());

        $fields = $request->all();

        if($mandanteService->saveOrFail($fields))
            return redirect(route('mandante.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        abort(403);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \Illuminate\Database\Eloquent\Model $selectedModel
     * @param MandanteService $mandanteService
     * @return \Illuminate\Http\Response
     */
    public function edit($selectedModel, MandanteService $mandanteService)
    {
        $this->authorize($mandanteService->dataModelInstance());

        return view('dataIndex')->with([
            'data' => $mandanteService->getAll(),
            'dataModel' => $selectedModel,
            'routePrefix' => 'mandante',
            'fields' => $mandanteService->getFillableFields(),
            'customFormAttr' => [
                'route' => ['mandante.update', 'mandante'=>$selectedModel],
                'files'=>false,
                'method' => 'PATCH',
            ],
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Database\Eloquent\Model $selectedModel
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $selectedModel, MandanteService $mandanteService)
    {
        $this->authorize($mandanteService->dataModelInstance());

        $this->validate($request, $mandanteService->getUpdateValidationRules());

        if($mandanteService->updateOrFail($selectedModel, $request->all()))
            return redirect(route('mandante.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @param  \Illuminate\Database\Eloquent\Model $selectedModel
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Request $request, $selectedModel)
    {
        $this->authorize($selectedModel);

        if ($request->method()=='DELETE' && $selectedModel->delete()===true)
            return redirect(route('mandante.index'));
        else
            throw new \Exception('Erro no Delete');
    }
}
