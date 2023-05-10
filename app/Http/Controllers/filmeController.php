<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use App\Models\Filme;

class filmeController extends Controller
{
    //construimos o CRUD aqui

    public function buscaCadastroFilme(){
        return View('cadastroFilme');
    }

    public function cadastrarFilme(Request $request){
        $dadosfilmes = $request->validate([
            'nomefilme' => 'string|required',
            'atoresfilme' => 'string|required',
            'datalancamentofilme' => 'string|required',
            'sinopsefilme' => 'string|required',
            'capafilme' => 'file|required'
        ]);
       // dd($dadosfilmes);

        $file = $dadosfilmes['capafilme'];
        $path = $file->store('capa','public');
        $dadosfilmes['capafilme'] = $path;
        
        Filme::create($dadosfilmes);

        //return Redirect::route('/home');
    }

    public function MostrarGerenciadorFilme(Request $request){
        $dadosfilmes = Filme::all();
       // dd($dadosfuncionarios);

        $dadosfilmes = Filme::query();
        $dadosfilmes->when($request->nomefilme,function($query,$nomefilme ){
            $query->where('nomefilme','like','%'.$nomefilme.'%');
        }); 

        $dadosfilmes = $dadosfilmes->get();

        return view('gerenciadorFilme',['dadosfilme'=>$dadosfilmes]);
        
    }


    public function ApagarFilme(Filme $registrosFilmes){
        $registrosFilmes->delete();

        return Redirect::route('home');

}

    public function MostrarRegistrosFilme(Filme $registrosFilmes){
        return view('xxxx',['registrosFilmes'=>$registrosFilmes]);

    }

    public function AlterarBancoFilme(Filme  $registrosFilmes, Request $request){
        $dadosfilmes = $request->validate([
            'nomefilme'=> 'string|required',
                'atoresfilme'=> 'string|required',
                'datalancamentofilme'=> 'date|required',
                'sinopsefilme'=> 'string|required',
                'capafilme'=> 'string|required'
        ]);

        $registrosFilmes->fill($dadosfilmes);
        $registrosFilmes->save();

        return Redirect::route('gerenciar-filme');
    }
}

