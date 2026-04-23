@extends('layouts.app')

@section('title', 'Manage Psychologists')

@section('content')
<div class="bg-secondary/10 py-10 min-h-[calc(100vh-80px)]">
    <div class="max-w-6xl mx-auto px-6">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold">Psychologists Directory</h1>
            <a href="/admin/psychologists/create" class="px-5 py-2 bg-cta hover:bg-cta-hover text-white rounded-xl font-medium transition-colors shadow-sm">
                + Add New
            </a>
        </div>

        @if(session('success'))
            <div class="mb-6 p-4 bg-green-100 text-green-700 rounded-xl font-medium">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white rounded-[2rem] shadow-soft border border-secondary/50 overflow-hidden">
            @if($psychologists->isEmpty())
                <div class="p-8 text-center opacity-70">
                    No psychologists found. Add one to get started.
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm whitespace-nowrap">
                        <thead class="text-xs uppercase bg-secondary/50 text-text-main/70">
                            <tr>
                                <th scope="col" class="px-6 py-4 font-semibold">Name</th>
                                <th scope="col" class="px-6 py-4 font-semibold">Specialization</th>
                                <th scope="col" class="px-6 py-4 font-semibold">Price</th>
                                <th scope="col" class="px-6 py-4 font-semibold text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-secondary/50">
                            @foreach($psychologists as $p)
                            <tr class="hover:bg-secondary/10 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <img src="{{ asset('img/prof-pic.jpeg') }}" class="w-10 h-10 rounded-full object-cover">
                                        <div class="font-semibold">{{ $p->name }}</div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">{{ $p->specialization }}</td>
                                <td class="px-6 py-4">Rp {{ number_format($p->price_per_session, 0, ',', '.') }}</td>
                                <td class="px-6 py-4 text-right">
                                    <a href="/admin/psychologists/{{ $p->id }}/edit" class="text-cta hover:text-cta-hover font-semibold mr-3">Edit</a>
                                    <form action="/admin/psychologists/{{ $p->id }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700 font-semibold">Delete</button>
                                    </form>
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
