{{-- layout --}}
@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title','Relatórios')

{{-- vendor styles --}}
@section('vendor-style')
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/flatpickr/flatpickr.min.css')}}">
@endsection

{{-- page content --}}
@section('content')
<div class="row">
    <div id="breadcrumbs-wrapper">
        <div class="container">
            <div class="row">
                <div class="col s12 m6 16">
                    <h5 class="breadcrumbs-title mt-0 mb0">
                        <span>Relatório de Itens Cadastrados</span>
                    </h5>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col s12">
    <div class="container">
        <div class="card">
            <div class="card-content">
                <div class="row">
                    <div class="col s12">
                        <h6>Informe um Período a ser Pesquisado:</h6>
                    </div>
                </div>
                <form method="GET" action="{{ route('report.search')}}">
                    <div class="row">
                        <div class="col s12">
                            <input type="text" name="rangeCalendar" class="range-calendar colorlabel">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s12">
                            <button class="btn waves-effect waves-light right" type="submit">
                                Pesquisar
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('vendor-script')
    <script src="{{asset('vendors/flatpickr/flatpickr.js')}}"></script>
    <script src="{{asset('vendors/flatpickr/pt.js')}}"></script>
@endsection

@section('page-script')
    <script type="text/javascript">
        $(".range-calendar").flatpickr({
            mode: "range",
            minDate: "2023-03-16",
            maxDate: "today",
            dateFormat: "d-m-Y",
        });
    </script>
@endsection




