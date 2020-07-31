<?php

namespace App\Controllers;

use Model\Ticket;

class TicketController
{
    public function setState($params)
    {
        $id = $params['0'];
        $state = $params['1'];
        $ticket = Ticket::find($id);
        $ticket->setState($state);

        header('Location: ' . route('admin.tickets'));
    }
}
