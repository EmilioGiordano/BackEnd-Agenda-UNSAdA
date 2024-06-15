<?php

namespace App\Http\Controllers;

use App\Models\Statusname;
use Illuminate\Http\Request;

/**
 * Class StatusnameController
 * @package App\Http\Controllers
 */
class StatusnameController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $statusnames = Statusname::paginate();

        return view('statusname.index', compact('statusnames'))
            ->with('i', (request()->input('page', 1) - 1) * $statusnames->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $statusname = new Statusname();
        return view('statusname.create', compact('statusname'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate(Statusname::$rules);

        $statusname = Statusname::create($request->all());

        return redirect()->route('statusnames.index')
            ->with('success', 'Statusname created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $statusname = Statusname::find($id);

        return view('statusname.show', compact('statusname'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $statusname = Statusname::find($id);

        return view('statusname.edit', compact('statusname'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Statusname $statusname
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Statusname $statusname)
    {
        request()->validate(Statusname::$rules);

        $statusname->update($request->all());

        return redirect()->route('statusnames.index')
            ->with('success', 'Statusname updated successfully');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $statusname = Statusname::find($id)->delete();

        return redirect()->route('statusnames.index')
            ->with('success', 'Statusname deleted successfully');
    }
}
