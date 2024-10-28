{{-- layout --}}
@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title','Cadastro de usuários')

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
                            <span>Cadastro de Pedido</span>
                        </h5>
                    </div>
                    <div class="col s12 m6 16 right-align-md">
                        <ol class="breadcrumbs mb-0">
                            <li class="breadcrumbs-item active">Cadastro de Pedido</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class=" col s12">
        <div class="container">
            <div class="section users-edit">
                <div class="card">
                    <div class="card-content">
                        <div class="row">
                            <div class="col s12" id="account">
                                    <form class="search-element" id="IndexOrcamento" method="POST" action="{{route('orcamento.search')}}">
                                        @csrf
                                        <div class="col s12 input-field">
                                            <input type="number" name="orcamento" id="orcamento"
                                                   class="validate" data-error=".errorOrcamento" required>
                                            <label for="orcamento">Número do Orçamento</label>
                                            <small class="errorOrcamento"></small>
                                            <div class="input-field col s12">
                                                <button class="btn waves-effect waves-light right mr-0" type="submit">Pesquisar
                                                    <i class="material-icons left">search</i>
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

{{-- vendor scripts --}}
@section('vendor-script')
    <script src="{{asset('vendors/jquery-validation/jquery.validate.min.js')}}"></script>
    <script src="{{asset('vendors/jquery-validation/localization/messages_pt_BR.js')}}"></script>
@endsection

{{-- page scripts --}}
@section('page-script')
    <script src="{{ asset('js/scripts/orcamento-index.js') }}"></script>

    <script>
        window.history.pushState(null, null, window.location.href);
        window.addEventListener('popstate', function(event) {
            window.history.pushState(null, null, window.location.href);
            event.preventDefault();
        });
    </script>
@endsection
