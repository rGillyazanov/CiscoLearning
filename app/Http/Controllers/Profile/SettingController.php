<?php

namespace App\Http\Controllers\Profile;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Validator;

class SettingController extends Controller
{
    public function index()
    {
        return view('layouts.setting.setting');
    }

    public function about(Request $request)
    {
        $messages = [
            'city.max' => 'Название города не должно превышать :max символов',
            'status.max' => 'Статус должен быть не более :max символов',
        ];

        $this->validate($request, [
            'city' => 'string|sometimes|nullable|max:25',
            'status' => 'string|sometimes|nullable|max:150'
        ], $messages);

        $data = $request->only(['city', 'status']);

        $data = array_diff($data, array(''));

        foreach ($data as $key => $value)
            User::where('id', Auth::id())->update([$key => $value]);

        return redirect()->back()->with('success-about', 'Данные о вас успешно обновлены');
    }

    public function social(Request $request)
    {
        $messages = [
            'vk.max' => 'Ссылка на VK не должна превышать :max символов',
            'facebook.max' => 'Ссылка на Facebook не должна превышать :max символов',
            'vk.regex' => 'Неверная ссылка [Пример верной - https://vk.com/id1]',
            'facebook.regex' => 'Неверная ссылка [Пример верной - https://www.facebook.com/username]'
        ];

        $this->validate($request, [
            'vk' => [
                'string',
                'sometimes',
                'nullable',
                'max:50',
                'regex:/^(https?:\/\/)?(www\.)?vk\.com\/(\w|\d)+?\/?$/'
            ],
            'facebook' => [
                'string',
                'sometimes',
                'nullable',
                'max:50',
                'regex:^(?:(?:http|https):\/\/)?(?:www.)?facebook.com\/(?:(?:\w)*#!\/)?(?:pages\/)?(?:[?\w\-]*\/)?(?:profile.php\?id=(?=\d.*))?([\w\-]*)?^'
            ]
        ], $messages);

        $data = $request->only(['vk', 'facebook']);

        $data = array_diff($data, array(''));

        foreach ($data as $key => $value)
            User::where('id', Auth::id())->update([$key => $value]);

        return redirect()->back()->with('success-social', 'Данные социальных сетей успешно обновлены');
    }

    public function avatar(Request $request)
    {
        $rules = [
            'image' => 'image|mimes:jpeg,png,jpg|max:512|dimensions:max_width=800,max_height=800'
        ];

        $message = [
            'image.*' => 'Изображение должно быть формата jpeg, png или jpg, меньше 512 КБ и размером менее 800x800',
            'image.mimes' => 'Изображение должен быть jpeg, png или jpg',
            'image.max' => 'Изображение не должно превышать 512 КБ',
            'image.dimensions' => 'Размер изображения не должен превышать 800x800'
        ];

        $this->validate($request, $rules, $message);

        /**
         * Если аватар установлен и пользователь хочет его поменять, удаляем старый аватар
         */
        $checkAvatar = User::query()->select('avatar')->where('id', Auth::user()->id)->first();

        // Удаляем старый аватар
        if ($checkAvatar->getAttributeValue('avatar') != "avatars/NoPhotoExecutor.png")
        	Storage::disk('public')->delete($checkAvatar->getAttributeValue('avatar'));

        $path = $request->file('image')->store('/avatars', 'public');

        // Устанавливаем новый
        User::where('id', Auth::user()->id)->update(['avatar' => $path]);

        return redirect()->back()->with('success-avatar', 'Аватар успешно загружен');
    }

    /**
     * Смена пароля пользователя
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function postCredentials(Request $request)
    {
        $request_data = $request->all();

        $messages = [
            'current-password.required' => 'Введите текущий пароль',
            'password.required' => 'Введите новый пароль',
            'password.min' => 'Минимальная длина пароля :min символов',
            'password.max' => 'Максимальная длина пароля :max символов',
            'password_confirmation.required' => 'Подтвердите новый пароль',
            'password_confirmation.same' => 'Новый пароль подтверждён неверно'
        ];

        $this->validate($request, [
            'current-password' => 'required',
            'password' => 'required|same:password|min:6|max:50',
            'password_confirmation' => 'required|same:password',
        ], $messages);

        $current_password = Auth::user()->password;

        /**
         * Если текущий пароль введен верно, изменяем пароль на новый, иначе
         * выдаем ошибку, что пароль введён неверно.
         */
        if (Hash::check($request_data['current-password'], $current_password))
        {
            $user_id = Auth::id();

            $obj_user = User::find($user_id);
            $obj_user->password = Hash::make($request_data['password']);;
            $obj_user->save();

            return redirect()->back()->with('success-new-password', 'Пароль успешно изменен.');
        }

        return redirect()->back()->withErrors(['current-password' => 'Неверный текущий пароль']);
    }
}
