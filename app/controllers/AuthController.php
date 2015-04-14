<?php

/**
 * Контроллер авторизации пользователей
 */
class AuthController extends \BaseController {
    
    /**
     * Форма логина
     */
    public function getLogin()
    {        
        return View::make('auth/login');
    }
    
    /**
     * Обработчик запроса авторизации
     */
    public function postLogin()
    {   
        // Формируем базовый набор данных для авторизации
        $creds = array(
            'password' => Input::get('password')
        );

        // В зависимости от того, что пользователь указал в поле username,
        // дополняем авторизационные данные
        $login = Input::get('login');
        if (strpos($login, '@')) {
            $creds['email'] = $login;
        } else {
            $creds['username'] = $login;
        }
        
        // Пытаемся авторизовать пользователя
        if (Auth::attempt($creds, Input::has('remember'))) 
        {
            return Redirect::to('/#'.Input::get('redirect'));
        } 
        else
        {
            return Redirect::to('auth/login')
                    ->with('message', 'Данная комбинация логина и пароля не является верной.');
        }
    }
    
    /**
     * Логаут
     */
    public function getLogout()
    {
        Auth::logout();
        return Redirect::to('auth/login');
    }
}
