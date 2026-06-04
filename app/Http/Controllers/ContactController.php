<?php

namespace App\Http\Controllers;

use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\SEOMeta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function index()
    {
        SEOMeta::setTitle('Hubungi Kami - Delix Studio');
        SEOMeta::setDescription('Ada pertanyaan atau butuh bantuan? Hubungi tim Delix Studio, kami siap membantu.');
        SEOMeta::setCanonical(url('/contact'));

        OpenGraph::setTitle('Hubungi Kami - Delix Studio');
        OpenGraph::setDescription('Ada pertanyaan atau butuh bantuan? Hubungi tim Delix Studio.');
        OpenGraph::setUrl(url('/contact'));

        return view('pages.contact');
    }

    public function send(Request $request)
    {
        $request->validate([
            'name'    => 'required|string|max:100',
            'email'   => 'required|email',
            'subject' => 'required|string|max:200',
            'message' => 'required|string|min:10',
        ], [
            'name.required'    => 'Nama wajib diisi.',
            'name.string'      => 'Nama harus berupa teks.',
            'name.max'         => 'Nama maksimal 100 karakter.',
            'email.required'   => 'Email wajib diisi.',
            'email.email'      => 'Format email tidak valid.',
            'subject.required' => 'Subjek wajib diisi.',
            'subject.string'   => 'Subjek harus berupa teks.',
            'subject.max'      => 'Subjek maksimal 200 karakter.',
            'message.required' => 'Pesan wajib diisi.',
            'message.string'   => 'Pesan harus berupa teks.',
            'message.min'      => 'Pesan minimal 10 karakter.',
        ]);

        Mail::send('emails.contact', [
            'name'           => $request->name,
            'email'          => $request->email,
            'subject'        => $request->subject,
            'messageContent' => $request->message,
        ], function ($mail) use ($request) {
            $mail->to(config('mail.from.address'))
                ->replyTo($request->email, $request->name)
                ->subject("[Kontak] {$request->subject}");
        });

        return back()->with('success', 'Pesan kamu berhasil dikirim! Kami akan membalas segera.');
    }
}
