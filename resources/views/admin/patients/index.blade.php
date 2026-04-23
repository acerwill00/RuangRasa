@extends('layouts.app')

@section('title', 'Registered Patients')

@section('content')
<div class="bg-secondary/10 py-10 min-h-[calc(100vh-80px)]">
    <div class="max-w-6xl mx-auto px-6">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold">Registered Patients</h1>
            <a href="/admin/dashboard" class="px-5 py-2 bg-white border border-secondary hover:bg-secondary text-text-main rounded-xl font-medium transition-colors shadow-sm">
                ← Back to Dashboard
            </a>
        </div>

        <div class="bg-white rounded-[2rem] shadow-soft border border-secondary/50 overflow-hidden">
            @if($patients->isEmpty())
                <div class="p-8 text-center opacity-70">
                    No patients registered yet.
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm whitespace-nowrap">
                        <thead class="text-xs uppercase bg-secondary/50 text-text-main/70">
                            <tr>
                                <th scope="col" class="px-6 py-4 font-semibold">Patient Name</th>
                                <th scope="col" class="px-6 py-4 font-semibold">Email</th>
                                <th scope="col" class="px-6 py-4 font-semibold">Phone Number</th>
                                <th scope="col" class="px-6 py-4 font-semibold">Registered Date</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-secondary/50">
                            @foreach($patients as $p)
                            <tr class="hover:bg-secondary/10 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        @if($p->photo_url)
                                            <img src="{{ Storage::url($p->photo_url) }}" class="w-10 h-10 rounded-full object-cover">
                                        @else
                                            <div class="w-10 h-10 rounded-full bg-gradient-to-br from-primary to-cta flex items-center justify-center text-white font-bold text-sm shadow-sm">
                                                {{ strtoupper(substr($p->name, 0, 1)) }}
                                            </div>
                                        @endif
                                        <div class="font-semibold">{{ $p->name }}</div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">{{ $p->email }}</td>
                                <td class="px-6 py-4">{{ $p->phone ?: '-' }}</td>
                                <td class="px-6 py-4">{{ $p->created_at->format('d M Y, h:i A') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
