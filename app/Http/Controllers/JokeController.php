<?php

namespace App\Http\Controllers;

use App\Joke;
use App\Services\JokeService;
use ErpNET\FileManager\FileManager;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\ImageManager;

class JokeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param JokeService $jokeService
     * @return \Illuminate\Http\Response
     */
    public function index(JokeService $jokeService)
    {
        $fields = $jokeService->getFillableFields();
        foreach($fields as $key => $field){
            if ($field=='file'){
                $fields[$key]=[
                    'name' => 'file',
                    'component' => 'customFile',
                ];
            };
        }
        return view('dataIndex')->with([
            'data' => $jokeService->getAll(),
            'dataModelInstance' => $jokeService->dataModelInstance(),
            'routePrefix' => 'joke',
            'fields' => [
                [
                    'name' => 'title',
                    'label' => app('trans',['Title']),
                    'component' => 'customText',
                ],
                [
                    'name' => 'description',
                    'label' => app('trans',['Description']),
                    'component' => 'customText',
                ],
                [
                    'name' => 'file',
                    'label' => app('trans',['File']),
                    'component' => 'customFile',
                ],
                [
                    'name' => 'paramName',
                    'label' => 'Mostrar Nome do Perfil',
                    'value' => '1',
                    'component' => 'customCheckbox',
                ],
                [
                    'name' => 'paramNameSize',
                    'label' => 'Tamanho do Nome do Perfil',
                    'attributes' => ['placeholder'=>'ex.: 10'],
                    'component' => 'customText',
                ],
                [
                    'name' => 'paramNameColor',
                    'label' => 'Cor do Nome do Perfil',
                    'attributes' => ['placeholder'=>'ex.: FFFFFF'],
                    'component' => 'customText',
                ],
                [
                    'name' => 'paramNameX',
                    'label' => 'Posição X do Nome do Perfil',
                    'attributes' => ['placeholder'=>'ex.: 270'],
                    'component' => 'customText',
                ],
                [
                    'name' => 'paramNameY',
                    'label' => 'Posição Y do Nome do Perfil',
                    'attributes' => ['placeholder'=>'ex.: 230'],
                    'component' => 'customText',
                ],
                [
                    'name' => 'paramProfileImageSize',
                    'label' => 'Tamanho da Imagem do Perfil',
                    'attributes' => ['placeholder'=>'ex.: 116x116'],
                    'component' => 'customText',
                ],
                [
                    'name' => 'paramProfileImageX',
                    'label' => 'Posição X da Imagem do Perfil',
                    'attributes' => ['placeholder'=>'ex.: 10'],
                    'component' => 'customText',
                ],
                [
                    'name' => 'paramProfileImageY',
                    'label' => 'Posição Y da Imagem do Perfil',
                    'attributes' => ['placeholder'=>'ex.: 20'],
                    'component' => 'customText',
                ],
            ],
            'customFormAttr' => ['files'=>true],
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
     * @param  \Illuminate\Http\Request $request
     * @param FileManager $fileManager
     * @param JokeService $jokeService
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function store(Request $request, FileManager $fileManager, JokeService $jokeService)
    {
        $this->validate($request, $jokeService->getValidationRules());

        $fields = $request->all();
        $fields['titleSlug'] = str_slug($fields['title']);

        if (($fields['file'] = $fileManager->saveFile($request->file('file'), 'jokes'))!==false) {
            if($jokeService->saveOrFail($fields)) return redirect(route('joke.index'));
        } else throw new \Exception('Erro no Upload');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Joke  $joke
     * @return \Illuminate\Http\Response
     */
    public function show($joke)
    {
        $file = $joke->file;
        return view('jokeShow', compact('joke'))->with([
            'fileName' => "/file/$file",
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Joke $joke
     * @return \Illuminate\Http\Response
     */
    public function jokeMake($id, $joke)
    {
//        $id = Auth::user()->provider_id;
        $file = $joke->file;
        $params = [];
        if ($joke->paramName) {
            $params['name'] = Auth::user()->name;
            if (!empty($joke->paramNameSize)) $params['namesize'] = $joke->paramNameSize;
            if (!empty($joke->paramNameColor)) $params['namecolor'] = $joke->paramNameColor;
            if (!empty($joke->paramNameX)) $params['namex'] = $joke->paramNameX;
            if (!empty($joke->paramNameY)) $params['namey'] = $joke->paramNameY;
        }

        if (!empty($joke->paramProfileImageSize)) $params['size'] = $joke->paramProfileImageSize;
        if (!empty($joke->paramProfileImageX)) $params['x'] = $joke->paramProfileImageX;
        if (!empty($joke->paramProfileImageY)) $params['y'] = $joke->paramProfileImageY;

        return view('jokeShow', compact('joke'))->with([
            'fileName' => "/fileJoke/$id/".urlencode(serialize($params)).'/'.$file,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        abort(403);
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
        abort(403);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Joke $joke
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Request $request, $joke)
    {
        if ($request->method()=='DELETE' && $joke->delete()===true)
            return redirect(route('joke.index'));
        else
            throw new \Exception('Erro no Delete');
    }
}
