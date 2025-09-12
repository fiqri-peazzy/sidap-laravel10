{{-- File: resources/views/atlit/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Daftar Atlit')



@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Daftar Atlit</h1>
            <a href="{{ route('admin.atlit.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                <i class="fas fa-plus fa-sm text-white-50"></i> Tambah Atlit
            </a>
        </div>

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-body">
                @livewire('atlit.atlit-table')
            </div>
        </div>
    </div>


@endsection
