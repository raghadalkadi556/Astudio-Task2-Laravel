<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Timesheet;

class TimesheetController extends Controller
{
    public function index(Request $request)
    {
        $query = Timesheet::query();

        if ($request->has('task_name')) {
            $query->where('task_name', $request->task_name);
        }

        if ($request->has('date')) {
            $query->where('date', $request->date);
        }

        if ($request->has('hours')) {
            $query->where('hours', $request->hours);
        }

        if ($request->has('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->has('project_id')) {
            $query->where('project_id', $request->project_id);
        }

        return response()->json($query->get());
    }

    public function show($id)
    {
        return response()->json(Timesheet::find($id));
    }

    public function store(Request $request)
    {
        $request->validate([
            'task_name' => 'required|string|max:255',
            'date' => 'required|date',
            'hours' => 'required|integer',
            'user_id' => 'required|exists:users,id',
            'project_id' => 'required|exists:projects,id',
        ]);

        $timesheet = Timesheet::create($request->all());

        return response()->json($timesheet, 201);
    }

    public function update(Request $request)
    {
        $timesheet = Timesheet::findOrFail($request->id);

        $timesheet->update($request->all());

        return response()->json($timesheet, 200);
    }

    public function destroy(Request $request)
    {
        $timesheet = Timesheet::findOrFail($request->id);
        $timesheet->delete();

        return response()->json(null, 204);
    }
}

