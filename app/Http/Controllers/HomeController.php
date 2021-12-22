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
    public function editClient($id)
    {
        $client = PotentialClients::Where('id', $id)->firstOrFail();
        $data = request()->validate([
            'username' => 'required',
            'email' => 'required',
            'remarks' => 'required',
        ]);

       $client->update([
            'username' => $data['username'],
            'remarks' => $data['remarks'],
            'email' => $data['email'],            
            'assigned_to' => 'admin',
            'status'=> 'new'
        ]);

        return back()->with('success', 'Record updated successfully');
    }
    public function sendMassEmails()
    {
     
        $data = array('name'=>"Top skills Lab");
        Mail::send('email', $data, function($message) {
            $clients = PotentialClients::all();
            foreach($clients as $client){
            $message->to($client->email, $client->username)->subject
                ('This is a test email');
            $message->from('info@topskillsltd.com','Top skills Lab');
            }
        });
 
    
        return back()->with("success", 'Emails sent to your clients');

    }
}
