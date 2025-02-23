<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Group;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    public function index()
    {
        $groups = Group::with('client')->get();
        $clients = Client::all();
        return view('groups.index', compact('groups', 'clients'));
    }

    public function create()
    {
        $clients = Client::all();
        return view('groups.create', compact('clients'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'number_of_people' => 'required|integer|min:1',
            'client_id' => 'required|exists:clients,id'
        ], [
            'number_of_people.required' => 'Le nombre de personnes est obligatoire.',
            'client_id.required' => 'Le client est obligatoire.',
            'client_id.exists' => 'Le client sélectionné est invalide.'
        ]);

        Group::create($request->all());
        return redirect()->route('groups.index');
    }

    public function edit($id)
    {
        $group = Group::findOrFail($id);
        $clients = Client::all();
        return view('groups.edit', compact('group', 'clients'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'number_of_people' => 'required|integer|min:1',
            'client_id' => 'required|exists:clients,id'
        ], [
            'number_of_people.required' => 'Le nombre de personnes est obligatoire.',
            'client_id.required' => 'Le client est obligatoire.',
            'client_id.exists' => 'Le client sélectionné est invalide.'
        ]);

        $group = Group::findOrFail($id);
        $group->update($request->all());
        return redirect()->route('groups.index');
    }

    public function destroy($id)
    {
        $group = Group::findOrFail($id);
        $group->delete();
        return redirect()->route('groups.index');
    }
}
