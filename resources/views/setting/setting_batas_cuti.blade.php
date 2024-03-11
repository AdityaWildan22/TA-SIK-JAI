@extends('layouts.template')
@section('judul', 'Setting Batas Cuti')
@section('content')
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    <div class="row justify-content-center mt-5">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-primary">
                    <h1 class="card-title mb-0" style="font-size:18px; color:#fff">SETTING BATAS CUTI</h1>
                </div>
                <div class="card-body">
                    <form action="{{ route('update-jumlah-cuti') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="batas_cuti">BATAS CUTI</label>
                            <input type="number" class="form-control" id="batas_cuti" name="batas_cuti" min="0"
                                value="{{ env('BATAS_CUTI') }}">
                        </div>
                        <div class="form-group mb-0" style="display: flex; justify-content:end">
                            <button type="submit" class="btn btn-md btn-primary">
                                <i class="fas fa-save"></i> Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
