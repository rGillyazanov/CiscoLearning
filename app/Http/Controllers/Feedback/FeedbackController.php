<?php

namespace App\Http\Controllers\Feedback;

use App\Feedback;
use App\Notice;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class FeedbackController extends Controller
{
    public function index()
    {
        return view('layouts.feedback.feedback');
    }

    public function store(Request $request)
    {
        $data = $request->except('_token');

        $message = [
            'text.max' => 'Максимальная длина обращения :max символов',
            'text.required' => 'Текст обращения должен быть заполнен',
            'topic.max' => 'Максимальная длина темы обращения :max символов',
            'topic.required' => 'Тема обращения должна быть заполнена',
            'section.max' => 'Максимальная длина раздела :max символов',
            'section.required' => 'Раздел обращения должен быть заполнен',
        ];

        $this->validate($request, [
            'text' => 'required|string|max:500',
            'topic' => 'required|string|max:50',
            'section' => 'required|string|max:50'
        ], $message);

        $feedback = new Feedback();

        $feedback->text = $data['text'];
        $feedback->topic = $data['topic'];
        $feedback->section = $data['section'];
        $feedback->user_id = Auth::id();

        $feedback->save();

        $notice = new Notice();

        $notice->sendNotice('Ваше сообщение "'.$data['topic'].'" будет рассмотрено в ближайшее время. Обращаем внимание на то, что ответ на ваще сообщение придет на почту указанную при регистрации!', Auth::id());

        return redirect()->back()->with('success', 'Ваше обращение отправлено');
    }
}
