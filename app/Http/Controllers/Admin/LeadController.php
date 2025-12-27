<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PickupLead;
use Illuminate\View\View;

class LeadController extends Controller
{
    public function index(): View
    {
        $leads = PickupLead::orderByDesc('created_at')->paginate(20);
        return view('admin.leads.index', compact('leads'));
    }

    public function show(PickupLead $lead): View
    {
        return view('admin.leads.show', compact('lead'));
    }

    public function destroy(PickupLead $lead)
    {
        $lead->delete();
        return redirect()->back()->with('status', 'Лид удалён');
    }
}
