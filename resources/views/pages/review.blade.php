@extends('layouts.app')

@section('title', 'Leave a Review')

@section('content')
<div class="bg-secondary/10 py-16 min-h-[calc(100vh-80px)]">
    <div class="max-w-2xl mx-auto px-6">
        <div class="bg-white rounded-[2rem] shadow-soft border border-secondary/50 p-8 md:p-10">
            <h1 class="text-3xl font-bold text-text-main text-center mb-2">How was your session?</h1>
            <p class="text-slate-500 text-center mb-10">Your feedback helps {{ $appointment->psychologist->name }} and others in the community.</p>

            <form action="{{ route('appointment.review.store', $appointment) }}" method="POST" x-data="{ rating: 0, hoverRating: 0 }">
                @csrf

                {{-- Star Rating --}}
                <div class="flex flex-col items-center mb-10">
                    <div class="flex gap-2" @mouseleave="hoverRating = 0">
                        <template x-for="i in 5">
                            <button type="button" class="focus:outline-none transition-transform hover:scale-110"
                                @mouseenter="hoverRating = i"
                                @click="rating = i">
                                <svg class="w-12 h-12 transition-colors duration-150" 
                                    :class="(hoverRating >= i || (rating >= i && hoverRating == 0)) ? 'text-yellow-400' : 'text-slate-200'" 
                                    fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                            </button>
                        </template>
                    </div>
                    <input type="hidden" name="rating" x-model="rating" required>
                    @error('rating')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Review Text --}}
                <div class="mb-8">
                    <label for="review" class="block text-sm font-semibold text-text-main mb-2">Write your review <span class="text-slate-400 font-normal">(Optional)</span></label>
                    <textarea name="review" id="review" rows="4" 
                        class="w-full px-4 py-3 rounded-2xl bg-secondary/20 border border-secondary/50 focus:border-cta focus:bg-white transition-all text-sm resize-none"
                        placeholder="What did you like about the session? How did it help you?"></textarea>
                    @error('review')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end gap-3">
                    <a href="/dashboard" class="px-6 py-3 rounded-xl text-sm font-semibold text-slate-500 hover:bg-slate-100 transition-colors">Cancel</a>
                    <button type="submit" class="px-6 py-3 rounded-xl text-sm font-semibold bg-cta text-white hover:bg-cta-hover shadow-sm hover:shadow transition-all disabled:opacity-50"
                        x-bind:disabled="rating === 0">
                        Submit Review
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
