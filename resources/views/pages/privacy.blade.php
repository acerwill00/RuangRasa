@extends('layouts.app')

@section('title', 'Privacy Policy | RASA Psychology')

@section('content')
<section class="py-24 bg-white min-h-[80vh]">
    <div class="max-w-4xl mx-auto px-6">
        <h1 class="text-4xl md:text-5xl font-bold mb-12 text-center text-text-main">Privacy Policy</h1>
        
        <div class="bg-slate-50 p-10 md:p-14 rounded-[2rem] border border-primary/20 shadow-soft">
            <p class="text-lg opacity-80 mb-10 leading-relaxed font-medium">Your privacy is our utmost priority. As a mental health tele-counseling platform, we employ rigorous security measures to ensure that your data is safe, protected, and strictly confidential.</p>
            
            <div class="space-y-10">
                <div>
                    <h3 class="text-2xl font-bold text-text-main mb-3 flex items-center gap-3">
                        <span class="w-8 h-8 rounded-full bg-primary/20 text-cta flex items-center justify-center font-bold text-sm">1</span>
                        Data Collection
                    </h3>
                    <p class="opacity-80 leading-relaxed text-lg">We only collect information strictly necessary to facilitate your counseling sessions, including your name, contact details, and essential scheduling preferences. All payment information is directly tokenized and securely handled by our third-party encrypted payment gateway.</p>
                </div>

                <div>
                    <h3 class="text-2xl font-bold text-text-main mb-3 flex items-center gap-3">
                        <span class="w-8 h-8 rounded-full bg-primary/20 text-cta flex items-center justify-center font-bold text-sm">2</span>
                        Session Confidentiality
                    </h3>
                    <p class="opacity-80 leading-relaxed text-lg">Your video calls directly with our psychologists are never recorded or stored on our servers under any context. The therapeutic space remains entirely private between you and your counselor.</p>
                </div>

                <div>
                    <h3 class="text-2xl font-bold text-text-main mb-3 flex items-center gap-3">
                        <span class="w-8 h-8 rounded-full bg-primary/20 text-cta flex items-center justify-center font-bold text-sm">3</span>
                        Data Sharing Restrictions
                    </h3>
                    <p class="opacity-80 leading-relaxed text-lg">We systematically vow never to sell or share your personal data with marketers, third-party advertisers, or outside entities. Sensitive information may only be legally disclosed under strict legal obligations or if there is an immediate threat to life.</p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
