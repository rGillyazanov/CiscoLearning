<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

/**
 * Авторизованный пользователь
 */
Route::middleware(['web', 'auth'])->group(function () {
    Route::get('/', 'HomeController@index')->name('home');

    Route::prefix('profile')->group(function () {

        /**
         * Собственный профиль
         */
        Route::get('/', 'Profile\ProfileController@myProfile')->name('profile.my');

        /**
         * Профиль студента
         */
        Route::get('/{id}', 'Profile\ProfileController@profile')->name('student.profile');

        Route::get('/setting', 'Profile\SettingController@index')->name('setting.profile');
        Route::post('/setting/social', 'Profile\SettingController@social')->name('setting.social');
        Route::post('/setting/about', 'Profile\SettingController@about')->name('setting.about');
        Route::post('/setting/avatar', 'Profile\SettingController@avatar')->name('setting.avatar');
        Route::post('/setting/change/password', 'Profile\SettingController@postCredentials')->name('setting.change.password');
    });

    Route::prefix('groups')->group(function () {

        /**
         * Группа авторизованного пользователя
         */
        Route::get('/', 'Groups\GroupsController@show')->name('groups.my');

        /**
         * Группы преподавателя
         */
        Route::middleware(['teacher.access'])->group(function () {
            Route::get('/teacher', 'Groups\GroupsController@myGroups')->name('groups.teacher');
            Route::get('/students', 'Groups\GroupsController@getStudentsFromGroup')->name('groups.students');
        });
    });

    Route::prefix('labs')->group(function () {
        /**
         * Лабораторные работы
         */
        Route::get('/', 'Labs\LabWorkController@show')->name("labs");

        /**
         * Лабораторная работа (ID)
         */
        Route::get('/{id}', 'Labs\LabWorkController@showLab')->name("lab");

        /**
         * Добавить лабораторную работу в профиль
         */
        Route::post('/addInProfile', 'Labs\LabWorkController@addLabInProfile')->name('add.in.profile');

        Route::post('/deleteLab', 'Labs\LabWorkController@deleteFile')->name("lab.delete");
    });

    /**
     * Загрузка файла лабораторной работы
     */
    Route::get('/file', 'Labs\LabWorkController@showUploadForm')->name('filelab');
    Route::post('/file', 'Labs\LabWorkController@uploadLab')->name('upload.lab');

    /**
     * Уведомления
     */
    Route::resource('notices', 'Notices\NoticesController');

    /**
     * Проверка на наличие уведомлений
     */
    Route::get('/check', function () {
        return response()->json([
            'count' => \App\Notice::query()->where('user_id', Auth::id())->where('status', '=', 0, 'AND')->count()
        ]);
    })->name('notices.check');

    /**
     * Комментарии
     */
    Route::resource('comments', 'Comments\CommentsController');
    Route::post('/comment/storeLab', 'Comments\CommentsController@storeLab')->name('comment.storeLab');
    Route::post('/comment/storeTheory', 'Comments\CommentsController@storeTheory')->name('comment.storeTheory');

    /**
     * Оценки
     */
    Route::prefix('scores')->group(function () {
        /**
         * Мои лабораторные работы
         */
        Route::get('/', 'Scores\ScoreController@index')->name("scores.index");

        /**
         * Лабораторные работы выполненные студентом
         */
        Route::middleware(['teacher.access'])->group(function () {
            Route::get('/student/{id}', 'Scores\ScoreController@student')->name('scores.student');

            Route::post('/setscore', 'Scores\ScoreController@setScore')->middleware(['teacher.access'])->name('scores.set.score');
        });
    });

    /**
     * Тестирование
     */
    Route::prefix('test')->group(function () {
        /**
         * Список тестов
         */
        Route::get('/', 'Tests\TestController@index')->name("tests.index");

        /**
         * Тест
         */
        Route::get('/{id}', 'Tests\TestController@show')->name("tests.show");

        /**
         * Список выполненных тестов студентом
         */
        Route::get('/student/{userId}', 'Tests\TestController@listTestResult')->middleware(['teacher.access'])->name("tests.show.listTestResult");

        /**
         * Проверка результата тестирования
         */
        Route::get('/{taskId}/student/{userId}', 'Tests\TestController@showStudent')->middleware(['teacher.access'])->name("tests.show.student");

        /**
         * Получение ответов
         */
        Route::post('/getAnswers', 'Tests\TestController@getAnswers')->name('tests.answers');
    });
    
    /**
     * Теория
     */
    Route::prefix('theory')->group(function () {
        /**
         * Список теоретических материалов
         */
        Route::get('/', 'Theory\TheoryController@index')->name("theory.index");

        /**
         * Теоретический материал
         */
        Route::get('/{id}', 'Theory\TheoryController@show')->name("theory.show");
    });

    /**
     * Список версий
     */
    Route::get('/feedback', 'Feedback\FeedbackController@index')->name('feedback');
    Route::post('/feedbackadd', 'Feedback\FeedbackController@store')->name('feedback-add-topic');
});

Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});
