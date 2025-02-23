<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePonyRequest;
use App\Models\Pony;
use App\Models\PonyBreak;
use Illuminate\Http\Request;

/*class PonyController extends Controller
{
    public function index()
    {
        $ponies = Pony::all();
        return view('ponies.index', compact('ponies'));
    }

    public function create()
    {
        return view('ponies.create');
    }

    public function store(Request $request)
    {
        Pony::create($request->all());
        return redirect()->route('ponies.index');
    }

    public function edit($id)
    {
        $pony = Pony::findOrFail($id);
        return view('ponies.edit', compact('pony'));
    }

    public function update(Request $request, $id)
    {
        $pony = Pony::findOrFail($id);
        $pony->update($request->all());
        return redirect()->route('ponies.index');
    }

    public function destroy($id)
    {
        $pony = Pony::findOrFail($id);
        $pony->delete();
        return redirect()->route('ponies.index');
    }
}*/


class PonyController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', Pony::class);
        $ponies = Pony::with('appointments')->get();
        //dd($ponies);
        return view('ponies.index', compact('ponies'));

    }

    public function create()
    {
        $this->authorize('create', Pony::class);

        return view('ponies.create');
    }

    public function show($id)
    {
        $pony = Pony::find($id);
        $workingHours = $pony->working_hours;

        return view('ponies.show', compact('pony', 'workingHours'));
    }


    public function store(StorePonyRequest $request)
    {
        $this->authorize('create', Pony::class);
        $pony = Pony::create($request->validated());
        $this->scheduleBreaks($pony);

        return redirect()->route('ponies.index');
    }

    public function edit($id)
    {
        $pony = Pony::findOrFail($id);
        $this->authorize('update', $pony);
        return view('ponies.edit', compact('pony'));
    }


    public function update(StorePonyRequest $request, $id)
    {
        $pony = Pony::findOrFail($id);
        $this->authorize('update', $pony);
        $pony->update($request->validated());
        $this->scheduleBreaks($pony);

        return redirect()->route('ponies.index');
    }

    public function destroy($id)
    {
        $pony = Pony::findOrFail($id);
        $this->authorize('delete', $pony);
        $pony->delete();
        return redirect()->route('ponies.index');
    }

}
