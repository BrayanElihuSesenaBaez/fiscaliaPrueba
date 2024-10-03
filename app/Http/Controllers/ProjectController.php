<?php

namespace App\Http\Controllers;

use App\Models\Project;

use Illuminate\Http\Request;


class ProjectController extends Controller
{

    public function index()
    {
        return view('reports.index', [
            'reports' => Project::latest()->paginate()
        ]);
    }

    public function show(Project $project)
    {

        return view('reports.show', [
           'project' => $project
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
