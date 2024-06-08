<?php

namespace App\Http\Controllers;

use App\Models\Prerequisite;
use Illuminate\Http\Request;
use App\Models\Course;

/**
 * Class PrerequisiteControllerView
 * @package App\Http\Controllers
 */
class PrerequisiteControllerView extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $prerequisites = Prerequisite::paginate();

        return view('prerequisite.index', compact('prerequisites'))
            ->with('i', (request()->input('page', 1) - 1) * $prerequisites->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $prerequisite = new Prerequisite();
        return view('prerequisite.create', compact('prerequisite'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate(Prerequisite::$rules);

        $prerequisite = Prerequisite::create($request->all());

        return redirect()->route('prerequisites.index')
            ->with('success', 'Prerequisite created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $prerequisite = Prerequisite::find($id);

        return view('prerequisite.show', compact('prerequisite'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $prerequisite = Prerequisite::find($id);

        return view('prerequisite.edit', compact('prerequisite'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Prerequisite $prerequisite
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Prerequisite $prerequisite)
    {
        request()->validate(Prerequisite::$rules);

        $prerequisite->update($request->all());

        return redirect()->route('prerequisites.index')
            ->with('success', 'Prerequisite updated successfully');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $prerequisite = Prerequisite::find($id)->delete();

        return redirect()->route('prerequisites.index')
            ->with('success', 'Prerequisite deleted successfully');
    }
}
