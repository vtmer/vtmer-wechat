<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {

    use UserTrait, RemindableTrait;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'user';

    protected $primaryKey = 'open_id';

    public function groups()
    {
        return $this->belongsToMany('Group', 'user_group', 'open_id', 'group_id');
    }

    public function is_in_group_by_id($group_id)
    {
        return $this->groups->contains($group_id);
    }

    public function is_in_group_by_name($group_name)
    {
        $group = Group::where('name', '=', $group_name)->first();
        return $this->is_in_group_by_id($group->group_id);
    }

    public function join_group_by_id($group_id)
    {
        $this->groups()->attach($group_id);
    }

    public function join_group_by_name($group_name)
    {
        $group = Group::where('name', '=', $group_name)->first();
        if ($group) {
            $this->join_group_by_id($group->group_id);
        }
    }
}
