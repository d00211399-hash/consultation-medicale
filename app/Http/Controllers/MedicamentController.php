<?php

namespace App\Http\Controllers;

use App\Models\Medicament;
use Illuminate\Http\Request;

class MedicamentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $medicaments = Medicament::all();
        return view('page.medicaments.index', compact('medicaments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
         return view('page.medicaments.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'reference'=> 'required|string|unique:medicaments,reference',
            'nom'=> 'required|string|max:50',
            'dosage'=> 'required|string',
            'description'=> 'required|string|max:100',
            'image'=> 'nullable|image|mimes:png,jpeg,pjg|max:2048',
            'statut'=> 'required|string|in:disponible,indisponible',
        ]);

              if ($request->hasFile('image')) {
                  $file =$request->file('image');
                  $filename = time().'.'. $file->getClientOriginalExtension();
                  $file->move(public_path('image'), $filename);
                  $validated['image'] = $filename;
              }
              Medicament::create($validated);
              return redirect()->route('medicaments.index')->with('success','medicaments ajouté avec succès');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $medicament = Medicament::findOrFail($id);
        return view('page.medicaments.show', compact('medicament'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $medicament = Medicament::findOrFail($id);
        return view('page.medicaments.edit', compact('medicament'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $medicament = Medicament::findOrFail($id);
        $validated = $request->validate([
           'reference'=> 'required|string|unique:medicaments,reference,' . $medicament->id,
            'nom'=> 'required|string|max:50',
            'dosage'=> 'required|string',
            'description'=> 'required|string|max:100',
            'image'=> 'nullable|image|mimes:png,jpeg,pjg|max:2048',
            'statut'=> 'required|string|in:disponible,indisponible',
        ]);

               if ($request->hasFile('image')) {
                   $file =$request->file('image');
                   $filename = time().'.'. $file->getClientOriginalExtension();
                   $file->move(public_path('image'), $filename);
                   $validated['image'] = $filename;
                }
                $medicament->update($validated);
                return redirect()->route('medicaments.index')->with('success','modification réussite');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
