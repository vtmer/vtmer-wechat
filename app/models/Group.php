<?php

class Group extends Eloquent {
    protected $table = 'group';
    protected $primaryKey = 'group_id';

    public $timestamps = false;

    public function user()
    {
        return $this->belongsToMany('User', 'user_group', 'group_id', 'open_id');
    }
}
