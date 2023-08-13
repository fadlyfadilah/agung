<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyMahasiswaRequest;
use App\Http\Requests\StoreMahasiswaRequest;
use App\Http\Requests\UpdateMahasiswaRequest;
use App\Models\Mahasiswa;
use App\Models\Prodi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class MahasiswaController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('mahasiswa_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $prodis = Prodi::pluck('nama_prodi', 'id')->prepend(trans('global.pleaseSelect'), '');

        $prodi = $request['prodi_id'];

        $mahasiswas = Mahasiswa::with(['user', 'prodi'])
            ->when($prodi, function ($query, $prodi) {
                return $query->where('prodi_id', $prodi);
            })->get();

        return view('admin.mahasiswas.index', compact('mahasiswas', 'prodis'));
    }

    public function create()
    {
        abort_if(Gate::denies('mahasiswa_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::pluck('username', 'id')->prepend(trans('global.pleaseSelect'), '');

        $prodis = Prodi::pluck('nama_prodi', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.mahasiswas.create', compact('prodis', 'users'));
    }

    public function store(StoreMahasiswaRequest $request)
    {
        $mahasiswa = Mahasiswa::create($request->all());

        return redirect()->route('admin.mahasiswas.index');
    }

    public function edit(Mahasiswa $mahasiswa)
    {
        abort_if(Gate::denies('mahasiswa_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::pluck('username', 'id')->prepend(trans('global.pleaseSelect'), '');

        $prodis = Prodi::pluck('nama_prodi', 'id')->prepend(trans('global.pleaseSelect'), '');

        $mahasiswa->load('user', 'prodi');

        return view('admin.mahasiswas.edit', compact('mahasiswa', 'prodis', 'users'));
    }

    public function update(UpdateMahasiswaRequest $request, Mahasiswa $mahasiswa)
    {
        $mahasiswa->update($request->all());

        return redirect()->route('admin.mahasiswas.index');
    }

    public function show(Mahasiswa $mahasiswa)
    {
        abort_if(Gate::denies('mahasiswa_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $mahasiswa->load('user', 'prodi');

        return view('admin.mahasiswas.show', compact('mahasiswa'));
    }

    public function destroy(Mahasiswa $mahasiswa)
    {
        abort_if(Gate::denies('mahasiswa_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $mahasiswa->delete();

        return back();
    }

    public function massDestroy(MassDestroyMahasiswaRequest $request)
    {
        $mahasiswas = Mahasiswa::find(request('ids'));

        foreach ($mahasiswas as $mahasiswa) {
            $mahasiswa->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
