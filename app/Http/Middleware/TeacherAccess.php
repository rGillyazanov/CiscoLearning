<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class TeacherAccess
{
    /**
     * Проверяет роль пользователя пренадлежащая преподавателю.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        /**
         * Если роль пользователя не является студентом
         * перенаправляем его на домашнюю страницу, иначе
         * передаем выполнение запроса дальше.
         */
        if (Auth::user()->role_id == 2) {
            return abort(403);
        }

        return $next($request);
    }
}