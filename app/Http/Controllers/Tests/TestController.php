<?php

namespace App\Http\Controllers\Tests;

use App\GroupTask;
use App\GroupUser;
use App\Task;
use App\User;
use App\UserAnswer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TestController extends Controller
{
    /**
     * Список всех тестов доступных студенту
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $tests = GroupTask::query()->where('group_id', '=', Auth::user()->group_id, 'AND')->where('access', 1)->paginate(9)
            ->appends(\request()->all());

        return view('layouts.test.tests', ['tests' => $tests]);
    }

    /**
     * Отображаем тестирование
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|void
     */
    public function show($id)
    {
        /**
         * Проверяем доступен ли тест группе.
         */
        $labAccess = GroupTask::query()->where('task_id', $id)->where('group_id', Auth::user()->group_id)->first();
        $test = Task::find($id);

        if ($labAccess->access == 0 || !$test) {
            return abort(404);
        }

        /**
         * Проверяем ответы пользователя в тесте и если он прошел тест выводим его результат
         */
        $checkOnResult = UserAnswer::query()->select('user_id')->where('user_id', Auth::id())->where('task_id', $id)->count();

        if ($checkOnResult > 0)
        {
            $testResult = UserAnswer::query()->where('user_id', Auth::id())->where('task_id', $id)->get();

            $countTrueAnswer = DB::table('user_answer')
                ->join('questions', 'user_answer.answer_id', '=', 'questions.true_answer')
                ->where('task_id', $id)
                ->where('user_id', Auth::id())
                ->count();

            return view('layouts.test.showresultAfter', ['testResult' => $testResult, 'countTrueAnswer' => $countTrueAnswer]);
        }

        return view('layouts.test.showtest', ['test' => $test]);
    }

    /**
     * Функция заносит ответы студента на тестирование в БД,
     * а затем выдает результаты тестирования.
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function getAnswers(Request $request)
    {
        /**
         * Получаем ID вопросов
         */
        $questions = array_keys($request->all());
        array_shift($questions);
        array_shift($questions);

        /**
         * Получаем ID ответов
         */
        $answers = array_values($request->all());
        array_shift($answers);
        array_shift($answers);

        $task = Task::query()->find($request->get('taskId'));

        if ($task)
        {
            /**
             * Получаем массив верных ответов на тест и
             * сравниваем ответы пользователя с правильными.
             */
            $trueAnswers = [];

            foreach ($task->getQuestions as $question)
            {
                $idTrueAnswer = (int)$question->getTrueAnswer->id;
                array_push($trueAnswers, $idTrueAnswer);
            }

            /**
             * Вопросы на которые пользователь ответил верно.
             */
            $checkAnswers = [];

            for ($i = 0; $i < count($trueAnswers); $i++)
            {
                if ((int)$answers[$i] == (int)$trueAnswers[$i])
                {
                    array_push($checkAnswers, "1");
                }
                else
                {
                    array_push($checkAnswers, "0");
                }
            }

            /**
             * Получаем результирующий массив типа
             * Вопрос: Ответ
             * 0 - Неправильный
             * 1 - Правильный
             */
            $result = array_combine($questions, $checkAnswers);

            $trueAnswersCount = 0;

            foreach ($result as $item)
            {
                if ($item == 1)
                {
                    $trueAnswersCount++;
                }
            }

            for ($index = 0; $index < count($questions); $index++)
            {
                $userAnswer = new UserAnswer();
                $userAnswer->user_id = Auth::id();
                $userAnswer->task_id = $request->get('taskId');
                $userAnswer->question_id = $questions[$index];
                $userAnswer->answer_id = $answers[$index];
                $userAnswer->save();
            }

            return view('layouts.test.showresult', [
                'TrueAnswers' => $trueAnswersCount,
                'FalseAnswers' => count($result) - $trueAnswersCount,
                'Result' => $result,
                'Answers' => $answers
            ]);
        }
        
        return redirect()->back();
    }

    /**
     * Получаем список тестов выполненные студентом
     * @param $userId
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function listTestResult($userId)
    {
        $listTest = UserAnswer::query()->select(['task_id', 'user_id'])->where('user_id', $userId)->distinct()->get();

        return view('layouts.test.resultList', ['listTest' => $listTest]);
    }

    /**
     * Преподаватель выбирает студента и тест, чтобы проверить его результаты.
     * Функция отображает результаты тестирования студента.
     * @param $taskId
     * @param $userId
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View|void
     */
    public function showStudent($taskId, $userId)
    {
        /**
         * Проверяем, состоит ли студент в группе, которая доступна преподавателю.
         */
        $userGroup = User::query()->where('id', $userId)->first()->group_id;

        $groupAccess = GroupUser::query()->where('group_id', $userGroup)->where('user_id', Auth::id())->count();

        $test = Task::find($taskId);

        /**
         * Если тест не найден или студент не состоит в группе преподавалетя
         * выводим ошибку 404
         */
        if ($groupAccess == 0 || !$test) {
            return abort(404);
        }

        /**
         * Проверяем ответы пользователя в тесте и если он прошел тест выводим его результат
         */
        $checkOnResult = UserAnswer::query()->select('user_id')->where('user_id', Auth::id())->where('task_id', $taskId)->count();

        if ($checkOnResult > 0)
        {
            $testResult = UserAnswer::query()->where('user_id', $userId)->where('task_id', $taskId)->get();

            $countTrueAnswer = DB::table('user_answer')
                ->join('questions', 'user_answer.answer_id', '=', 'questions.true_answer')
                ->where('task_id', $taskId)
                ->where('user_id', $userId)
                ->count();

            return view('layouts.test.showresultAfter', ['testResult' => $testResult, 'countTrueAnswer' => $countTrueAnswer]);
        }

        return redirect()->route('tests.show.student', ['taskId' => $taskId, 'userId' => $userId])->with(['notFound' => 'Студент не выполнял тестирование']);
    }
}
