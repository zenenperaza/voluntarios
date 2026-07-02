<?php

namespace App\Http\Controllers;

use App\Models\Voluntario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VoluntarioController extends Controller
{
    public function index()
    {
        return view('voluntarios.index', [
            'buscado' => false,
            'cedula' => '',
            'voluntario' => null,
        ]);
    }

    public function buscar(Request $request)
    {
        $validated = $request->validate([
            'cedula' => 'required|string|max:20',
        ]);

        $cedula = trim($validated['cedula']);

        $voluntario = Voluntario::where('cedula', $cedula)
            ->where('estatus', 'Activo')
            ->first();

        return view('voluntarios.index', [
            'buscado' => true,
            'cedula' => $cedula,
            'voluntario' => $voluntario,
        ]);
    }

    public function perfilQr(string $qrToken)
    {
        $voluntario = Voluntario::where('qr_token', $qrToken)
            ->where('estatus', 'Activo')
            ->firstOrFail();

        return view('voluntarios.index', [
            'buscado' => true,
            'cedula' => $voluntario->cedula,
            'voluntario' => $voluntario,
        ]);
    }

    public function listado()
    {
        $voluntarios = Voluntario::orderBy('apellido')->orderBy('nombre')->paginate(12);
        $voluntarios->getCollection()->each->ensureQrToken();

        return view('admin.voluntarios.index', compact('voluntarios'));
    }

    public function create()
    {
        return view('admin.voluntarios.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'apellido' => 'required|string|max:100',
            'cedula' => 'required|string|max:20|unique:voluntarios,cedula',
            'telefono' => 'nullable|string|max:30',
            'email' => 'nullable|email|max:150',
            'profesion' => 'nullable|string|max:150',
            'cargo' => 'nullable|string|max:150',
            'ubicacion' => 'nullable|string|max:200',
            'organismo' => 'nullable|string|max:200',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'estatus' => 'required|in:Activo,Inactivo',
            'observaciones' => 'nullable|string',
        ]);

        $data = $request->except('foto');

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('voluntarios', 'public');
        }

        Voluntario::create($data);

        return redirect()
            ->route('voluntarios.listado')
            ->with('success', 'Voluntario registrado correctamente.');
    }

    public function edit(Voluntario $voluntario)
    {
        return view('admin.voluntarios.edit', compact('voluntario'));
    }

    public function show(Voluntario $voluntario)
    {
        $voluntario->ensureQrToken();

        return view('admin.voluntarios.show', compact('voluntario'));
    }

    public function update(Request $request, Voluntario $voluntario)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'apellido' => 'required|string|max:100',
            'cedula' => 'required|string|max:20|unique:voluntarios,cedula,' . $voluntario->id,
            'telefono' => 'nullable|string|max:30',
            'email' => 'nullable|email|max:150',
            'profesion' => 'nullable|string|max:150',
            'cargo' => 'nullable|string|max:150',
            'ubicacion' => 'nullable|string|max:200',
            'organismo' => 'nullable|string|max:200',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'estatus' => 'required|in:Activo,Inactivo',
            'observaciones' => 'nullable|string',
        ]);

        $data = $request->except('foto');

        if ($request->hasFile('foto')) {
            if ($voluntario->foto) {
                Storage::disk('public')->delete($voluntario->foto);
            }

            $data['foto'] = $request->file('foto')->store('voluntarios', 'public');
        }

        $voluntario->update($data);

        return redirect()
            ->route('voluntarios.listado')
            ->with('success', 'Voluntario actualizado correctamente.');
    }

    public function destroy(Voluntario $voluntario)
    {
        $voluntario->delete();

        return redirect()
            ->route('voluntarios.listado')
            ->with('success', 'Voluntario eliminado correctamente. El registro quedo guardado en la base de datos.');
    }

    public function desactivar(Voluntario $voluntario)
    {
        $voluntario->update([
            'estatus' => 'Inactivo',
        ]);

        return redirect()
            ->route('voluntarios.listado')
            ->with('success', 'Voluntario desactivado correctamente.');
    }
}
