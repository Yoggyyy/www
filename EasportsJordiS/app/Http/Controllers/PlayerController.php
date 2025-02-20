<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Player;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:30'],
            'social-media' => ['nullable', 'string'],
            'avatar' => ['nullable', 'image', 'max:20048'],
            'position' => ['required', 'string', 'max:20'],
            'age' => ['required', 'integer', 'min:10'],
            'victory' => ['required', 'string', 'max:10'],
            'team' => ['required', 'string', 'max:20'],
            'visible' => ['boolean']
        ]);

        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->store('avatars', 'public');
            $validated['avatar'] = $path;
        }

        Player::create($validated);

        return redirect()->route('players.index')->with('success', 'Jugador agregado correctamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(Player $player)
    {
        // if (Auth::user()->rol !== 'admin' && !$player->visible) {
        //     return redirect()->back();
        // }

        return view('players.show', compact('player'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Player $player)
    {
        if (Auth::user()->rol !== 'admin') {
            abort(403, 'Acceso no autorizado');
        }
        $validated = $request->validate([
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

        if ($request->hasFile('avatar')) {
            if ($player->avatar) {
                Storage::disk('public')->delete($player->avatar);
            }
            $path = $request->file('avatar')->store('avatars', 'public');
            $validated['avatar'] = $path;
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

        $validated = $request->validate([
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

        if ($request->hasFile('avatar')) {
            if ($player->avatar) {
                Storage::disk('public')->delete($player->avatar);
            }
            $path = $request->file('avatar')->store('avatars', 'public');
            $validated['avatar'] = $path;
        }

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
    public function destroy(Request $request, Player $player)
    {
        if (Auth::user()->rol !== 'admin') {
            abort(403, 'Acceso no autorizado');
        }

        if ($player->avatar) {
            if ($request->hasFile('avatar')) {
                if ($player->avatar) {
                    Storage::disk('public')->delete($player->avatar);
                }
                $path = $request->file('avatar')->store('avatars', 'public');
                $validated['avatar'] = $path;
            }
        }

        $player->delete();

        return redirect()->route('players.index')->with('success', 'Jugador eliminado correctamente');
    }
}
