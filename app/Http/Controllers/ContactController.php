<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function index()
    {
        return view('contact.index');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|max:20',
            'subject' => 'required|max:255',
            'message' => 'required|max:2000',
        ]);

        // Tutaj możesz dodać wysyłanie emaila
        // Mail::to('kontakt@polskatour.pl')->send(new ContactMail($validated));

        // Dla teraz zapisujemy do bazy danych
        \App\Models\ContactMessage::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'subject' => $validated['subject'],
            'message' => $validated['message'],
            'status' => 'new'
        ]);

        return redirect()->back()->with('success', 'Dziękujemy za wiadomość! Odpowiemy w ciągu 24 godzin.');
    }
}
