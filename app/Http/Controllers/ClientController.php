<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index()
    {
        $clients = Client::all();
        return view('clients.index', compact('clients'));
    }

    public function create()
    {
        return view('clients.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'last_name' => 'required|string|max:255',
            'first_name' => 'required|string|max:255',
            'address' => 'required|string|max:255'
        ], [
            'last_name.required' => 'Le nom est obligatoire.',
            'first_name.required' => 'Le prénom est obligatoire.',
            'address.required' => 'L\'adresse est obligatoire.',
        ]);

        Client::create($request->all());
        return redirect()->route('clients.index');
    }

    public function edit($id)
    {
        $client = Client::findOrFail($id);
        return view('clients.edit', compact('client'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'last_name' => 'required|string|max:255',
            'first_name' => 'required|string|max:255',
            'address' => 'required|string|max:255'
        ], [
            'last_name.required' => 'Le nom est obligatoire.',
            'first_name.required' => 'Le prénom est obligatoire.',
            'address.required' => 'L\'adresse est obligatoire.',
        ]);

        $client = Client::findOrFail($id);
        $client->update($request->all());
        return redirect()->route('clients.index');
    }

    public function destroy($id)
    {
        $client = Client::findOrFail($id);
        $client->delete();
        return redirect()->route('clients.index');
    }
}
