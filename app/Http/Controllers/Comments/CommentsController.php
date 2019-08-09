<?php

namespace App\Http\Controllers\Comments;

use App\Comment;
use App\Notice;
use App\Practical;
use App\PracticalUser;
use App\Score;
use App\Theory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CommentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $comments = Comment::query()->where("user_id", Auth::id())->paginate(10)->appends(\request()->all());

        return view('layouts.comments.comments', ['comments' => $comments]);
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
        $request->validate([
            'comment_text' => 'required|string|max:500',
            'comment_lab_id' => 'required|integer',
            'comment_parent' => 'required|integer'
        ]);
        $comment = new Comment([
            'text' => $request->get('comment_text'),
            'practical_id' => $request->get('comment_lab_id'),
            'parent' => $request->get('comment_parent'),
            'user_id' => Auth::id()
        ]);
        $comment->save();

        if ($request->get('comment_parent') != 0)
        {
            $notice = new Notice();

            $notice->sendNotice(Auth::user()->name." ответил на ваш комментарий ".Comment::query()->find($request->get('comment_parent'))->text." в теме: <a href='".route('lab', $request->get('comment_lab_id'))."'>".Practical::query()->find($request->get('comment_lab_id'))->name."</a>", Comment::query()->find($request->get('comment_parent'))->getUser->id);
        }

        return redirect()->back()->with(['success' => 'Комментарий успешно добавлен']);
    }

    public function storeLab(Request $request)
    {
        $request->validate([
            'comment_text' => 'required|string|max:500',
            'comment_practical_user_id' => 'required|integer',
            'comment_parent' => 'required|integer'
        ]);
        $comment = new Comment([
            'text' => $request->get('comment_text'),
            'practical_user_id' => $request->get('comment_practical_user_id'),
            'parent' => $request->get('comment_parent'),
            'user_id' => Auth::id()
        ]);
        $comment->save();

        if ($request->get('comment_parent') != 0)
        {
            $notice = new Notice();

            if (Auth::user()->role_id == 2)
                $notice->sendNotice(Auth::user()->name." ответил на ваш комментарий ".Comment::query()->find($request->get('comment_parent'))->text." в выполненной лабораторной работе: <a href='".route('scores.student', Auth::id())."'>".PracticalUser::query()->find($request->get('comment_practical_user_id'))->getPractical->name."</a>", Comment::query()->find($request->get('comment_parent'))->getUser->id);
            else
                $notice->sendNotice(Auth::user()->name." ответил на ваш комментарий ".Comment::query()->find($request->get('comment_parent'))->text." в выполненной лабораторной работе: <a href='".route('scores.index')."'>".PracticalUser::query()->find($request->get('comment_practical_user_id'))->getPractical->name."</a>", Comment::query()->find($request->get('comment_parent'))->getUser->id);
        }

        return redirect()->back()->with(['success' => 'Комментарий успешно добавлен']);
    }

    public function storeTheory(Request $request)
    {
        $request->validate([
            'comment_text' => 'required|string|max:500',
            'comment_theory_id' => 'required|integer',
            'comment_parent' => 'required|integer'
        ]);
        $comment = new Comment([
            'text' => $request->get('comment_text'),
            'theory_id' => $request->get('comment_theory_id'),
            'parent' => $request->get('comment_parent'),
            'user_id' => Auth::id()
        ]);
        $comment->save();

        if ($request->get('comment_parent') != 0)
        {
            $notice = new Notice();

            $notice->sendNotice(Auth::user()->name." ответил на ваш комментарий ".Comment::query()->find($request->get('comment_parent'))->text." в теме: <a href='".route('theory.show', $request->get('comment_theory_id'))."'>".Theory::query()->find($request->get('comment_theory_id'))->name."</a>", Comment::query()->find($request->get('comment_parent'))->getUser->id);
        }

        return redirect()->back()->with(['success' => 'Комментарий успешно добавлен']);
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
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $comment = Comment::query()->find($id);

        return view('layouts.comments.edit', ['comment' => $comment]);
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
        $request->validate([
            'comment_text' => 'required|string'
        ]);

        $comment = Comment::find($id);

        if ($comment->user_id == Auth::id())
        {
            $comment->text = $request->get('comment_text');
            $comment->save();
        }

        return redirect()->back()->with(['success' => 'Комментарий отредактирован']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $comment = Comment::query()->find($id);

        if ($comment->user_id == Auth::id())
            $comment->delete();
    }
}
