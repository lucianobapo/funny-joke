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
     * @return \Illuminate\Http\Response
     */
    public function index(MandanteService $mandanteService)
    {
        return view('dataIndex')->with([
            'data' => $mandanteService->getAll(),
            'dataModelInstance' => $mandanteService->dataModelInstance(),
            'routePrefix' => 'mandante',
            'fields' => $mandanteService->getFillableFields(),
            'customFormAttr' => ['files'=>false],
        ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
