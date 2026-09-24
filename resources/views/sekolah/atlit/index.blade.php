@extends('layouts.app')

@section('title', 'Data Atlet Sekolah')

@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Data Atlet Sekolah</h1>
            <a href="{{ route('sekolah.atlit.create') }}"
                class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                <i class="fas fa-plus fa-sm text-white-50"></i> Tambah Atlet
            </a>
        </div>

        <div class="card shadow mb-4">
            <div class="card-body">
                @livewire('sekolah.atlit-table')
            </div>
        </div>
    </div>
@endsection
