<?php

namespace App\Http\Controllers;

use App\comic;
use Illuminate\Http\Request;

class ComicController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // voglio tutta la stampa dei fumetti
        $comics = comic::all();
        return view('comic.index', compact('comics'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('comics.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        //definisco delle validazioni utilizzando il metodo validate di request
        $request->validate(

            //array associativo con validazioni
            [

                "title" =>'required|min:5',

                "description" => 'required|min:10',

                "thumb" => 'required|url',

                "price" => 'required|numeric| min:1',

                "series" => 'required| min:2',

                "sale_date" => 'required|date',

                "type" => 'required',

            ]

        );

        // salvo array associativo con dati del form
        $data = $request->all();

        //nuova istanza 
        $newComic = new Comic();
        // $newComic->title = $data['title'];
        // $newComic->description = $data['description'];
        // $newComic->thumb = $data['thumb'];
        // $newComic->price = $data['price'];
        // $newComic->series = $data['series'];
        // $newComic->sale_date = $data['sale_date'];
        // $newComic->type = $data['type'];
        $newComic->fill($data);
        // salvo
        $newComic->save();

        // reindirizzo al nuovo comic
        return redirect()->route('comics.show', $newComic->id)->with('insert', 'Nuovo fumetto inserito con successo!');

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
        $comic = Comic::find($id);
      
        if($comic){

            return view("comic.show", compact("comic"));

        } else {
            abort(404);
        }
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit( Comic $comic)
    {
        return view('comics.edit', compact('comic'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Comic $comic)
    {
        
        //definisco validazioni 
        $request->validate(

            //array associativo con validazioni
            [

                "title" =>'required|min:5',

                "description" => 'required|min:10',

                "thumb" => 'required|url',

                "price" => 'required|numeric| min:1',

                "series" => 'required| min:2',

                "sale_date" => 'required|date',

                "type" => 'required',

            ]

        );

        //recupero dati form
        $data = $request->all();

        // inserisco nuovi data
        $comic->update($data);

        // salvo
        $comic->save();

        //reindirizzo
        return redirect()-> route('comics.show', $comic->id)->with('insert', 'Fumetto modificato con successo!');;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // cancellazione
        $comic->delete();

        // rotta di ritorno
        return redirect()->route('comics.index')->with('status', 'Cancellazione avvenuta con successo!');
    }
}
