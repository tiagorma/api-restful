<?php

namespace App\Http\Controllers;

use App\Models\Person;
use Illuminate\Http\Request;

class PersonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //..recuperando os pessoas do banco de dados
        $people = Person::all();
        //..retorna a view index passando a variável $peoples
        //return view('Persons.index')->with('Persons', $peoples);
       
        $people = Person::get()->toJson(JSON_PRETTY_PRINT);
        return response($people, 200);
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
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //..instancia um novo model Person
    $people = new Person();
    //..pega os dados vindos do form e seta no model
    $people->nome = $request->input('nome');
    $people->cpf = $request->input('cpf');
    $people->endereco = $request->input('endereco');
    $people->sexo = $request->input('sexo');
    //..persiste o model na base de dados
    $people->save();
    //..retorna a view com uma variável msg que será tratada na própria view
    $peoples = Person::all();
    return response()->json([
        "message" => "Pessoa cadastrada com sucesso! :)"
    ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (Person::where('id', $id)->exists()) {
            $people = Person::where('id', $id)->get()->toJson(JSON_PRETTY_PRINT);
            return response($people, 200);
          } else {
            return response()->json([
              "message" => "Pessoa não cadastrada!"
            ], 404);
          }
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
        if (Person::where('id', $id)->exists()) {
            $people = Person::find($id);
            $people->nome = is_null($request->nome) ? $people->nome : $request->nome;
            $people->cpf = is_null($request->cpf) ? $people->cpf : $request->cpf;
            $people->endereco = is_null($request->endereco) ? $people->endereco : $request->endereco;
            $people->sexo = is_null($request->sexo) ? $people->sexo : $request->sexo;
            $people->save();
    
            return response()->json([
                "message" => "Pessoa atualizada com sucesso"
            ], 200);
            } else {
            return response()->json([
                "message" => "Atenção, pessoa não encontrada!"
            ], 404);
            
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(Person::where('id', $id)->exists()) {
            $people = Person::find($id);
            $people->delete();
    
            return response()->json([
              "message" => "Registro deletado com sucesso! :)"
            ], 202);
          } else {
            return response()->json([
              "message" => "Atenção, pessoa não encontrada!"
            ], 404);
          }
    }
}
