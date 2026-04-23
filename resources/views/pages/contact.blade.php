@extends('layouts.app')

@section('title', 'Contact Us | RASA Psychology')

@section('content')
<section class="py-24 bg-slate-50 min-h-[80vh]">
    <div class="max-w-6xl mx-auto px-6 grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
        
        <div>
            <h1 class="text-4xl md:text-5xl font-bold mb-6 text-text-main">Get in Touch</h1>
            <p class="opacity-80 text-lg mb-12 leading-relaxed max-w-lg">Whether you have questions about our booking process or need help picking the perfectly aligned psychologist, our empathetic support team is ready to guide you.</p>
            
            <div class="space-y-8">
                <div class="flex flex-col">
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-2 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        Email Us
                    </span>
                    <a href="mailto:support@rasapsychology.com" class="text-2xl font-bold text-cta hover:text-cta-hover transition-colors">support@rasapsychology.com</a>
                </div>
                
                <div class="flex flex-col">
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-2 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                        Call Us
                    </span>
                    <p class="text-2xl font-bold text-text-main">+62 895-3396-69579</p>
                </div>
                
                <div class="flex flex-col pt-6 border-t border-slate-200">
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-2 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Active Support Hours
                    </span>
                    <p class="text-lg opacity-80 font-medium">Monday - Friday: 08:00 - 17:00 WIB</p>
                </div>
            </div>
        </div>

        <div class="bg-white p-8 md:p-12 rounded-[2rem] shadow-soft border border-primary/20 relative">
            <div class="absolute -top-6 -right-6 w-24 h-24 bg-primary/20 rounded-full blur-2xl -z-10"></div>
            <h3 class="text-3xl font-bold mb-8">Send a Message</h3>
            
            <form action="#" class="space-y-6">
                <div>
                    <label class="block text-sm font-bold text-text-main mb-2">Your Name</label>
                    <input type="text" class="w-full px-5 py-4 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:outline-none focus:ring-4 focus:ring-primary/20 focus:border-cta transition-all text-base" placeholder="John Doe">
                </div>
                <div>
                    <label class="block text-sm font-bold text-text-main mb-2">Email Address</label>
                    <input type="email" class="w-full px-5 py-4 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:outline-none focus:ring-4 focus:ring-primary/20 focus:border-cta transition-all text-base" placeholder="john@example.com">
                </div>
                <div>
                    <label class="block text-sm font-bold text-text-main mb-2">Message</label>
                    <textarea rows="5" class="w-full px-5 py-4 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:outline-none focus:ring-4 focus:ring-primary/20 focus:border-cta transition-all text-base" placeholder="How can we help you today?"></textarea>
                </div>
                <button type="submit" class="w-full py-4 bg-cta hover:bg-cta-hover text-white rounded-xl font-bold text-lg shadow-sm hover:shadow active:scale-95 transition-all flex items-center justify-center gap-2">
                    Send Message
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </button>
            </form>
        </div>

    </div>
</section>
@endsection
