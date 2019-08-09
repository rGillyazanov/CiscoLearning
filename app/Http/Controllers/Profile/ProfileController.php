<?php

namespace App\Http\Controllers\Profile;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    /**
     * Модель пользователя
     */
    public $user;

    /**
     * Просмотр профиля пользователя
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function profile($id)
    {
        $this->user = User::query()->find($id);

        if ($this->user == null || (Auth::user()->role_id == 2 && $this->user->getGroup->id != Auth::user()->group_id))
            return redirect()->route('home');

        return view('layouts.profile.studentProfile', ['user' => $this->user]);
    }

    /**
     * Просмотр своего профиля
     */
    public function myProfile()
    {
        return view('layouts.profile.studentProfile', ['user' => Auth::user()]);
    }
}
