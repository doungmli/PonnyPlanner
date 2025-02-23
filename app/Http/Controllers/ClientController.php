<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', Client::class);
        $clients = Client::all();
        return view('clients.index', compact('clients'));
    }

    public function create()
    {
        $this->authorize('create', Client::class);
        return view('clients.create');
    }

    public function store(Request $request)
    {
        $this->authorize('create', Client::class);
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
        $this->authorize('update', $client);
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
        $this->authorize('update', $client);
        $client->update($request->all());
        return redirect()->route('clients.index');
    }

    public function destroy($id)
    {
        $client = Client::findOrFail($id);
        $this->authorize('delete', $client);
        $client->delete();
        return redirect()->route('clients.index');
    }
}
