{{-- layout --}}
@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title','Edição')

{{-- vendor styles --}}
@section('vendor-style')
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/sweetalert2/sweetalert2.min.css')}}">
@endsection


@section('content')
<div class="row">
    <div id="breadcrumbs-wrapper">
        <div class="container">
            <div class="container">
                <div class="row">
                    <div class="col s12 m6 16">
                        <h5 class="breadcrumbs-title mt-0 mb0">
                            <span>Edição</span>
                        </h5>
                    </div>
                    <div class="col s12 m6 16 right-align-md">
                        <ol class="breadcrumbs mb-0">
                            <li class="breadcrumbs-item active">Edição</li>
                            <li class="breadcrumbs-item active">Detalhes</li>
                        </ol>
                    </div>
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
                            <div class="col s12">
                                <h6 class="breadcrumbs-title mb0 mt-0 align-label">Dados do Cliente <i class="material-icons left persons">person</i></h6>
                            </div>
                            <div class="input-field col s12 m2">
                                <input value="{{ Adderi::reduceNumber($budgetInfos['data']['iddocumento']) }}" disabled class="colorlabel">
                                <label for="orcamento" class="active">Orçamento</label>
                            </div>
                            @foreach ($budgetInfos['data']['customer'] as $budgetInfo)
                                <div class="input-field col s12 m4">
                                    <input value="{{ $name = mb_convert_case($budgetInfo['nomerazaosocial'],  MB_CASE_TITLE, "UTF-8") }}" disabled class="colorlabel">
                                    <label for="orcamento" class="active">Nome</label>
                                </div>
                                <div class="input-field col s12 m4">
                                    <input value="{{ $budgetInfo['cnpjcpfidestrangeiro'] }}" disabled class="cpfcnpj colorlabel">
                                    <label class="active">CPF/CNPJ</label>
                                </div>
                                <div class="input-field col s12 m2">
                                    <input value="{{ $fone }}" disabled class="{{ $fone != 'Não Informado' ? 'phone_with_ddd' : '' }} colorlabel">
                                    <label class="active">Telefone</label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@foreach ($budget->itemBudget as $item)
    <div class="col s12">
        <div class="row">
            <div class="container">
                <div class="section user-edit">
                    <div class="card">
                        <div class="card-content">
                            <div class="row">
                                <div class="col s12">
                                    <h6 class="align-label">
                                        Produto
                                        <i class="material-icons left shopping_cart">shopping_cart</i>
                                    </h6>
                                </div>
                                <div class="input-field col s12 m4">
                                    <input value="{{ $item['item_code'] }}" disabled class="colorlabel">
                                    <label for="codigo" class="active">Código</label>
                                </div>
                                <div class="input-field col s12 m4">
                                    <input value="{{ $nomeItem = mb_convert_case($item['description'],  MB_CASE_TITLE, "UTF-8") }}" disabled class="colorlabel">
                                    <label for="descricao" class="active">Descrição do Item</label>
                                </div>
                                <div class="input-field col s12 m4">
                                    @if ($item['production_form'] == 1)
                                        <input value="Padrão" disabled class="colorlabel">
                                    @endif
                                    @if ($item['production_form'] == 2)
                                        <input value="Expresso" disabled class="colorlabel">
                                    @endif
                                    @if ($item['production_form'] == 3)
                                        <input value="Conversão" disabled class="colorlabel">
                                    @endif
                                    <label for="producao" class="active">Forma de Produção</label>
                                </div>
                                <div class=" input-field col s12 m4">
                                    <input value="{{ $item['position'] }}" disabled class="colorlabel">
                                    <label class="active">Posição</label>
                                </div>
                                <div class="input-field col s12 m4">
                                    <input value="{{ strtoupper($item['type']) }}" disabled class="colorlabel">
                                    <label for="tipo" class="active">Tipo</label>
                                </div>
                                <div class="input-field col s12 m4">
                                    <input value="{{ substr_replace($item['background'], " ", 3, 0) }}" disabled class="colorlabel">
                                    <label for="fundo" class="active">Fundo</label>
                                </div>
                                <div class="input-field col s12">
                                    <input value="{{ $item['note'] }}" disabled class="colorlabel">
                                    <label for="note" class="active">Observação</label>
                                </div>
                                <div class="input-field col s12">
                                    <h6><strong>Forma de Entrega: {{ $item->deliveryMethod }}</strong>
                                        <i class="material-icons left">local_shipping</i>
                                    </h6>
                                </div>
                                @if ($item->deliveryMethod == 'Vem buscar')
                                    <div class="input-field col s12 m4">
                                        <input value="{{ $item->delivery->date_time_delivery->format('d/m/Y') }}" disabled class="colorlabel">
                                        <label for="data" class="active">Data de Entrega</label>
                                    </div>
                                    <div class="input-field col s12 m4">
                                        <input value="{{ $item->delivery->date_time_delivery->format('H:i') }}" disabled class="colorlabel">
                                        <label for="time" class="active">Horário de Entrega</label>
                                    </div>
                                    @if ($item->delivery->output_date != null)
                                        <div class="input-field col s12 m4">
                                            <input value="{{ $item->delivery->output_date->format('d/m/Y') }}" disabled class="colorlabel">
                                            <label class="active">Data de Saída do Cliente</label>
                                        </div>
                                    @else
                                        <div class="input-field col s12 m4">
                                            <input value="Não Informado" disabled class="colorlabel">
                                            <label class="active">Data de Saída do Cliente</label>
                                        </div>
                                    @endif
                                @endif
                                @if ($item->deliveryMethod == 'Hotel')
                                    <div class="input-field col s12 m8">
                                        <input value="{{ $item->delivery->hotel->name }}" disabled class="colorlabel">
                                        <label class="active">Nome do Hotel</label>
                                    </div>
                                    <div class="input-field col s12 m4">
                                        <input value="{{ $item->delivery->room }}" disabled class="colorlabel">
                                        <label class="active">Quarto</label>
                                    </div>
                                    <div class="input-field col s12 m4">
                                        <input value="{{ $item->delivery->output_date_time->format('d/m/Y') }}" disabled class="colorlabel">
                                        <label class="active">Data de Entrega</label>
                                    </div>
                                    <div class="input-field col s12 m4">
                                        <input value="{{ $item->delivery->output_date_time->format('H:i') }}" disabled class="colorlabel">
                                        <label class="active">Horário de Entrega</label>
                                    </div>
                                    @if ($item->delivery->output_date != null)
                                    <div class="input-field col s12 m4">
                                        <input value="{{ $item->delivery->output_date->format('d/m/Y') }}" disabled class="colorlabel">
                                        <label class="active">Horário de Entrega</label>
                                    </div>
                                    @else
                                        <div class="input-field col s12 m4">
                                            <input value="Não Informado" disabled class="colorlabel">
                                            <label class="active">Data de saída do Cliente</label>
                                        </div>
                                    @endif
                                @endif
                                @if ($item->deliveryMethod == "Temporada")
                                    <div class="input-field col s12 m4">
                                        <input value="{{ $item->delivery->delivery_date_time->format('d/m/Y') }}" disabled class="colorlabel">
                                        <label class="active">Data de Entrega</label>
                                    </div>
                                    <div class="input-field col s12 m4">
                                        <input value="{{ $item->delivery->delivery_date_time->format('H:i') }}" disabled class="colorlabel">
                                        <label class="active">Horário de entrega</label>
                                    </div>
                                    <div class="input-field col s12 m4">
                                        <input value="{{ $item->delivery->output_date->format('d/m/Y') }}" disabled class="colorlabel">
                                        <label class="active">Data de saída</label>
                                    </div>
                                    <div class="input-field col s12 m6">
                                        <input value="{{ mb_convert_case($item->delivery->city, MB_CASE_TITLE, "UTF-8") }}" disabled class="colorlabel">
                                        <label class="active">Cidade</label>
                                    </div>
                                    <div class="input-field col s12 m6">
                                        <input value="{{ $item->delivery->district }}" disabled class="colorlabel">
                                        <label class="active">Bairro</label>
                                    </div>
                                    <div class="input-field col s12 m10">
                                        <input value="{{ $item->delivery->street}}" disabled class="colorlabel">
                                        <label class="active">Rua</label>
                                    </div>
                                    <div class="input-field col s12 m2">
                                        <input value="{{ $item->delivery->number }}" disabled class="colorlabel">
                                        <label class="active">Número</label>
                                    </div>
                                    <div class="input-field col s12">
                                        <input value="{{ $item->delivery->complement }}" disabled class="colorlabel">
                                        <label class="active">Complemento</label>
                                    </div>
                                @endif
                                @if ($item->deliveryMethod == 'Despachar')
                                    @foreach ($budgetInfos['data']['customer'] as $budgetInfo)
                                        <div class="input-field col s12 m10">
                                            <input value="{{ $city = mb_convert_case($budgetInfo['enderecos']['0']['municipio']['descricao'], MB_CASE_TITLE, "UTF-8") }}" disabled class="colorlabel">
                                            <label class="active">Cidade</label>
                                        </div>
                                        <div class="input-field col s12 m2">
                                            <input value="{{ $budgetInfo['enderecos']['0']['cep'] }}" disabled class="cep colorlabel">
                                            <label class="active">CEP</label>
                                        </div>
                                        <div class="input-field col s12 m5">
                                            <input value="{{$neighborhood = mb_convert_case($budgetInfo['enderecos']['0']['bairrodistrito'], MB_CASE_TITLE, "UTF-8") }}" disabled class="colorlabel">
                                        </div>
                                        <div class="input-field col s12 m5">
                                            <input value="{{ $address = mb_convert_case($budgetInfo['enderecos']['0']['logradouro'], MB_CASE_TITLE, "UTF-8") }}" disabled class="colorlabel">
                                            <label class="active">Endereço</label>
                                        </div>
                                        <div class="input-field col s12 m2">
                                            <input value="{{ $budgetInfo['enderecos']['0']['numero'] }}">
                                            <label class="active">Número</label>
                                        </div>
                                        <div class="input-field col s12">
                                            <input value="{{ $complement = mb_convert_case($budgetInfo['enderecos']['0']['complemento'], MB_CASE_TITLE, "UTF-8") }}" disabled class="colorlabel">
                                            <label class="active">Complemento</label>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                            <div class="row">
                                <table class="striped">
                                    <thead>
                                        <tr>
                                            <th><h6>Procedimento</h6></th>
                                            <th><h6>Estado</h6></th>
                                            <th><h6>Ações</h6></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            @if ($item->production_form == 1)
                                                <td>Corte</td>
                                                @if($item->cut != null)
                                                    <td>{{ $item->usercut->name }} - {{ $item->cut->format('d/m/Y - H:i') }}</td>
                                                    <td><i class="material-icons check" style="color: #03a9f4">check</i></td>
                                                @else
                                                    <td>Procedimento não realizado</td>
                                                    <td>
                                                        <a href="{{ route('edition.updateCorte', $item->id) }}">
                                                            <i class="material-icons" style="color: #03a9f4">play_circle_outline</i>
                                                        </a>
                                                    </td>
                                                @endif
                                            @endif
                                        </tr>
                                        <tr>
                                            @if ($item->production_form == 1)
                                                <td>Edição</td>
                                                @if ($item->edition != null)
                                                    <td>{{ $item->useredition->name }} - {{ $item->edition->format('d/m/Y - H:i') }}</td>
                                                    <td><i class="material-icons check" style="color: #03a9f4">check</i></td>
                                                @else
                                                    <td>Procedimento não realizado</td>
                                                    <td>
                                                        <a href="{{ route('edition.updateEdition', $item->id) }}">
                                                            <i class="material-icons" style="color: #03a9f4">play_circle_outline</i>
                                                        </a>
                                                    </td>
                                                @endif
                                            @endif
                                        </tr>
                                        <tr>
                                            @if ($item->production_form == 1 || $item->production_form == 3)
                                                <td>Layout</td>
                                                @if ($item->layout != null)
                                                    <td>{{ $item->userlayout->name }} - {{ $item->layout->format('d/m/Y - H:i') }}</td>
                                                    <td><i class="material-icons check" style="color: #03a9f4">check</i></td>
                                                @else
                                                    <td>Procedimento não realizado</td>
                                                    <td>
                                                        <a href="{{ route('edition.updateLayout', $item->id) }}">
                                                            <i class="material-icons" style="color: #03a9f4">play_circle_outline</i>
                                                        </a>
                                                    </td>
                                                @endif
                                            @endif
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endforeach
@endsection

{{-- vendor scripts --}}
@section('vendor-script')
    <script src="{{asset('vendors/sweetalert2/sweetalert2.all.min.js')}}"></script>
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
