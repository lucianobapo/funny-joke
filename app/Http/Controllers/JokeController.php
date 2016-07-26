<?php

namespace App\Http\Controllers;

use App\Joke;
use App\Services\JokeService;
use App\Services\UserService;
use ErpNET\FileManager\FileManager;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\ImageManager;

class JokeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show', 'jokeMake']]);
    }

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
            'fields' => $this->fieldsConfig(),
            'customFormAttr' => [
                'route' => ['joke.store'],
                'files'=>true,
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
        $files = $request->allFiles();

        foreach ($files as $key => $value) {
            $fields[$key] = $fileManager->saveFile($request->file($key), 'jokes');
        }
        if($jokeService->saveOrFail($fields)) return redirect(route('joke.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Joke  $joke
     * @return \Illuminate\Http\Response
     */
    public function show($joke)
    {
        if (Auth::guest()){
            $jokeMakeButton = link_to_route('auth.redirect', 'Login no Facebook para Fazer Testes', ['provider'=>'facebook'], ['class'=>'btn btn-primary']);
        } else {
            $jokeMakeButton = link_to_route('joke.jokeMake', 'Fazer Teste', [
                'id'=>Auth::user()->provider_id,
                'joke'=>$joke[$joke->getRouteKeyName()],
            ], ['class'=>'btn btn-primary ']);
        }

        return view('jokeShow', compact('joke', 'jokeMakeButton'))->with([
            'likeUrl' => url($_SERVER['REQUEST_URI']),
            'shareUrl' => url($_SERVER['REQUEST_URI']),
            'fileName' => "/file/".$joke->file,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @param  \App\Joke $joke
     * @param UserService $userService
     * @return \Illuminate\Http\Response
     */
    public function jokeMake($id, $joke, UserService $userService, $file=null)
    {
        if (Auth::guest()) {
            $jokeMakeButton = link_to_route('auth.redirect', 'Login no Facebook para Fazer Testes', ['provider'=>'facebook'], ['class'=>'btn btn-primary']);
        } else {
            $jokeMakeButton = link_to_route('joke.jokeMake', 'Refazer Teste', [
                'id'=>$id,
                'joke'=>$joke[$joke->getRouteKeyName()],
            ], ['class'=>'btn btn-primary ']);
        }

        if (is_null($file)){
            $file = $this->getRandomImage($joke, [
                'file1', 'file2', 'file3', 'file4',
                'file5', 'file6', 'file7', 'file8',
                'file9', 'file10', 'file11', 'file12',
                'file13', 'file14', 'file15',
            ]);
            $shareUrl = url($_SERVER['REQUEST_URI']).'/'.$file;
        } else $shareUrl = url($_SERVER['REQUEST_URI']);

        $params = $this->getParamsForJoke($joke, $userService->findFirst(['provider_id'=>$id])->name);
        return view('jokeShow', compact('joke', 'jokeMakeButton', 'shareUrl'))->with([
            'likeUrl' => url($_SERVER['REQUEST_URI']),
            'fileName' => "/fileJoke/$id/".urlencode(serialize($params)).'/'.$file,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Joke  $joke
     * @param JokeService $jokeService
     * @return \Illuminate\Http\Response
     */
    public function edit($joke, JokeService $jokeService)
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
            'dataModel' => $joke,
//            'dataModelInstance' => $jokeService->dataModelInstance(),
            'routePrefix' => 'joke',
            'fields' => $this->fieldsConfig(),
            'customFormAttr' => [
                'route' => ['joke.update', 'joke'=>$joke],
                'files' => true,
                'method' => 'PATCH',
            ],
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Joke $joke
     * @param FileManager $fileManager
     * @param JokeService $jokeService
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $joke, FileManager $fileManager, JokeService $jokeService)
    {
        $this->validate($request, $jokeService->getUpdateValidationRules());

        $fields = $request->all();
        if (isset($fields['title']))
            $fields['titleSlug'] = str_slug($fields['title']);
        $files = $request->allFiles();

        foreach ($files as $key => $value) {
            $fields[$key] = $fileManager->saveFile($request->file($key), 'jokes');
        }

        if($jokeService->updateOrFail($joke, $fields)) return redirect(route('joke.index'));
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

    /**
     * @return array
     */
    protected function fieldsConfig()
    {
        return [
            [
                'name' => 'title',
                'label' => app('trans', ['Title']),
                'component' => 'customText',
            ],
            [
                'name' => 'description',
                'label' => app('trans', ['Description']),
                'component' => 'customText',
            ],
            [
                'name' => 'file',
                'label' => 'Imagem Antes do Teste',
                'component' => 'customFile',
            ],
            [
                'name' => 'file1',
                'label' => 'Imagem Aleatória do Teste 1',
                'component' => 'customFile',
            ],
            [
                'name' => 'file2',
                'label' => 'Imagem Aleatória do Teste 2',
                'component' => 'customFile',
            ],
            [
                'name' => 'file3',
                'label' => 'Imagem Aleatória do Teste 3',
                'component' => 'customFile',
            ],
            [
                'name' => 'file4',
                'label' => 'Imagem Aleatória do Teste 4',
                'component' => 'customFile',
            ],
            [
                'name' => 'file5',
                'label' => 'Imagem Aleatória do Teste 5',
                'component' => 'customFile',
            ],
            [
                'name' => 'file6',
                'label' => 'Imagem Aleatória do Teste 6',
                'component' => 'customFile',
            ],
            [
                'name' => 'file7',
                'label' => 'Imagem Aleatória do Teste 7',
                'component' => 'customFile',
            ],
            [
                'name' => 'file8',
                'label' => 'Imagem Aleatória do Teste 8',
                'component' => 'customFile',
            ],
            [
                'name' => 'file9',
                'label' => 'Imagem Aleatória do Teste 9',
                'component' => 'customFile',
            ],
            [
                'name' => 'file10',
                'label' => 'Imagem Aleatória do Teste 10',
                'component' => 'customFile',
            ],
            [
                'name' => 'file11',
                'label' => 'Imagem Aleatória do Teste 11',
                'component' => 'customFile',
            ],
            [
                'name' => 'file12',
                'label' => 'Imagem Aleatória do Teste 12',
                'component' => 'customFile',
            ],
            [
                'name' => 'file13',
                'label' => 'Imagem Aleatória do Teste 13',
                'component' => 'customFile',
            ],
            [
                'name' => 'file14',
                'label' => 'Imagem Aleatória do Teste 14',
                'component' => 'customFile',
            ],
            [
                'name' => 'file15',
                'label' => 'Imagem Aleatória do Teste 15',
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
                'attributes' => ['placeholder' => 'ex.: 10'],
                'component' => 'customText',
            ],
            [
                'name' => 'paramNameColor',
                'label' => 'Cor do Nome do Perfil',
                'attributes' => ['placeholder' => 'ex.: FFFFFF'],
                'component' => 'customText',
            ],
            [
                'name' => 'paramNameX',
                'label' => 'Posição X do Nome do Perfil',
                'attributes' => ['placeholder' => 'ex.: 270'],
                'component' => 'customText',
            ],
            [
                'name' => 'paramNameY',
                'label' => 'Posição Y do Nome do Perfil',
                'attributes' => ['placeholder' => 'ex.: 230'],
                'component' => 'customText',
            ],
            [
                'name' => 'paramProfileImageSize',
                'label' => 'Tamanho da Imagem do Perfil',
                'attributes' => ['placeholder' => 'ex.: 116x116'],
                'component' => 'customText',
            ],
            [
                'name' => 'paramProfileImageX',
                'label' => 'Posição X da Imagem do Perfil',
                'attributes' => ['placeholder' => 'ex.: 10'],
                'component' => 'customText',
            ],
            [
                'name' => 'paramProfileImageY',
                'label' => 'Posição Y da Imagem do Perfil',
                'attributes' => ['placeholder' => 'ex.: 20'],
                'component' => 'customText',
            ],
        ];
    }

    private function getRandomImage($joke, $imagem)
    {
        $imagemFiltred = [];
        foreach ($imagem as $item) {
            if (!empty($joke[$item])) {
                $imagemFiltred[] = $item;
            }
        }

        if (count($imagemFiltred)>0){
            $aleatorio = rand(0,count($imagemFiltred)-1);
            return $joke[$imagemFiltred[$aleatorio]];
        } else
            return $joke->file;
    }

    private function getParamsForJoke($joke, $name)
    {
        $params = [];
        if ($joke->paramName) {
            $params['name'] = $name;
            if (!empty($joke->paramNameSize)) $params['namesize'] = $joke->paramNameSize;
            if (!empty($joke->paramNameColor)) $params['namecolor'] = $joke->paramNameColor;
            if (!empty($joke->paramNameX)) $params['namex'] = $joke->paramNameX;
            if (!empty($joke->paramNameY)) $params['namey'] = $joke->paramNameY;
        }

        if (!empty($joke->paramProfileImageSize)) $params['size'] = $joke->paramProfileImageSize;
        if (!empty($joke->paramProfileImageX)) $params['x'] = $joke->paramProfileImageX;
        if (!empty($joke->paramProfileImageY)) $params['y'] = $joke->paramProfileImageY;

        return $params;
    }
}
