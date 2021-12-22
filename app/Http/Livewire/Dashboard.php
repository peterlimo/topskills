<?php

namespace App\Http\Livewire;
use App\Models\PotentialClients;


use Livewire\Component;

class Dashboard extends Component
{
    public function render()
    {
        $clients = PotentialClients::take(5)->get();
        return view('dashboard', compact('clients'));
    }
}
