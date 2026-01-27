<?php

namespace App\Http\Controllers\UserSide;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contact;
use App\Mail\ContactFormMail;
use App\Mail\ContactAutoReplyMail;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    // Show contact page
    public function index()
    {
        return view('contact');
    }

    // Store contact form
    public function submit(Request $request)
    {
        $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
            'phone'   => 'nullable|string|max:20',
        ]);

        // Save data safely
        $contact = Contact::create([
            'name'    => $request->name,
            'email'   => $request->email,
            'subject' => $request->subject,
            'message' => $request->message,
            'phone'   => $request->phone,
        ]);

        // Send email to admin
        try {
            Mail::to(config('mail.from.address'))
                ->send(new ContactFormMail(
                    $request->name,
                    $request->email,
                    $request->subject,
                    $request->message,
                    $request->phone
                ));

            // Send auto-reply to user
            Mail::to($request->email)
                ->send(new ContactAutoReplyMail($request->name));
                
        } catch (\Exception $e) {
            \Log::error('Email sending failed: ' . $e->getMessage());
        }

        return redirect()->back()->with('success', 'Message sent successfully!');
    }
}
