<?php

class HomeController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showMain');
	|
	*/

	public function showMain()
	{
            $data = array();
            
            $servers = Server::all();                
            $data['servers'] = array();
            foreach ($servers as $server)
            {
                $a = $server->toArray();
                $a['type'] = $server->type->title;
                $a['history'] = json_decode($server->history);
                $a['start_date'] = $a['start_date'] ? date('d.m.Y', strtotime($a['start_date'])) : '';
                $a['created_at'] = date('d.m.Y H:i:s', strtotime($a['created_at']));
                $a['updated_at'] = date('d.m.Y H:i:s', strtotime($a['updated_at']));
                $data['servers'][] = $a;
            }
            
            $users = User::all();                
            $data['users'] = array();
            foreach ($users as $user)
            {
                $a = $user->toArray();
                $a['created_at'] = date('d.m.Y H:i:s', strtotime($a['created_at']));
                $a['updated_at'] = date('d.m.Y H:i:s', strtotime($a['updated_at']));
                $data['users'][] = $a;
            }
            
            return View::make('main', array(
                    'servers' => json_encode($data['servers']),
                    'users' => json_encode($data['users']),
                )
            );
	}
}
