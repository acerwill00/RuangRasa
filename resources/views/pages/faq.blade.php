@extends('layouts.app')

@section('title', 'FAQ | RASA Psychology')

@section('content')
<section class="py-24 bg-slate-50 min-h-[80vh]">
    <div class="max-w-4xl mx-auto px-6">
        <div class="text-center mb-16">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Frequently Asked Questions</h1>
            <p class="text-lg opacity-80">Find answers to common questions about our counseling process.</p>
        </div>

        <div class="space-y-6">
            <div class="bg-white p-8 rounded-2xl shadow-sm border border-slate-100 hover:shadow-md transition-shadow">
                <h3 class="text-xl font-bold text-text-main mb-3">How do I book a session?</h3>
                <p class="opacity-80 text-lg leading-relaxed">You can book a session by navigating to "Our Psychologist" in the navigation bar, finding a professional that aligns with your needs, and clicking on any available schedule directly from their card or profile.</p>
            </div>
            
            <div class="bg-white p-8 rounded-2xl shadow-sm border border-slate-100 hover:shadow-md transition-shadow">
                <h3 class="text-xl font-bold text-text-main mb-3">Are my sessions confidential?</h3>
                <p class="opacity-80 text-lg leading-relaxed">Absolutely. All sessions are strictly confidential and strictly follow the ethical code established by HIMPSI. Video sessions are peer-to-peer and nothing is legally recorded or shared without your explicit, written consent.</p>
            </div>

            <div class="bg-white p-8 rounded-2xl shadow-sm border border-slate-100 hover:shadow-md transition-shadow">
                <h3 class="text-xl font-bold text-text-main mb-3">What happens if I need to cancel my appointment?</h3>
                <p class="opacity-80 text-lg leading-relaxed">You can seamlessly reschedule or cancel your appointment up to 24 hours in advance at no cost through your dashboard. Cancellations made within 24 hours may incur a small operational fee.</p>
            </div>
            
            <div class="bg-white p-8 rounded-2xl shadow-sm border border-slate-100 hover:shadow-md transition-shadow">
                <h3 class="text-xl font-bold text-text-main mb-3">How do online sessions work?</h3>
                <p class="opacity-80 text-lg leading-relaxed">Once you finalize your booking, you will receive a secure video consultation link in your email and on your profile dashboard. Simply click the link 5 minutes before your scheduled time to enter the secure room.</p>
            </div>
        </div>
    </div>
</section>
@endsection
