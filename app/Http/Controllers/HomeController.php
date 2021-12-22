<?php

namespace App\Http\Controllers;

use App\Models\PotentialClients;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class HomeController extends Controller
{
    public function potentialClients()
    {
        $clients = PotentialClients::all();
        return view('potential-clients', compact('clients'));
    }

    public function addClient()
    {
        $data = request()->validate([
            'username' => 'required',
            'email' => 'required',
            'remarks' => 'required',
        ]);

        PotentialClients::create([
            'username' => $data['username'],
            'remarks' => $data['remarks'],
            'email' => $data['email'],            
            'assigned_to' => 'admin',
            'status'=> 'new'
        ]);

        return back()->with('success', 'Client added successfully');
    }


    public function sendEmails() {
   
        $data = array('name'=>"Top skills Lab");
        Mail::send('email', $data, function($message) {
            $message->to('josephmwangi.jgm@gmail.com', 'Joseph mwangi')->subject
                ('This is a test email');
            $message->from('info@topskillsltd.com','Top skills Lab');
        });
        $clients = PotentialClients::all();
        return redirect()->route('potential.clients', ['clients' => $clients])->with("success", 'Emails sent to your clients');

    }
}
