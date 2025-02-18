<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $events = Event::where('visible', true)->get();
        return view('events.index', compact('events'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (Auth::user()->rol !== 'admin') {
            abort(403, 'Acceso no autorizado');
        }
        return view('events.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (Auth::user()->rol !== 'admin') {
            abort(403, 'Acceso no autorizado');
        }

        $request->validate([
            'nombre' => ['required', 'string', 'max:30'],
            'descripcion' => ['required'],
            'ubicacion' => ['required'],
            'fecha_hora' => ['required', 'date'],
            'tipo' => ['required', 'in:official,exhibition,charity'],
            'etiquetas' => ['nullable', 'string'],
            'visible' => ['boolean']
        ]);

        Event::create($request->all());

        return redirect()->route('events.index')->with('success', 'Evento creado correctamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {
        return view('events.show', compact('event'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Event $event)
    {
        if (Auth::user()->rol !== 'admin') {
            abort(403, 'Acceso no autorizado');
        }
        return view('events.edit', compact('event'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Event $event)
    {
        if (Auth::user()->rol !== 'admin') {
            abort(403, 'Acceso no autorizado bobo');
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

        $event->update($request->all());

        return redirect()->route('events.index')->with('success', 'Evento actualizado correctamente');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        if (Auth::user()->rol !== 'admin') {
            abort(403, 'Acceso no autorizado');
        }

        $event->delete();
        return redirect()->route('events.index')->with('success', 'Evento eliminado correctamente');
    }

    public function toggleVisibility($id)
    {
        if (Auth::user()->rol !== 'admin') {
            abort(403, 'Acceso no autorizado');
        }

        $event = Event::findOrFail($id);
        $event->visible = !$event->visible;
        $event->save();

        return redirect()->route('events.index')->with('success', 'Visibilidad del evento actualizada');
    }

    public function likeEvent($id)
    {
        $event = Event::findOrFail($id);
        $user = Auth::user();

        if ($event->usersWhoLiked()->where('user_id', $user->id)->exists()) {
            $event->usersWhoLiked()->detach($user->id);
            return response()->json(['message' => 'Me gusta eliminado', 'liked' => false]);
        } else {
            $event->usersWhoLiked()->attach($user->id);
            return response()->json(['message' => 'Me gusta agregado', 'liked' => true]);
        }
    }
}
