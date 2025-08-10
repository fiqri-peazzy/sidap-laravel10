@extends('layouts.app')

@section('title', 'Kategori Atlit')

@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Kategori Atlit</h1>
            <a href="{{ route('atlit.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
                <i class="fas fa-arrow-left fa-sm text-white-50"></i> Kembali ke Atlit
            </a>
        </div>

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-body">
                @livewire('atlit.kategori-atlit-table')
            </div>
        </div>
    </div>
@endsection
