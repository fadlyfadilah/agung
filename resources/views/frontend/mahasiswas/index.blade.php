@extends('layouts.frontend')
@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                @if ($mahasiswa === null)
                    <h3 class="text-uppercase">{{ auth()->user()->name }} | {{ auth()->user()->username }}</h3>
                @else
                    <h3 class="text-uppercase">{{ $mahasiswa->nama_lengkap }} | {{ $mahasiswa->nim }}</h3>
                @endforelse
            </div>
            <div class="card-body">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab"
                            aria-controls="home" aria-selected="true">Identitas Mahasiswa</a>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">

                        <form method="POST" action="{{ route('frontend.mahasiswas.store') }}"
                            enctype="multipart/form-data">
                            @csrf
                            @if ($mahasiswa === null)
                                <div class="form-group">
                                    <label class="required"
                                        for="nama_lengkap">{{ trans('cruds.mahasiswa.fields.nama_lengkap') }}</label>
                                    <input class="form-control {{ $errors->has('nama_lengkap') ? 'is-invalid' : '' }}"
                                        type="text" name="nama_lengkap" id="nama_lengkap"
                                        value="{{ old('nama_lengkap', '') }}" required>
                                    @if ($errors->has('nama_lengkap'))
                                        <span class="text-danger">{{ $errors->first('nama_lengkap') }}</span>
                                    @endif
                                    <span
                                        class="help-block">{{ trans('cruds.mahasiswa.fields.nama_lengkap_helper') }}</span>
                                </div>
                                <div class="form-group">
                                    <label class="required"
                                        for="nim">{{ trans('cruds.mahasiswa.fields.nim') }}</label>
                                    <input class="form-control {{ $errors->has('nim') ? 'is-invalid' : '' }}"
                                        type="text" name="nim" id="nim" value="{{ old('nim', '') }}" required>
                                    @if ($errors->has('nim'))
                                        <span class="text-danger">{{ $errors->first('nim') }}</span>
                                    @endif
                                    <span class="help-block">{{ trans('cruds.mahasiswa.fields.nim_helper') }}</span>
                                </div>
                                <div class="form-group">
                                    <label class="required">{{ trans('cruds.mahasiswa.fields.jenis_kelamin') }}</label>
                                    @foreach (App\Models\Mahasiswa::JENIS_KELAMIN_RADIO as $key => $label)
                                        <div class="form-check {{ $errors->has('jenis_kelamin') ? 'is-invalid' : '' }}">
                                            <input class="form-check-input" type="radio"
                                                id="jenis_kelamin_{{ $key }}" name="jenis_kelamin"
                                                value="{{ $key }}"
                                                {{ old('jenis_kelamin', '') === (string) $key ? 'checked' : '' }} required>
                                            <label class="form-check-label"
                                                for="jenis_kelamin_{{ $key }}">{{ $label }}</label>
                                        </div>
                                    @endforeach
                                    @if ($errors->has('jenis_kelamin'))
                                        <span class="text-danger">{{ $errors->first('jenis_kelamin') }}</span>
                                    @endif
                                    <span
                                        class="help-block">{{ trans('cruds.mahasiswa.fields.jenis_kelamin_helper') }}</span>
                                </div>
                                <div class="form-group">
                                    <label class="required"
                                        for="prodi_id">{{ trans('cruds.mahasiswa.fields.prodi') }}</label>
                                    <select class="form-control select2 {{ $errors->has('prodi') ? 'is-invalid' : '' }}"
                                        name="prodi_id" id="prodi_id" required>
                                        @foreach ($prodis as $id => $entry)
                                            <option value="{{ $id }}"
                                                {{ old('prodi_id') == $id ? 'selected' : '' }}>{{ $entry }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('prodi'))
                                        <span class="text-danger">{{ $errors->first('prodi') }}</span>
                                    @endif
                                    <span class="help-block">{{ trans('cruds.mahasiswa.fields.prodi_helper') }}</span>
                                </div>
                            @else
                                <div class="form-group">
                                    <label class="required"
                                        for="nama_lengkap">{{ trans('cruds.mahasiswa.fields.nama_lengkap') }}</label>
                                    <input class="form-control {{ $errors->has('nama_lengkap') ? 'is-invalid' : '' }}"
                                        type="text" name="nama_lengkap" id="nama_lengkap"
                                        value="{{ old('nama_lengkap', $mahasiswa->nama_lengkap) }}" required>
                                    @if ($errors->has('nama_lengkap'))
                                        <span class="text-danger">{{ $errors->first('nama_lengkap') }}</span>
                                    @endif
                                    <span
                                        class="help-block">{{ trans('cruds.mahasiswa.fields.nama_lengkap_helper') }}</span>
                                </div>
                                <div class="form-group">
                                    <label class="required"
                                        for="nim">{{ trans('cruds.mahasiswa.fields.nim') }}</label>
                                    <input class="form-control {{ $errors->has('nim') ? 'is-invalid' : '' }}"
                                        type="text" name="nim" id="nim"
                                        value="{{ old('nim', $mahasiswa->nim) }}" required>
                                    @if ($errors->has('nim'))
                                        <span class="text-danger">{{ $errors->first('nim') }}</span>
                                    @endif
                                    <span class="help-block">{{ trans('cruds.mahasiswa.fields.nim_helper') }}</span>
                                </div>
                                <div class="form-group">
                                    <label class="required">{{ trans('cruds.mahasiswa.fields.jenis_kelamin') }}</label>
                                    @foreach (App\Models\Mahasiswa::JENIS_KELAMIN_RADIO as $key => $label)
                                        <div class="form-check {{ $errors->has('jenis_kelamin') ? 'is-invalid' : '' }}">
                                            <input class="form-check-input" type="radio"
                                                id="jenis_kelamin_{{ $key }}" name="jenis_kelamin"
                                                value="{{ $key }}"
                                                {{ old('jenis_kelamin', $mahasiswa->jenis_kelamin) === (string) $key ? 'checked' : '' }}
                                                required>
                                            <label class="form-check-label"
                                                for="jenis_kelamin_{{ $key }}">{{ $label }}</label>
                                        </div>
                                    @endforeach
                                    @if ($errors->has('jenis_kelamin'))
                                        <span class="text-danger">{{ $errors->first('jenis_kelamin') }}</span>
                                    @endif
                                    <span
                                        class="help-block">{{ trans('cruds.mahasiswa.fields.jenis_kelamin_helper') }}</span>
                                </div>
                                <div class="form-group">
                                    <label class="required"
                                        for="prodi_id">{{ trans('cruds.mahasiswa.fields.prodi') }}</label>
                                    <select class="form-control select2 {{ $errors->has('prodi') ? 'is-invalid' : '' }}"
                                        name="prodi_id" id="prodi_id" required>
                                        @foreach ($prodis as $id => $entry)
                                            <option value="{{ $id }}"
                                                {{ (old('prodi_id') ? old('prodi_id') : $mahasiswa->prodi->id ?? '') == $id ? 'selected' : '' }}>
                                                {{ $entry }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('prodi'))
                                        <span class="text-danger">{{ $errors->first('prodi') }}</span>
                                    @endif
                                    <span class="help-block">{{ trans('cruds.mahasiswa.fields.prodi_helper') }}</span>
                                </div>
                            @endif
                            <div class="form-group">
                                <button class="btn btn-danger" type="submit">
                                    Simpan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    @parent
@endsection
