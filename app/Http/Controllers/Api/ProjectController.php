<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;

class ProjectController extends Controller
{
    public function index(Request $request)
    {
        $query = Project::query();

        if ($request->has('name')) {
            $query->where('name', $request->name);
        }

        if ($request->has('department')) {
            $query->where('department', $request->department);
        }

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        if ($request->has('start_date')) {
            $query->where('start_date', $request->start_date);
        }

        if ($request->has('end_date')) {
            $query->where('end_date', $request->end_date);
        }

        return response()->json($query->get());
    }

    public function show($id)
    {
        return response()->json(Project::find($id));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'department' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'status' => 'required|string|in:not started,in progress,completed',
        ]);

        $project = Project::create($request->all());

        return response()->json($project, 201);
    }

    public function update(Request $request)
    {
        $project = Project::findOrFail($request->id);

        $project->update($request->all());

        return response()->json($project, 200);
    }

    public function destroy(Request $request)
    {
        $project = Project::findOrFail($request->id);
        $project->delete();

        return response()->json(null, 204);
    }
}

