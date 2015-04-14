<?php

/**
 * RESTful-контроллер для управления списком пользователей
 */
class UsersController extends BaseController {
    // Правила валидации
    private $niceNames = array(
                'username' => 'Логін',
                'email' => 'E-Mail',
                'password' => 'Пароль',
            );
    // Имена полей
    private $rules = array(
                'username' => 'required|unique:users',
                'email' => 'required|unique:users|email',
                'password' => 'min:5',
            );  
    
    public function __construct()
    {
        // Проверка авторизации
        $this->beforeFilter('auth');
    }

    /**
     * Получение списка серверов в формате JSON
     */
    public function index()
    {
        $users = User::all();
                
        $arr = array();
        foreach ($users as $user)
        {
            $a = $user->toArray();
            $a['created_at'] = date('d.m.Y H:i:s', strtotime($a['created_at']));
            $a['updated_at'] = date('d.m.Y H:i:s', strtotime($a['updated_at']));
            $arr[] = $a;
        }
                    
        return Response::json($arr);
    }
    
    /**
     * Получение списка серверов в формате JSON
     */
    public function destroy($id)
    {
        $user = User::find($id);
       
        if ($user and User::count() > 1)
        {
            $user->delete();

            return Response::json(array('result' => 'success'));
        }

        App::abort(404);
    }
    
    /**
     * Обновление данных сервера
     */
    public function update($id)
    {
        $user = User::find($id);
        
        if ($user)
        {
            $this->rules['username'] = 'required|unique:users,username,'.$id;
            $this->rules['email'] = 'required|email|unique:users,email,'.$id;
            
            $validator = Validator::make(Input::all(), $this->rules);
            $validator->setAttributeNames($this->niceNames); 
            
            if (!$validator->fails()) 
            {
                
                $user->username = Input::get('username');
                $user->email = Input::get('email');
                if (Input::get('password')) {
                    $user->password = Hash::make(Input::get('password'));            
                }
                $user->save();
                return Response::json($user);
            }
            else
            {
                $validation_errors = '';
                $messages = $validator->messages();
                // Валидация не прошла
                foreach ($messages->all() as $message) {
                    $validation_errors .= $message.'<br>';
                }
                return Response::json(array('validation_errors' => $validation_errors), 400);
            } 
        }
           
        App::abort(404);
    }
    
    /**
     * Создание нового сервера
     */
    public function store()
    {                         
        $validator = Validator::make(Input::all(), $this->rules);
        $validator->setAttributeNames($this->niceNames); 
        
        if (!$validator->fails()) 
        {
            // Валидация прошла успешно
            $user = new User;
            $user->username = Input::get('username');
            $user->email = Input::get('email');
            if (Input::get('password')) {
                $user->password = Hash::make(Input::get('password'));            
            }
            $user->save();
            $insertedId = $user->id;

            if ($insertedId)
            {                
                return Response::json($user);
            }
            else
            {
                App::abort(500);
            }
        }
        else
        {
            $validation_errors = '';
            $messages = $validator->messages();
            // Валидация не прошла
            foreach ($messages->all() as $message) {
                $validation_errors .= $message.'<br>';
            }
            return Response::json(array('validation_errors' => $validation_errors), 400);
        }    
    }
}