@extends('admin.layouts.app')

@section('title', 'Home Page')

@section('content')
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Reporte Gráfico</h5>
            <hr>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('assets/admin/vendors/chart.js/Chart.min.js') }}"></script>
@endpush
