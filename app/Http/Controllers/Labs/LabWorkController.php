<?php

namespace App\Http\Controllers\Labs;

use App\Comment;
use App\GroupPractical;
use App\Practical;
use App\PracticalUser;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class LabWorkController extends Controller
{
    public function show()
    {
        /**
         * Получаем список всех лабораторных работ, которые доступны студенту
         */
        $labs = GroupPractical::query()->where('group_id', '=', Auth::user()->group_id, 'AND')->where('access', 1)->paginate(6)
            ->appends(\request()->all());

        return view('layouts.labs.labs', ['labs' => $labs]);
    }

    public function showLab($id)
    {
        /**
         * Ищем лабораторную работу с указанным ID
         */
        $labAccess = GroupPractical::query()->where('practical_id', $id)->where('group_id', Auth::user()->group_id)->first();
        $lab = Practical::find($id);

        if (!$labAccess || $labAccess->access == 0 || !$lab)
        {
            return abort(404);
        }

        /**
         * Проверка
         * Добавлял ли пользователь лабораторную работу в свой профиль
         */
        $checkStartLab = PracticalUser::query()->where('practical_id', '=', $id, 'AND')->where('user_id', Auth::id())->count();

        /**
         * Получаем комментарии лабораторной
         */
        $comments = Comment::query()->select('*')->where('practical_id', $id)->get();

        $json = json_decode($lab->file);

        $file = $json[0]->download_link;

        $formatFile = pathinfo($json[0]->original_name);

        $fileName = $lab->name."-".Auth::user()->name.'.'.$formatFile["extension"];

        return view('layouts.labs.lab', ['lab' => $lab, 'comments' => $comments, 'file' => $file, 'fileName' => $fileName, 'checkStartLab' => $checkStartLab]);
    }

    public function addLabInProfile(Request $request)
    {
        $newLabInProfile = new PracticalUser();

        $newLabInProfile->practical_id = $request->get('labId');
        $newLabInProfile->user_id = Auth::id();
        $newLabInProfile->score_id = 6;
        $newLabInProfile->file = '';
        $newLabInProfile->save();

        return redirect()->back()->with('success-add', 'Работа добавлена в список ваших оценочных работ. Выполните её и загрузите конфигурационный файл');
    }

    public function uploadLab(Request $request)
    {
        $checkLabWork = PracticalUser::query()->where('user_id', '=', Auth::id(), 'AND')->where('file', '!=', '', 'AND')->where('practical_id', '=', $request->get('lab'))->count();

        if ($checkLabWork > 0) {
            return redirect()->back()->withErrors(['file' => 'Вы уже загружали файл для данной лабораторной работы!']);
        }

        $rules = [
            'lab' => 'required|exists:practicals,id',
            'file' => 'file|mimes:zip,rar,7z|max:1024'
        ];

        $message = [
            'file.*' => 'Файл должен быть формата zip,rar,7z и меньше 1024 КБ',
            'file.mimes' => 'Файл должен быть формата zip,rar,7z',
            'file.max' => 'Файл не должен превышать 1024 КБ',
            'lab.required' => 'Нет доступных работ для загрузки',
            'lab.exists' => 'Данная лабораторная работа не найдена'
        ];

        Validator::make(['file' => $request->file('upload_file'), 'lab' => $request->get('lab')], $rules, $message)->validate();

        $path = $request->file('upload_file')->store('/labs/'.Auth::id(), 'public');

        PracticalUser::query()->where('practical_id', '=', $request->get('lab'), 'and')->where('user_id', Auth::id())->update(['file' => $path]);

        return redirect()->back()->with('success', 'Файл успешно загружен');
    }

    public function showUploadForm()
    {
        $labs = PracticalUser::query()->where('user_id', '=', Auth::id(), 'AND')->where('file', '=', '')->get();

        return view('layouts.labs.uploaded', ['labs' => $labs]);
    }

    public function deleteFile(Request $request)
    {
        $deleteId = $request->get('delete');

        $userId = PracticalUser::query()->where('id', $deleteId)->first()->getUser->id;

        if (Auth::id() == $userId) {
            /**
             * Ищем ID выполненной работы студента и удаляем файл.
             */

            $this->validate($request, [
                'delete' => 'required|exists:practical_user,id'
            ], [
                '*.required' => 'Поле :attribute не заполнено.',
                '*.exists' => 'Значение :input не найдено.'
            ]);

            $workId = PracticalUser::query()->where('id', $deleteId)->first();

            // Удаляем файл с сервера
            Storage::disk('public')->delete($workId->file);

            $workId->update(['file' => '']);

            return redirect()->back()->with(['success' => 'Файл успешно удалён.']);
        }

        return abort(403);
    }
}
