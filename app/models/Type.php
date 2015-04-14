<?php

class Type extends Eloquent {

    protected $table = 'types';
    
    public function servers()
    {
        return $this->hasMany('Server');
    }
}