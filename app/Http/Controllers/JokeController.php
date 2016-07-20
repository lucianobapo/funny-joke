<?php

namespace App\Http\Controllers;

use App\Joke;
use App\Services\JokeService;
use ErpNET\FileManager\FileManager;
use Illuminate\Http\Request;

use App\Http\Requests;

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
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function store(Request $request, FileManager $fileManager, JokeService $jokeService)
    {
        $this->validate($request, $jokeService->getValidationRules());

        $fields = $request->all();
        $fields['titleSlug'] = str_slug($fields['title']);
        if (($fields['file'] = $fileManager->saveFile($request->file('file'), 'jokes'))!==false) {
            $joke = new Joke($fields);
            if($joke->saveOrFail()) return redirect(route('joke.index'));
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
        return view('jokeShow', compact('joke'));
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
