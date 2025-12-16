<?php

namespace App\Http\Controllers;

use App\Http\Controllers;
use App\Models\Vehiculo;
use Illuminate\Http\Request;

class VehiculoController extends Controller
{
    public function index()
    {
        $vehiculos = Vehiculo::where('estado','DENTRO')->get();
        return view ('vehiculos.index',compact('vehiculos'));

    }

    public function create()
    {
        return view ('vehiculos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'placa' => 'required|max:10',
            'tipo'=>'required',
        ]);
        Vehiculo::create([
            'placa' => $request->placa,
            'tipo' => $request->tipo,
            'propietario' => $request->propietario,
            'observaciones' => $request->observaciones,
            'estado' => 'DENTRO'
        ]);

        return redirect()->route('vehiculos.index')
            ->with('success','Vehiculo registrado');
    }

    public function edit(Vehiculo $vehiculo)
    {
        return view ('vehiculos.edit',compact('vehiculo'));
    }

    public function update(Request $request, Vehiculo $vehiculo)
    {
        $request->validate([
            'placa' => 'required|max:10',
            'tipo'=>'required',
        ]);

        $vehiculo->update($request->all());
        return redirect()->route('vehiculos.index')
            ->with('success','Vehiculo actualizado');
    }


    public function destroy(Vehiculo $vehiculo)
    {
        $vehiculo->estado='SALIO';
        $vehiculo->save();

        return redirect()->route('vehiculos.index')
            ->with('success','Vehiculo marcado como salido');
    }
}
