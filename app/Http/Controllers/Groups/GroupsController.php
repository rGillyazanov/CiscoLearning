<?php

namespace App\Http\Controllers\Groups;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class GroupsController extends Controller
{
    /**
     * Количество записей на страницу
     */
    public $perPage = 10;
    
    /**
     * Модель студента
     */
    public $students;
    
    /**
     * Возвращаем список студентов в группе авторизованного пользователя
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show()
    {
        $user = Auth::user();

        return view('layouts.groups.group', ['user' => $user]);
    }

    /**
     * Отображаем список групп преподавателя, для выбора студентов
     */
    public function myGroups()
    {
        /**
         * Получаем модель авторизованного преподавателя и отображаем его группы
         */
        $teacher = Auth::user();

        return view('layouts.groups.myGroups', ['groups' => $teacher->getGroups, 'students' => $this->students]);
    }

    /**
     * Преподаватель получает список всех студентов в выбранной группе
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getStudentsFromGroup(Request $request)
    {
        $rules = [
            'group' => [
                'required',
                Rule::exists('group_user', 'group_id')->where('user_id', Auth::id())
            ]
        ];

        $message = [
            'group.required' => 'У вас нет группы',
            'group.exists' => 'Вы не можете просмотреть выбранную группу'
        ];

        Validator::make(['group' => $request->get('group')], $rules, $message)->validate();

        $this->students = User::query()->where('group_id', $request->get('group'))->where('role_id', '=', 2, 'AND')->orderBy('name', 'asc')->paginate($this->perPage)->appends($request->all());

        return view('layouts.groups.studentsFromGroup', ['students' => $this->students]);
    }

    /**
     * Получаем среднюю оценку студента
     */
    public static function getAvgScoreStudent($id)
    {
        $avgScore = DB::table('practical_user')
            ->join('scores', 'practical_user.score_id', '=', 'scores.id')
            ->where('user_id', $id)
            ->where('practical_user.score_id', '!=', 6)
            ->avg('score');

        return round($avgScore, 2);
    }
}
