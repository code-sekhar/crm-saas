<?php

namespace App\Http\Controllers;

use App\Models\FollowUp;
use Illuminate\Http\Request;
use App\Models\Activity;
use App\Models\Lead;

class FollowUpController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $followUps = FollowUp::where(
            'tenant_id',
            auth()->user()->tenant_id
        )->latest()->get();

        return view(
            'follow-ups.index',
            compact('followUps')
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $lead = Lead::where(
            'tenant_id',
            auth()->user()->tenant_id
        )->findOrFail($request->lead);

        return view(
            'follow-ups.create',
            compact('lead')
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'lead_id' => 'required|exists:leads,id',
            'follow_up_date' => 'required|date',
            'follow_up_time' => 'nullable',
            'remarks' => 'nullable|string',
        ]);

        FollowUp::create([

            'tenant_id' => auth()->user()->tenant_id,

            'lead_id' => $request->lead_id,

            'user_id' => auth()->id(),

            'follow_up_date' => $request->follow_up_date,

            'follow_up_time' => $request->follow_up_time,

            'remarks' => $request->remarks,
            'priority' => $request->priority,

            'status' => 'Pending',

        ]);

        return redirect()
            ->route('leads.show', $request->lead_id)
            ->with('success', 'Follow Up Added Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(FollowUp $followUp)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FollowUp $followUp)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, FollowUp $followUp)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FollowUp $followUp)
    {
        //
    }
}
