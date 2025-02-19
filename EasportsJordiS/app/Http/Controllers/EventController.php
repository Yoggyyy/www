<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    public function index()
    {
        // Obtenemos solo los eventos visibles
        $events = Event::where('visible', true)
            ->orderBy('date', 'asc')
            ->get();
        return view('events.index', compact('events'));
    }

    public function create()
    {
        if (Auth::user()->rol !== 'admin') {
            abort(403, 'Acceso no autorizado');
        }
        return view('events.create');
    }

    public function store(Request $request)
    {
        if (Auth::user()->rol !== 'admin') {
            abort(403, 'Acceso no autorizado');
        }

        $request->validate([
            'name' => ['required', 'string', 'max:30'],
            'description' => ['required'],
            'location' => ['required'],
            'date' => ['required', 'date'],
            'hour' => ['required'],
            'type' => ['required', 'in:official,exhibition,charity'],
            'tags' => ['nullable', 'string'],
            'visible' => ['boolean']
        ]);

        Event::create($request->all());

        return redirect()->route('events.index')->with('success', 'Evento creado correctamente');
    }

    public function show(Event $event)
    {
        return view('events.show', compact('event'));
    }

    public function edit(Event $event)
    {
        if (Auth::user()->rol !== 'admin') {
            abort(403, 'Acceso no autorizado');
        }
        return view('events.edit', compact('event'));
    }

    public function update(Request $request, Event $event)
    {
        if (Auth::user()->rol !== 'admin') {
            abort(403, 'Acceso no autorizado');
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:30'],
            'description' => ['required', 'string'],
            'location' => ['required', 'string'],
            'date' => ['required', 'date'],
            'hour' => ['required', 'string'],
            'type' => ['required', 'in:official,exhibition,charity'],
            'tags' => ['nullable', 'string'],
            'visible' => ['boolean']
        ]);

        $event->update($validated);

        return redirect()->route('events.index')
            ->with('success', 'Evento actualizado correctamente');
    }

    public function destroy(Event $event)
    {
        if (Auth::user()->rol !== 'admin') {
            abort(403, 'Acceso no autorizado');
        }

        $event->delete();
        return redirect()->route('events.index')
            ->with('success', 'Evento eliminado correctamente');
    }

    public function toggleVisibility($id)
    {
        if (Auth::user()->rol !== 'admin') {
            abort(403, 'Acceso no autorizado');
        }

        $event = Event::findOrFail($id);
        $event->visible = !$event->visible;
        $event->save();

        return redirect()->route('events.index')
            ->with('success', 'Visibilidad del evento actualizada');
    }

    public function toggleLike($id)
    {
        $user = Auth::user();
        $event = Event::findOrFail($id);

        if ($event->likes()->where('user_id', $user->id)->exists()) {
            // Si el usuario ya dio like, lo elimina (dislike)
            $event->likes()->detach($user->id);
        } else {
            // Si el usuario no ha dado like, lo agrega
            $event->likes()->attach($user->id);
        }

        return redirect()->back();
    }
}
