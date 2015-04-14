<?php

/**
 * RESTful-контроллер для управления списков серверов
 */
class ServersController extends BaseController {

    // Правила валидации
    private $rules = array(
            'name' => '',
            'model' => '',
            'ip' => 'ip',
            'start_date' => 'date',
            'type_id' => 'exists:types,id',
            'doc_name' => 'max:255',
            'cpu' => '',
            'hdd' => '',
            'ram' => '',
            'os' => '',
            'inventory_number' => 'unique:servers',
            'serial_number' => 'unique:servers',
            'appointment' => '',
    );
    
    // Имена полей
    private $niceNames = array(
            'name' => 'Назва',
            'model' => 'Модель',
            'ip' => 'IP-адреса',
            'start_date' => 'Дата вводу в експлуатацію',
            'type_id' => 'Тип',
            'physical_server_id' => 'Фізичний сервер',
            'doc_name' => 'Документ',
            'cpu' => 'CPU',
            'hdd' => 'HDD',
            'ram' => 'RAM',
            'os' => 'Операційна система',
            'inventory_number' => 'Інв. номер',
            'serial_number' => 'Серійний номер',
            'appointment' => 'Призначення',
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
        $servers = Server::all();
                
        $arr = array();
        foreach ($servers as $server)
        {
            $a = $server->toArray();
            $a['type'] = $server->type->title;
            $a['history'] = json_decode($server->history);
            $a['start_date'] = $a['start_date'] ? date('d.m.Y', strtotime($a['start_date'])) : '';
            $a['created_at'] = date('d.m.Y H:i:s', strtotime($a['created_at']));
            $a['updated_at'] = date('d.m.Y H:i:s', strtotime($a['updated_at']));
            $arr[] = $a;
        }
                    
        return Response::json($arr);
    }
    
    /**
     * Удаление сервера
     */
    public function destroy($id)
    {
       $server = Server::find($id);
       
       if ($server)
       {
           $server->delete();
           
           return Response::json(array('result' => 'success'));
       }
           
       App::abort(404);
    }
    
    /**
     * Обновление данных сервера
     */
    public function update($id)
    {
        $server = Server::find($id);
        
        if ($server)
        {            
            if (Input::get('type_id') == 2)
            {
                $this->rules['physical_server_id'] .= 'exists:servers,id';
                
                // Правило валидации для определения наличия вирт. серваков 
                // на этом физ. сервере
                Validator::extend('no_virtual_servers', 
                        function ($attribute, $value, $parameters) {
                            $res = TRUE;
                            $s = Server::find($parameters[0]);
                            if ($s->virtualServers->count() > 0)
                            {
                                $res = FALSE;
                            }
                            return $res;
                        });              
                $this->rules['type_id'] .= "|no_virtual_servers:{$server->id}";
            }
            $this->rules['serial_number'] .=  ',serial_number,'.$server->id;
            $this->rules['ip'] .= '|unique:servers,ip,'.$server->id;
            $this->rules['inventory_number'] .= ',inventory_number,'.$server->id;
            $validator = Validator::make(Input::all(), $this->rules);
            $validator->setAttributeNames($this->niceNames); 
            
            if (!$validator->fails()) 
            {
                $history = array();
                $time = time();
                if ($server->name != Input::get('name')) 
                {
                    $history[] = array(
                        'time' => $time,
                        'field' => 'Назва',
                        'old_value' => $server->name,
                        'new_value' => Input::get('name'),
                    );                    
                }
                if ($server->model != Input::get('model')) 
                {
                    $history[] = array(
                        'time' => $time,
                        'field' => 'Модель',
                        'old_value' => $server->model,
                        'new_value' => Input::get('model'),
                    );                    
                }
                if ($server->ip != Input::get('ip')) 
                {
                    $history[] = array(
                        'time' => $time,
                        'field' => 'IP-адреса',
                        'old_value' => $server->ip,
                        'new_value' => Input::get('ip'),
                    );                    
                }
                $d = Input::get('start_date') ? date('Y-m-d H:i:s', strtotime(Input::get('start_date'))) : '';
                if ($server->start_date != $d)
                {
                    $history[] = array(
                        'time' => $time,
                        'field' => 'Дата вводу в експлуатацію',
                        'old_value' => $server->start_date ? date('d.m.Y', strtotime($server->start_date)) : '',
                        'new_value' => Input::get('start_date'),
                    );                    
                }
                if ($server->type_id != Input::get('type_id')) 
                {
                    $new_title = Input::get('type_id') == 1 ? 'Фізичний' : 'Віртуальний';
                    $history[] = array(
                        'time' => $time,
                        'field' => 'Тип',
                        'old_value' => $server->type->title,
                        'new_value' => $new_title,
                    );
                }
                if ($server->physical_server_id != Input::get('physical_server_id')) 
                {
                    $new_server_name = '';
                    $new_server = Server::find(Input::get('physical_server_id'));
                    if ($new_server)
                    {
                        $new_server_name = $new_server->name;
                    }
                    
                    $old_server_name = '';
                    if (isset($server->physicalServer->name))
                    {
                        $old_server_name = $server->physicalServer->name;
                    }
                    $history[] = array(
                        'time' => $time,
                        'field' => 'Фізичний сервер',
                        'old_value' => $old_server_name,
                        'new_value' => $new_server_name,
                    );
                }
                if ($server->doc_name != Input::get('doc_name')) 
                {
                    $history[] = array(
                        'time' => $time,
                        'field' => 'Документ',
                        'old_value' => $server->doc_name,
                        'new_value' => Input::get('doc_name'),
                    );                    
                }
                if ($server->cpu != Input::get('cpu')) 
                {
                    $history[] = array(
                        'time' => $time,
                        'field' => 'CPU',
                        'old_value' => $server->cpu,
                        'new_value' => Input::get('cpu'),
                    );                    
                }
                if ($server->hdd != Input::get('hdd')) 
                {
                    $history[] = array(
                        'time' => $time,
                        'field' => 'HDD',
                        'old_value' => $server->hdd,
                        'new_value' => Input::get('hdd'),
                    );                    
                }
                if ($server->ram != Input::get('ram')) 
                {
                    $history[] = array(
                        'time' => $time,
                        'field' => 'RAM',
                        'old_value' => $server->ram,
                        'new_value' => Input::get('ram'),
                    );                    
                }
                if ($server->os != Input::get('os')) 
                {
                    $history[] = array(
                        'time' => $time,
                        'field' => 'ОС',
                        'old_value' => $server->os,
                        'new_value' => Input::get('os'),
                    );                    
                }
                if ($server->inventory_number != Input::get('inventory_number')) 
                {
                    $history[] = array(
                        'time' => $time,
                        'field' => 'Інв. номер',
                        'old_value' => $server->inventory_number,
                        'new_value' => Input::get('inventory_number'),
                    );                    
                }
                if ($server->serial_number != Input::get('serial_number')) 
                {
                    $history[] = array(
                        'time' => $time,
                        'field' => 'Серійний номер',
                        'old_value' => $server->serial_number,
                        'new_value' => Input::get('serial_number'),
                    );                    
                }
                if ($server->appointment != Input::get('appointment')) 
                {
                    $history[] = array(
                        'time' => $time,
                        'field' => 'Призначення',
                        'old_value' => $server->appointment,
                        'new_value' => Input::get('appointment'),
                    );                    
                }
                
                $server->name = Input::get('name');
                $server->model = Input::get('model');
                $server->ip = Input::get('ip');
                $server->start_date = Input::get('start_date') != NULL ? date('Y-m-d H:i:s', strtotime(Input::get('start_date'))) : NULL;
                $server->type_id = Input::get('type_id');
                if ($server->type_id  == 2)
                {
                    $server->physical_server_id = Input::get('physical_server_id');
                }
                else
                {
                    $server->physical_server_id = NULL;
                }
                $server->doc_name = Input::get('doc_name');
                $server->cpu = Input::get('cpu');
                $server->hdd = Input::get('hdd');
                $server->ram = Input::get('ram');
                $server->os = Input::get('os');
                $server->inventory_number = Input::get('inventory_number');
                $server->serial_number = Input::get('serial_number');
                $server->appointment = Input::get('appointment');
                if (!empty($history))
                {
                    if ($server->history)
                    {
                        $server->history = json_encode(array_merge(json_decode($server->history), $history));
                    }
                    else
                    {
                        $server->history = json_encode($history);
                    }
                }
                $server->save();
                $server->load('type');
                return Response::json(array('history' => json_decode($server->history), 'type' => $server->type->title));
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
        if (Input::get('type_id') == 2)
        {
            $rules['physical_server_id'] = 'exists:servers,id';
        }        
        $validator = Validator::make(Input::all(), $this->rules);
        $validator->setAttributeNames($this->niceNames); 
        
        if (!$validator->fails()) 
        {
            // Валидация прошла успешно
            $server = new Server;
            $server->name = Input::get('name');
            $server->model = Input::get('model');
            $server->ip = Input::get('ip');
            $server->start_date = Input::get('start_date') != NULL ? date('Y-m-d H:i:s', strtotime(Input::get('start_date'))) : NULL;
            $server->type_id = Input::get('type_id');
            if ($server->type_id == 2)
            {
                $server->physical_server_id = Input::get('physical_server_id');
            }
            $server->doc_name = Input::get('doc_name');
            $server->cpu = Input::get('cpu');
            $server->hdd = Input::get('hdd');
            $server->ram = Input::get('ram');
            $server->os = Input::get('os');
            $server->inventory_number = Input::get('inventory_number');
            $server->serial_number = Input::get('serial_number');
            $server->appointment = Input::get('appointment');
            $server->save();
            $insertedId = $server->id;

            if ($insertedId)
            {                
                $server->load('type');
                return Response::json(array('id' => $insertedId, 'type' => $server->type->title));
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