<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use Illuminate\Http\Request;

class ComplaintController extends Controller
{
    public function index()
    {
        $complaints = Complaint::with(['user', 'appointment'])
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('admin.complaints.index', compact('complaints'));
    }

    public function resolve(Complaint $complaint)
    {
        $complaint->update(['status' => 'resolved']);
        return back()->with('success', 'Complaint marked as resolved.');
    }
}
