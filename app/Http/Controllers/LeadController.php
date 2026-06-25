<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use Illuminate\Http\Request;


class LeadController extends Controller
{
    /**
     * Display a listing of the resource.
     */
     public function index()
    {
        $leads = Lead::where(
            'tenant_id',
            auth()->user()->tenant_id
        )->latest()->get();

        return view(
            'leads.index',
            compact('leads')
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('leads.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Lead::create([
            'tenant_id' => auth()->user()->tenant_id,

            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'source' => $request->source,

            'status' => 'New',
        ]);

        return redirect()
            ->route('leads.index')
            ->with('success', 'Lead Created');
    }

    /**
     * Display the specified resource.
     */
    public function show(Lead $lead)
    {
        abort_if(
            $lead->tenant_id != auth()->user()->tenant_id,
            403
        );
        $lead->load(['tasks']);

        return view('leads.show', compact('lead'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Lead $lead)
    {
        abort_if(
            $lead->tenant_id != auth()->user()->tenant_id,
            403
        );

        return view('leads.edit', compact('lead'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Lead $lead)
    {
        abort_if(
            $lead->tenant_id != auth()->user()->tenant_id,
            403
        );

        $lead->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'source' => $request->source,
            'status' => $request->status,
        ]);

        return redirect()->route('leads.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Lead $lead)
    {
        abort_if(
            $lead->tenant_id != auth()->user()->tenant_id,
            403
        );

        $lead->delete();

        return redirect()
            ->route('leads.index')
            ->with('success', 'Lead Deleted');
    }
}
