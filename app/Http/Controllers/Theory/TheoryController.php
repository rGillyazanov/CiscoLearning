<?php

namespace App\Http\Controllers\Theory;

use App\Theory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TheoryController extends Controller
{
    /**
     * Отображает список всех теоретических материалов
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $theories = Theory::query()->select()->paginate(9)->appends(\request()->all());

        return view('layouts.theory.theories', ['theories' => $theories]);
    }

    /**
     * Отображает пост о конктерном теоретическом материале
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        $theory = Theory::query()->find($id);

        if (!$theory)
        {
            return abort(404);
        }

        return view('layouts.theory.theoryshow', ['theory' => $theory]);
    }
}
