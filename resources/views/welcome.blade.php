{{-- extend layout --}}
@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title','Bem Vindo!')

{{-- page style --}}
@section('page-style')
@endsection

{{-- page content --}}
@section('content')
    <div class="section">
        <div id="horizontal-card" class="section">
            <h4 class="header">Olá {{ Auth::user()->name }} seja bem vindo!</h4>
            <p>Sistema de Laser Cristais de Gramado</p>
        </div>
    </div>
@endsection

{{-- vendor script --}}
@section('vendor-script')
@endsection

{{-- page script --}}
@section('page-script')
@endsection
