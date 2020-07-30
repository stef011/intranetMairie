<?php 

namespace Model;

class Ticket extends Model 
{
    protected static $table = 'tickets';

    public function state()
    {
        return State::find($this->state_id);
    }
}
