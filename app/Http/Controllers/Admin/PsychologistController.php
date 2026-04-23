<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Psychologist;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class PsychologistController extends Controller
{
    public function index()
    {
        $psychologists = Psychologist::all();
        return view('admin.psychologists.index', compact('psychologists'));
    }

    public function create()
    {
        return view('admin.psychologists.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'specialization' => 'required|string|max:255',
            'price_per_session' => 'required|numeric|min:0',
            'bio' => 'nullable|string',
            'photo' => 'nullable|image|max:2048',
        ]);

        $data = $validated;
        $data['slug'] = Str::slug($validated['name']) . '-' . Str::random(5);

        if ($request->hasFile('photo')) {
            $data['photo_url'] = $request->file('photo')->store('psychologists', 'public');
        }

        Psychologist::create($data);

        return redirect('/admin/psychologists')->with('success', 'Psychologist added successfully.');
    }

    public function edit(Psychologist $psychologist)
    {
        return view('admin.psychologists.edit', compact('psychologist'));
    }

    public function update(Request $request, Psychologist $psychologist)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'specialization' => 'required|string|max:255',
            'price_per_session' => 'required|numeric|min:0',
            'bio' => 'nullable|string',
            'photo' => 'nullable|image|max:2048',
        ]);

        $data = $validated;
        
        if ($request->name !== $psychologist->name) {
            $data['slug'] = Str::slug($validated['name']) . '-' . Str::random(5);
        }

        if ($request->hasFile('photo')) {
            if ($psychologist->photo_url) {
                Storage::disk('public')->delete($psychologist->photo_url);
            }
            $data['photo_url'] = $request->file('photo')->store('psychologists', 'public');
        }

        $psychologist->update($data);

        return redirect('/admin/psychologists')->with('success', 'Psychologist updated successfully.');
    }

    public function destroy(Psychologist $psychologist)
    {
        if ($psychologist->photo_url) {
            Storage::disk('public')->delete($psychologist->photo_url);
        }
        $psychologist->delete();

        return redirect('/admin/psychologists')->with('success', 'Psychologist deleted successfully.');
    }
}
