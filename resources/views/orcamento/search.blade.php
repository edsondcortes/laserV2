{{-- layout --}}
@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title','Status do Orçamento')

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
                        <span>Cadastro de Pedidos</span>
                    </h5>
                </div>
                <div class="col s12 m6 16 right-align-md">
                    <ol class="breadcrumbs mb-0">
                        <li class="breadcrumbs-item active">Cadastro de Pedidos</li>
                        <li class="breadcrumbs-tem active">Informações</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col s12">
    <div class="row">
        <div class="container">
            <div class="section user-edit">
                <div class="card">
                    <div class="card-content">
                        <div class="row">
                            <div class=" input-field col s12">
                                <div>
                                    <h5 class="breadcrumbs-title mt-0 mb0"><strong>Orçamento: {{ $num }}</strong></h5>
                                    <hr>
                                </div>
                                    <div class="row">
                                        @php
                                            $hasCustomer = 0;
                                        @endphp
                                        @foreach ($dadosOrcamento['data']['customer'] as $customer)
                                            @if ($customer['ativo'] == 1 && $customer['pessoa'] != 0)
                                                @php
                                                    $hasCustomer = 1;
                                                @endphp
                                                <div class="col s12 m12 mt-1">
                                                    <h6 class="align-label">Dados do Cliente <i class="material-icons left persons">person</i></h6>
                                                 </div>
                                                <div class=" input-field col s12 m4">
                                                    <input value="{{ mb_convert_case($customer['nomerazaosocial'], MB_CASE_TITLE, "UTF-8") }}" disabled class="colorlabel">
                                                    <label for="nome" class="active">Nome</label>
                                                </div>
                                                <div class="input-field col s12 m4">
                                                    <input value="{{ $cpfCnpj = $customer['cnpjcpfidestrangeiro'] }}" disabled class="cpfcnpj colorlabel">
                                                    <label class="active">CPF/CNPJ</label>
                                                </div>
                                                <div class="input-field col s12 m4">
                                                    <input value="{{ $fone }}" disabled class="{{ $fone != 'Não Informado' ? 'phone_with_ddd' : '' }} colorlabel">
                                                    <label class="active">Telefone</label>
                                                </div>
                                            @endif
                                        @endforeach
                                        @if ($hasCustomer == 0)
                                            <div class="col s12 m12">
                                                <h6 class="align-label">Dados do Cliente <i class="material-icons left persons">person</i></h6>
                                            </div>
                                            <div class="col s12 m12 mt-0">
                                                <label class="colorlabel"><span class="font-label">Cliente não cadastrado</span></label>
                                            </div>
                                        @endif
                                        @php
                                            $hasAddress = 0;
                                        @endphp
                                        @foreach ($dadosOrcamento['data']['customer']['0']['enderecos'] as $enderecos)
                                            @if ($enderecos['ativo'] == 1 && $enderecos['pessoa'] != 0)
                                                @php
                                                    $hasAddress = 1;
                                                @endphp
                                                <div class="col s12 m12 mt-1">
                                                    <h6 class="align-label">Endereço do cliente <i class="material-icons left home">home</i></h6>
                                                </div>
                                                <div class="input-field col s12 m6">
                                                    <input value="{{ $enderecos['municipio']['descricao'] !== '0' ? $enderecos['municipio']['descricao'] : "Não informado"}}" disabled class="colorlabel">
                                                    <label for="cidade" class="active">Cidade</label>
                                                 </div>
                                                <div class="input-field col s12 m6">
                                                    <input value="{{ $enderecos['cep'] !== '0' ? $enderecos['cep'] : "Não informado"}}" disabled class="cep colorlabel">
                                                    <label for="cep" class="active">CEP</label>
                                                </div>
                                                <div class="input-field col s12 m4">
                                                    <input value="{{ mb_convert_case($enderecos['bairrodistrito'], MB_CASE_TITLE, "UTF-8") !== ' ' ? $enderecos['bairrodistrito'] : "Não informado"}}" disabled class="colorlabel">
                                                    <label for="bairro" class="active">Bairro</label>
                                                </div>
                                                <div class="input-field col s12 m4">
                                                    <input value="{{ mb_convert_case($enderecos['logradouro'], MB_CASE_TITLE, "UTF-8") !== ' ' ? $enderecos['logradouro'] : "Não informado" }}" disabled class="colorlabel">
                                                    <label for="rua" class="active">Rua</label>
                                                </div>
                                                <div class="input-field col s12 m4">
                                                    <input value="{{ $enderecos['numero'] !== ' ' ? $enderecos['numero'] : "Não informado"}}" disabled class="colorlabel">
                                                    <label for="numero" class="active">Numero</label>
                                                </div>
                                                <div class="input-field col s12">
                                                    <input value="{{ $enderecos['complemento'] !== ' ' ? $enderecos['complemento'] : "Não informado"}}" disabled class="colorlabel">
                                                    <label for="complemento" class="active">Complemento</label>
                                                </div>
                                            @endif
                                        @endforeach
                                        @if ($hasAddress == 0)
                                            <div class="col s12 m12 mt-2">
                                                <h6 class="align-label">Endereço do cliente <i class="material-icons left home">home</i></h6>
                                            </div>
                                            <div class="col s12 m12 mt-0">
                                                <label class="colorlabel"><span class="font-label">Endereço não cadastrado</span></label>
                                            </div>
                                        @endif
                                        <div class="col s12 m12 mt-1">
                                            <h6 class="align-label">Produto <i class="material-icons left shopping_cart">shopping_cart</i></h6>
                                        </div>
                                        <form method="GET" action="{{route('orcamento.delivery')}}">
                                            @foreach ($dadosOrcamento['data']['orcamento_items'] as $key =>  $orcamento)
                                                @if ($orcamento['grade']['produto']['caracteristica_a']['caracteristicaa'] == 10)
                                                    @for ($i = 1; $i <= $orcamento['quantidade']; $i++)
                                                        @if ($orcamento_items[$key]['saldo_banco'] != 0)
                                                            <div class="input-field col s12 m1 mt-1">
                                                                <label class="checkbox-label">
                                                                    <input type="checkbox" name="itemSelected[{{$cont}}]" value="{{ $orcamento['iditemorcamento'] }}" >
                                                                    <span class="margin-checkbox"></span>
                                                                </label>
                                                            </div>
                                                            @php
                                                                $orcamento_items[$key]['saldo_banco']--;
                                                            @endphp
                                                        @else
                                                            <div class="input-field col s12 m1 mt-1">
                                                                <label class="checkbox-label">
                                                                    <input type="checkbox" name="itemSelected[{{$cont}}]" value="{{ $orcamento['iditemorcamento'] }}" checked disabled>
                                                                    <span class="margin-checkbox"></span>
                                                                </label>
                                                            </div>
                                                        @endif
                                                        <div class="input-field col s12 m5">
                                                            <input type="text" name="codigo" value="{{ $orcamento['grade']['produtoimpresso'] }}" disabled class="colorlabel">
                                                            <input hidden name="codigo[{{$cont}}]" value="{{ $orcamento['grade']['produtoimpresso'] }}">
                                                            <label for="codigo" class="active">Código</label>
                                                        </div>
                                                        <div class="input-field col s12 m6">
                                                            <input name="produto" value="{{ mb_convert_case($orcamento['grade']['descricaoimpressa'], MB_CASE_TITLE, "UTF-8") }}" disabled class="colorlabel">
                                                            <input hidden name="produto[{{$cont}}]" value="{{ $orcamento['grade']['descricaoimpressa'] }}">
                                                            <input hidden name="numberBudget" value="{{ $dadosOrcamento['data']['iddocumento'] }}" >
                                                            <label for="produto" class="active">Produto</label>
                                                        </div>
                                                        @php
                                                            $cont++;
                                                        @endphp
                                                    @endfor
                                                @endif
                                            @endforeach
                                            <div class="col s12 m12">
                                                <button class="btn waves-effect waves-light right mr-0" type="submit">Avançar</button>
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
    </div>
</div>
@endsection

{{-- vendor scripts --}}
@section('vendor-script')
    <script src="{{asset('vendors/jquery-mask/jquery.mask.min.js')}}"></script>
@endsection

{{-- page scripts --}}
@section('page-script')
    <script type="text/javascript">
        $(".cpfcnpj").unmask();
        var tamanho = $(".cpfcnpj").val().length;

        if(tamanho <= 11){
            $(".cpfcnpj").mask("999.999.999-99");
        } else{
            $(".cpfcnpj").mask("99.999.999/9999-99");
        }
    </script>

    <script>
        $(document).ready(function(){
            $('.cep').mask('00000-000');
        });
    </script>

    <script type="text/javascript">
        $('.phone_with_ddd').mask('(00) 00000 - 0000');
    </script>
@endsection

