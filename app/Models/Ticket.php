<?php 

namespace Model;

class Ticket extends Model 
{
    protected static $table = 'tickets';

    public function setState(int $state)
    {
        $this->state_id = $state;
        $this->save();

        return true;
    }


    public function state()
    {
        return State::find($this->state_id);
    }

    public function service()
    {
        return Service::find($this->service_id);
    }
}
