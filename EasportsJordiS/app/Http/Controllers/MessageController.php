<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::user()->rol !== 'admin') {
            abort(403, 'Acceso no autorizado');
        }

        $messages = Message::latest()->get();
        return view('messages.index', compact('messages'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => ['required', 'string', 'max:30'],
                'subject' => ['required', 'string', 'max:100'],
                'text' => ['required', 'string']
            ]);
            $request['readed'] = 0;

            Message::create($request->all());
            return redirect()->route('contact')->with('success', 'Mensaje enviado correctamente');
        } catch (\Throwable $error) {
            return redirect()->route('contact')->with('error', $error->getMessage());
        }


    }

    /**
     * Display the specified resource.
     */
    public function show(Message $message)
    {
        if (Auth::user()->rol !== 'admin') {
            abort(403, 'Acceso no autorizado');
        }

        if (!$message->readed) {
            $message->readed = true;
            $message->save();
        }

        return view('messages.show', compact('message'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Message $message)
    {
        if (Auth::user()->rol !== 'admin') {
            abort(403, 'Acceso no autorizado');
        }

        $request->validate([
            'asunto' => ['required', 'string', 'max:100'],
            'texto' => ['required', 'string']
        ]);

        $message->update($request->all());

        return redirect()->route('messages.index')->with('success', 'Mensaje actualizado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Message $message)
    {
        if (Auth::user()->rol !== 'admin') {
            abort(403, 'Acceso no autorizado');
        }

        $message->delete();
        return redirect()->route('messages.index')->with('success', 'Mensaje eliminado correctamente');
    }
}
