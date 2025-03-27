<?php

namespace App\Http\Controllers;

use App\Models\Business;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function index()
    {
        $business = Business::first();
        return view('principal.home.contact', compact('business'));
    }

    public function store(Request $request)
    {
        // Validaciones con traducción
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|min:10',
        ], [], __('validation.attributes'));

        // Obtener la información del negocio
        $business = Business::first();

        if (!$business || !$business->email) {
            return redirect()->back()->with('error', 'No se pudo enviar el mensaje. Contacto no configurado.');
        }

        // Enviar correo
        Mail::send('emails.contact', ['data' => $request->all()], function ($message) use ($request, $business) {
            $message->to($business->email)
                ->subject('Nuevo Mensaje de Contacto')
                ->replyTo($request->email, $request->name);
        });

        return redirect()->back()->with('success', 'Su mensaje ha sido enviado correctamente.');
    }
}
