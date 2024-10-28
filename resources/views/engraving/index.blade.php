{{-- layout --}}
@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title','Gravação')

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
<div class="row">
    <div id="breadcrumbs-wrapper">
        <div class="container">
            <div class="row">
                <div class="col s12 m6 16">
                    <h5 class="breadcrumbs-title mt-0 mb0">
                        <span>Gravação</span>
                    </h5>
                </div>
                <div class="col s12 m6 16 right-align-md">
                    <ol class="breadcrumbs mb-0">
                        <li class="breadcrumbs-item active">Pedidos</li>
                        <li class="breadcrumbs-item active">Gravação</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="card">
    <div class="card-content">
        <div class="table-responsive">
            @if ($budgets == null)
                <h5>Não existem orçamentos a serem gravados no momento</h5>
            @else
                <div class="row">
                    <div class="col s12 rigth-align">
                        <form class="search-element" method="GET" action="{{ route('engraving.index') }}">
                            <div class="input-field mb-0 mt-0 mr-2">
                                <input placeholder="Buscar..." id="search" name="search" type="text" class="validate" value="{{ $search !== null ? $search : ''}}">
                            </div>
                            <button type="submit" class="btn-floating btn-small mb-1 waves-effect waves-light box-icon-btn">
                                <i class="material-icons">search</i>
                            </button>
                        </form>
                    </div>
                </div>
                <table class="table">
                    <thead>
                        <th>Orçamento</th>
                        <th>Nome</th>
                        <th>Data de Saída</th>
                        <th>Tempo de Espera</th>
                        <th>Status</th>
                    </thead>
                    <tbody>
                        @foreach ($items as $key => $item)
                            @php
                                 $dataIndex = array_search($item->adderi_budget, array_column($budgets, 'iddocumento'))
                            @endphp
                            <tr>
                                <td>{{Adderi::reduceNumber($budgets[$dataIndex]['iddocumento'])}}</td>
                                <td>{{$name = mb_convert_case($budgets[$dataIndex]['nomerazaosocial'],  MB_CASE_TITLE, "UTF-8")}}</td>
                                @if ($item->checkoutDate->format('d/m/Y') != '01/12/2100')
                                    <td>{{$item->checkoutDate->format('d/m/Y')}}</td>
                                @else
                                    <td>Não informado</td>
                                @endif
                                <td>{{ $waitingTime[$key] }} Dia (s)</td>
                                <td>{{$budgets[$dataIndex]['etapaorcamento_descricao']}}</td>
                                <td>
                                    <a href="{{ route('engraving.show', $budgets[$dataIndex]['iddocumento']) }}"><i class="material-icons">remove_red_eye</i></a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</div>
@endsection

