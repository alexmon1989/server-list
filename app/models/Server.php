<?php

/**
 * Модель для управления серверами
 */
class Server extends Eloquent {

    protected $table = 'servers';
    
    /**
     * Тип сервера
     */
    public function type()
    {
        return $this->belongsTo('Type');
    }
    
    /**
     * Родительский сервер (если сервер виртуальный)
     */
    public function physicalServer()
    {
        return $this->belongsTo('Server', 'physical_server_id');
    }
    
    /**
     * Дочерние виртуальные сервера
     */
    public function virtualServers()
    {
        return $this->hasMany('Server', 'physical_server_id');
    }
}