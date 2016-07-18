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
        return view('dataIndex')->with([
            'data' => $jokeService->getAll(),
            'dataModelInstance' => $jokeService->dataModelInstance(),
            'routePrefix' => 'mandante',
            'fields' => $jokeService->getFillableFields(),
            'customFormAttr' => ['files'=>true],
        ]);

//        return view('joke')->with([
//            'jokes' => $jokeService->getAll(),
//        ]);
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
     * @param  \Illuminate\Http\Request $request
     * @param FileManager $fileManager
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function store(Request $request, FileManager $fileManager)
    {
        $this->validate($request, [
            'title' => 'required|unique:jokes|max:255',
            'file' => 'required',
        ]);

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
