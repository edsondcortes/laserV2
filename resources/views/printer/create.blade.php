{{-- layout --}}
@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title','Cadastro de Impressora')

{{-- vendor styles --}}
@section('vendor-style')
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/select2/select2.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/select2/select2-materialize.css')}}">
@endsection

{{-- page style --}}
@section('page-style')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/pages/page-users.css')}} ">
@endsection

{{-- page content --}}
@section('content')
<div class="col s12">
    <div class="container">
        <div class="card">
            <div class="card-content">
                <div class="row">
                    <div class="col s12">
                        @if ($printer == null)
                            <form method="POST" action="{{ route('printer.store') }}">
                                @csrf
                                <div class="input-field col s12">
                                    <label>Nome da Impressora</label>
                                    <input type="text" id="printer_name" name="printer_name" required>
                                </div>
                                <div class="input-field col s12 m6">
                                    <label>IP da Impressora</label>
                                    <input type="text" id="printer_ip" name="printer_ip" required>
                                </div>
                                <div class="input-field col s12 m6">
                                    <label>Porta da Impressora</label>
                                    <input type="text" id="printer_port" name="printer_port" required>
                                </div>
                                <div class="col s12">
                                    <button type="submit" class="btn btn-default btn-sm">
                                        Atualizar Impressora
                                    </button>
                                </div>
                            </form>
                        @else
                            <form method="POST" action="{{ route('printer.store') }}">
                                @csrf
                                <div class="input-field col s12">
                                    <label>Nome da Impressora</label>
                                    <input type="text" id="printer_name" name="printer_name" value="{{ $printer->printer_name }}" required>
                                </div>
                                <div class="input-field col s12 m6">
                                    <label>IP da Impressora</label>
                                    <input type="text" id="printer_ip" name="printer_ip" value="{{ $printer->printer_ip }}" required>
                                </div>
                                <div class="input-field col s12 m6">
                                    <label>Porta da Impressora</label>
                                    <input type="text" id="printer_port" name="printer_port" value="{{ $printer->printer_port }}" required>
                                </div>
                                <div class="col s12">
                                    <button type="submit" class="btn btn-default btn-sm">
                                        Atualizar Impressora
                                    </button>
                                </div>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
