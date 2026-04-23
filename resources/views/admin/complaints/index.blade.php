@extends('layouts.app')

@section('title', 'Manage Complaints')

@section('content')
<div class="bg-secondary/10 py-10 min-h-[calc(100vh-80px)]">
    <div class="max-w-6xl mx-auto px-6">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold">Patient Complaints</h1>
            <a href="/admin/dashboard" class="px-5 py-2 bg-white border border-secondary hover:bg-secondary text-text-main rounded-xl font-medium transition-colors shadow-sm">
                ← Back to Dashboard
            </a>
        </div>

        @if(session('success'))
            <div class="mb-6 p-4 bg-green-100 text-green-700 rounded-xl font-medium">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white rounded-[2rem] shadow-soft border border-secondary/50 overflow-hidden">
            @if($complaints->isEmpty())
                <div class="p-8 text-center opacity-70">
                    No complaints reported.
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm">
                        <thead class="text-xs uppercase bg-secondary/50 text-text-main/70">
                            <tr>
                                <th scope="col" class="px-6 py-4 font-semibold">Patient</th>
                                <th scope="col" class="px-6 py-4 font-semibold">Subject</th>
                                <th scope="col" class="px-6 py-4 font-semibold">Description</th>
                                <th scope="col" class="px-6 py-4 font-semibold">Date</th>
                                <th scope="col" class="px-6 py-4 font-semibold text-center">Status</th>
                                <th scope="col" class="px-6 py-4 font-semibold text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-secondary/50">
                            @foreach($complaints as $c)
                            <tr class="hover:bg-secondary/10 transition-colors">
                                <td class="px-6 py-4 font-semibold whitespace-nowrap">
                                    {{ $c->user->name }}
                                </td>
                                <td class="px-6 py-4 font-medium">
                                    {{ $c->subject }}
                                    @if($c->appointment_id)
                                        <div class="text-[10px] opacity-60 mt-1">Apt ID: #{{ $c->appointment_id }}</div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 opacity-80 min-w-[250px]">
                                    {{ $c->description }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ $c->created_at->format('d M Y') }}
                                </td>
                                <td class="px-6 py-4 text-center whitespace-nowrap">
                                    @if($c->status === 'open')
                                        <span class="px-2 py-1 rounded text-[10px] font-bold uppercase bg-yellow-100 text-yellow-700">Open</span>
                                    @else
                                        <span class="px-2 py-1 rounded text-[10px] font-bold uppercase bg-green-100 text-green-700">Resolved</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-right whitespace-nowrap">
                                    @if($c->status === 'open')
                                        <form action="{{ route('admin.complaints.resolve', $c->id) }}" method="POST" class="inline" onsubmit="return confirm('Mark as resolved?');">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="text-cta hover:text-cta-hover font-semibold">Resolve</button>
                                        </form>
                                    @else
                                        <span class="opacity-50 text-xs font-semibold">Done</span>
                                    @endif
                                </td>
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
