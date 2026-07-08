<?php

namespace App\Http\Controllers;

use App\Models\Consulter;
use App\Models\Medicament;
use App\Models\Prescrire;
use Illuminate\Http\Request;

class PrescrireController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $prescrires = Prescrire::all();
        return view('page.prescrires.index', compact('prescrires'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $medicaments  = Medicament::all();
        $consulters  = Consulter::all();

        return view('page.prescrires.create', compact('medicaments','consulters'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'medicament_id'=> 'required|exists:medicaments,id',
            'consulter_id'=> 'required|exists:consulters,id',
            'posologie'=> 'required|string',
            'duree'=> 'required|string',
        ]);
        Prescrire::create($validated);
        return redirect()->route('prescrires.index')->with('success','la prescription à été crée avec succès');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $prescrire = Prescrire::findOrFail($id);
        $medicaments = Medicament::all();
        $consulters = Consulter::all();
        return view('page.prescrires.edit',compact('prescrire','medicaments','consulters'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $prescrire = Prescrire::findOrFail($id);
        $validated = $request->validate([
           'medicament_id'=> 'required|exists:medicaments,id',
            'consulter_id'=> 'required|exists:consulters,id',
            'posologie'=> 'required|string',
            'duree'=> 'required|string',
        ]);
        $prescrire->update($validated);
        return redirect()->route('prescrires.index')->with('success','prescription modifiée');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    public function statut(string $id)
    {
        //
    }
}
