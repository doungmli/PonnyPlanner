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
        $ponies = Pony::with('appointments')->get();
        //dd($ponies);
        return view('ponies.index', compact('ponies'));

        /*  $ponies = Pony::all();
          return view('ponies.index', compact('ponies'));*/
    }

    public function create()
    {
        return view('ponies.create');
    }

    public function show($id)
    {
        $pony = Pony::find($id);
        $workingHours = $pony->working_hours;

        return view('ponies.show', compact('pony', 'workingHours'));
    }

/*    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'max_working_hours' => 'required|integer|min:1'
        ], [
            'name.required' => 'Le nom est obligatoire.',
            'max_working_hours.required' => 'Les heures de travail max sont obligatoires.'
        ]);

        Pony::create($request->all());
        return redirect()->route('ponies.index');
    }*/

    public function store(StorePonyRequest $request)
    {
        $pony = Pony::create($request->validated());
        $this->scheduleBreaks($pony);

        return redirect()->route('ponies.index');
    }

    public function edit($id)
    {
        $pony = Pony::findOrFail($id);
        return view('ponies.edit', compact('pony'));
    }

/*    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'max_working_hours' => 'required|integer|min:1'
        ], [
            'name.required' => 'Le nom est obligatoire.',
            'max_working_hours.required' => 'Les heures de travail max sont obligatoires.'
        ]);

        $pony = Pony::findOrFail($id);
        $pony->update($request->all());
        return redirect()->route('ponies.index');
    }*/

    public function update(StorePonyRequest $request, $id)
    {
        $pony = Pony::findOrFail($id);
        $pony->update($request->validated());
        $this->scheduleBreaks($pony);

        return redirect()->route('ponies.index');
    }

    public function destroy($id)
    {
        $pony = Pony::findOrFail($id);
        $pony->delete();
        return redirect()->route('ponies.index');
    }

    private function scheduleBreaks(Pony $pony)
    {
        PonyBreak::where('pony_id', $pony->id)->delete();
        $workingHours = $pony->max_working_hours;
        $currentTime = now();

        while ($workingHours > 0) {
            // Planification des heures de travail
            if ($workingHours >= 2) {
                $startTime = $currentTime;
                $endTime = $currentTime->copy()->addHours(2);
                $currentTime = $endTime->copy()->addMinutes(15); // Ajouter 15 minutes de pause
                $workingHours -= 2;
            } else {
                $startTime = $currentTime;
                $endTime = $currentTime->copy()->addHours($workingHours);
                $currentTime = $endTime;
                $workingHours = 0;
            }

            // Enregistrement de la pause
            PonyBreak::create([
                'pony_id' => $pony->id,
                'start_time' => $startTime,
                'end_time' => $endTime
            ]);
        }
    }
}
