<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Player;
use Illuminate\Support\Facades\Auth;

class PlayerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $players = Player::where('visible', true)->get();
        return view('players.index', compact('players'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (Auth::user()->rol !== 'admin') {
            abort(403, 'Acceso no autorizado');
        }
        return view('players.create');
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
            'name' => ['required', 'string', 'max:30'],
            'twitter' => ['nullable', 'string'],
            'instagram' => ['nullable', 'string'],
            'twitch' => ['nullable', 'string'],
            'avatar' => ['nullable', 'string'],
            'position' => ['required', 'string', 'max:20'],
            'age' => ['required', 'integer', 'min:10'],
            'victory' => ['required', 'string', 'max:10'],
            'team' => ['required', 'string', 'max:20'],
            'visible' => ['boolean']
        ]);

        Player::create($request->all());

        return redirect()->route('players.index')->with('success', 'Jugador agregado correctamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(Player $player)
    {
        return view('players.show', compact('player'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Player $player)
    {
        if (Auth::user()->rol !== 'admin') {
            abort(403, 'Acceso no autorizado');
        }
        return view('players.edit', compact('player'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Player $player)
    {
        if (Auth::user()->rol !== 'admin') {
            abort(403, 'Acceso no autorizado');
        }

        $request->validate([
            'name' => ['required', 'string', 'max:30'],
            'twitter' => ['nullable', 'string'],
            'instagram' => ['nullable', 'string'],
            'twitch' => ['nullable', 'string'],
            'avatar' => ['nullable', 'string'],
            'position' => ['required', 'string', 'max:20'],
            'age' => ['required', 'integer', 'min:10'],
            'victory' => ['required', 'string', 'max:10'],
            'team' => ['required', 'string', 'max:20'],
            'visible' => ['boolean']
        ]);

        $player->update($request->all());

        return redirect()->route('players.index')->with('success', 'Jugador actualizado correctamente');
    }

    /**
     * Toggle player visibility.
     */
    public function toggleVisibility(Player $player)
    {
        if (Auth::user()->rol !== 'admin') {
            abort(403, 'Acceso no autorizado');
        }

        $player->visible = !$player->visible;
        $player->save();

        return back()->with('success', 'Visibilidad actualizada');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Player $player)
    {
        if (Auth::user()->rol !== 'admin') {
            abort(403, 'Acceso no autorizado');
        }

        $player->delete();
        return redirect()->route('players.index')->with('success', 'Jugador eliminado correctamente');
    }
}

