<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use App\Models\Lead;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tasks = Task::where(
            'tenant_id',
            auth()->user()->tenant_id
        )->latest()->get();

        return view(
            'tasks.index',
            compact('tasks')
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $leads = Lead::where(
                'tenant_id',
                auth()->user()->tenant_id
            )->get();

            return view(
                'tasks.create',
                compact('leads')
            );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Task::create([

            'tenant_id' => auth()->user()->tenant_id,

            'assigned_to' => auth()->id(),

            'title' => $request->title,
            'lead_id'=>$request->lead_id,

            'description' => $request->description,

            'due_date' => $request->due_date,

            'status' => 'Pending',
        ]);

        return redirect()
            ->route('tasks.index')
            ->with('success', 'Task Created');
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        abort_if(
            $task->tenant_id != auth()->user()->tenant_id,
            403
        );

        return view('tasks.edit', compact('task'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        abort_if(
            $task->tenant_id != auth()->user()->tenant_id,
            403
        );

        $task->update([
            'title' => $request->title,
            'description' => $request->description,
            'due_date' => $request->due_date,
            'status' => $request->status,
        ]);

        return redirect()
            ->route('tasks.index')
            ->with('success', 'Task Updated');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        abort_if(
            $task->tenant_id != auth()->user()->tenant_id,
            403
        );

        $task->delete();

        return redirect()
            ->route('tasks.index')
            ->with('success', 'Task Deleted');
    }
}
