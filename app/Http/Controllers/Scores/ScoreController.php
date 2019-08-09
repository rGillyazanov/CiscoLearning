<?php

namespace App\Http\Controllers\Scores;

use App\Comment;
use App\Notice;
use App\Practical;
use App\PracticalUser;
use App\Score;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ScoreController extends Controller
{
    /**
     * Количество записей отображаемых на странице
     */
    public $perPage = 10;
    
    /**
     * Оценки авторизованного студента
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        /**
         * Все выполненые лабораторные студента с оценкой
         */
        $scoreslab = PracticalUser::query()->where('user_id', Auth::id())->paginate($this->perPage)->appends(\request()->all());

        /**
         * Список всех оценок
         */
        $scores = Score::all();

        /**
         * Средняя оценка за лабораторные работы
         */
        $score = DB::table('practical_user')
            ->join('scores', 'practical_user.score_id', '=', 'scores.id')
            ->where('user_id', '=', Auth::id(), 'AND')
            ->where('practical_user.score_id', '!=', 6)
            ->avg('score');

        return view('layouts.scores.score', ['scoreslab' => $scoreslab, 'scores' => $scores, 'avgScore' => round($score, 2), 'student' => User::find(Auth::id())]);
    }

    /**
     * Отображаем все выполненные лабораторные работы студента
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function student($id)
    {
        $user = User::find($id);
        
        if (!$user) {
            return abort(404);
        }

        /**
         * Все выполненые лабораторные студента с оценкой
         */
        $scoreslab = PracticalUser::query()->where('user_id', $id)->paginate(10)->appends(\request()->all());

        /**
         * Список всех оценок
         */
        $scores = Score::all();

        /**
         * Средняя оценка за лабораторные работы
         */
        $score = DB::table('practical_user')
            ->join('scores', 'practical_user.score_id', '=', 'scores.id')
            ->where('user_id', '=', $id, 'AND')
            ->where('practical_user.score_id', '!=', 6)
            ->avg('score');

        return view('layouts.scores.score', ['scoreslab' => $scoreslab, 'scores' => $scores,'avgScore' => round($score, 2), 'student' => User::find($id)]);
    }

    /**
     * Выставляем оценку студенту за лабораторную работу
     */
    public function setScore(Request $request)
    {
        $rules = [
            'labId' => [
                'required',
                Rule::exists('practical_user', 'practical_id')->where('user_id', $request->get('user'))
            ],
            'score' => [
                'required',
                Rule::exists('scores', 'id')
            ],
            'user' => [
                'required',
                Rule::exists('practical_user', 'user_id')->where('practical_id', $request->get('labId'))
            ]
        ];

        $message = [
            '*.required' => 'Поле :attribute должно быть заполнено.',
            '*.exists' => 'Поле :attribute не найдено, не обманывайте.'
        ];

        Validator::make([
            'labId' => $request->get('labId'),
            'score' => $request->get('score'),
            'user' => $request->get('user')
        ], $rules, $message)->validate();

        /**
         * Проставляем оценку в лабораторную, выполненную студентом
         */
        PracticalUser::query()->where('practical_id', '=', $request->get('labId'), 'AND')
            ->where('user_id', $request->get('user'))
            ->update(['score_id' => $request->get('score')]);

        $practical = Practical::find($request->get('labId'));

        $notice = new Notice();

        $notice->sendNotice(Auth::user()->name." выставил вам оценку ".Score::query()->find($request->get('score'))->name." за работу <a href='".route('lab', $practical->id)."'>".$practical->name."</a>", $request->get('user'));

        return redirect()->back()->with('success', "Оценка поставлена");
    }
}
