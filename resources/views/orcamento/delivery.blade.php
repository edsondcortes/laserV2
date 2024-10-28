{{-- layout --}}
@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title','Orçamento')

{{-- vendor styles --}}
@section('vendor-style')
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/flatpickr/flatpickr.min.css')}}">
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
                        <span>Orçamento</span>
                    </h5>
                </div>
                <div class="col s12 m6 16 right-align-md">
                    <ol class="breadcrumbs mb-0">
                        <li class="breadcrumbs-item active">Cadastro de Pedidos</li>
                        <li class="breadcrumbs-item active">Informações</li>
                        <li class="breadcrumbs-item active">Informações e Forma de Entrega</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>
<form method="POST" action="{{ route('orcamento.store') }}">
    @method('POST')
    @csrf
    <input type="hidden" name="numberBudget" value="{{$budgetInfos['data']['iddocumento']}}">
    @for($i = 0; $i < $count; $i++)
        <input type="hidden" name="selectedItem[]" value="{{ $selectedItem[$i] }}">
        <input type="hidden" name="codigo[]" value="{{ $code[$i] }}">
        <input type="hidden" name="produto[]" value="{{ $product[$i] }}">
        <input type="hidden" name="cont" value="{{$cont}}">
        <div class="col s12">
            <div class="row">
                <div class="container">
                    <div class="section user-edit">
                        <div class="card">
                            <div class="card-content">
                                <div class="row">
                                    <div class="col s12">
                                        <h6><strong>Código do Item: {{ $code[$i] }}</strong></h6>
                                        <h6><strong>Descrição: {{ $product[$i] }}</strong></h6>
                                        <hr>
                                    </div>
                                </div>
                                <div id="stop">
                                    {{--CARACTERÍSTICAS DO ITEM--}}
                                    <div class="row">
                                        <div class="input-field col s12 m3">
                                            <h6>Forma de Produção</h6>
                                            <select name="production[{{$cont}}]" id="production">
                                                <option value disabled selected>Selecione</option>
                                                <option value="padrao">Padrão</option>
                                                <option value="expressa">Expressa</option>
                                                <option value="conversao">Conversão</option>
                                            </select>
                                        </div>
                                        <div class="input-field col s12 m3">
                                            <h6>Posição do Cubo</h6>
                                            <select name="position[{{$cont}}]" id="position" class="validate">
                                                <option value disabled selected>Selecione</option>
                                                <option value="horizontal">Horizontal</option>
                                                <option value="vertical">Vertical</option>
                                            </select>
                                        </div>
                                        <div class="input-field col s12 m3">
                                            <h6>Tipo de Imagem</h6>
                                            <select name="imagetype[{{$cont}}]" id="imageType" class="validate">
                                                <option value disabled selected>Selecione</option>
                                                <option value="2D">2D</option>
                                                <option value="3D">3D</option>
                                            </select>
                                        </div>
                                        <div class="input-field col s12 m3">
                                            <h6>Fundo da Imagem</h6>
                                            <select name="imageBackground[{{$cont}}]" class="validate">
                                                <option value disabled selected>Selecione</option>
                                                <option value="semfundo">Sem Fundo</option>
                                                <option value="comfundo">Com Fundo</option>
                                            </select>
                                        </div>
                                        <div class="input-field col s12 width-100">
                                            <textarea name="description[{{$cont}}]" id="description"  class="materialize-textarea"></textarea>
                                            <label for="description">Descrição</label>
                                        </div>
                                        {{--FORMA DE ENTREGA COM 1 ITEM--}}
                                        @if ($cont == 0)
                                            <div class="col s12">
                                                <h6 class="align-label">Forma de Entrega
                                                    <i class="material-icons left">local_shipping</i>
                                                </h6>
                                            </div>
                                            <div class="col s12 m2">
                                                <label>
                                                    <input class="with-gap hotel" name="deliveryType[{{$cont}}]" value="hotel" type="radio">
                                                    <span style="color: black">Hotel</span>
                                                </label>
                                            </div>
                                            <div class="col s12 m2">
                                                <label>
                                                    <input class="with-gap despachar" name="deliveryType[{{$cont}}]" value="despachar" type="radio">
                                                    <span style="color: black">Despachar</span>
                                                </label>
                                            </div>
                                            <div class="col s12 m2">
                                                <label>
                                                    <input class="with-gap local" name="deliveryType[{{$cont}}]" value="local" type="radio">
                                                    <span style="color: black">Vem Buscar</span>
                                                </label>
                                            </div>
                                            <div class="col s12 m2">
                                                <label>
                                                    <input  class="with-gap season" name="deliveryType[{{$cont}}]" value="temporada" type="radio">
                                                    <span style="color: black">Temporada</span>
                                                </label>
                                            </div>
                                            <div class="col s12 m3">
                                                <label>
                                                    <input class="with-gap deliveryOnTime" name="deliveryType[{{$cont}}]" value="deliveryOnTime" type="radio">
                                                    <span style="color: black">Entrega na Hora</span>
                                                </label>
                                            </div>
                                        @endif
                                        {{--FORMA DE ENTREGA COM VÁRIOS ITENS--}}
                                        @if ($cont > 0)
                                            <div class="col s12">
                                                <label>
                                                    <input type="checkbox" class="deliverySelect" name="deliverySelect[{{$cont}}]" value="deliverySelect" checked="checked">
                                                    <span class="margin-checkbox">Copiar a forma de entrega do primeiro item</span>
                                                </label>
                                            </div>
                                            <div class="hide-delivery showDelivery">
                                                <div class="col s12 m12 mt-3">
                                                    <h6 class="align-label">Forma de Entrega
                                                        <i class="material-icons left">local_shipping</i>
                                                    </h6>
                                                </div>
                                            </div>
                                            <div class="col s12 m2 hide-delivery showDelivery">
                                                <label>
                                                    <input class="with-gap hotel" name="deliveryType[{{$cont}}]" value="hotel" type="radio">
                                                    <span style="color: black">Hotel</span>
                                                </label>
                                            </div>
                                            <div class="col s12 m2 hide-delivery showDelivery">
                                                <label>
                                                    <input class="with-gap despachar" name="deliveryType[{{$cont}}]" value="despachar" type="radio">
                                                    <span style="color: black">Despachar</span>
                                                </label>
                                            </div>
                                            <div class="col s12 m2 hide-delivery showDelivery">
                                                <label>
                                                    <input class="with-gap local" name="deliveryType[{{$cont}}]" value="local" type="radio">
                                                    <span style="color: black">Vem Buscar</span>
                                                </label>
                                            </div>
                                            <div class="col s12 m2 hide-delivery showDelivery">
                                                <label>
                                                    <input class="with-gap season" name="deliveryType[{{$cont}}]" value="temporada" type="radio">
                                                    <span style="color: black">Temporada</span>
                                                </label>
                                            </div>
                                            <div class="col s12 m3 hide-delivery showDelivery">
                                                <label>
                                                    <input class="with-gap deliveryOnTime" name="deliveryType[{{$cont}}]" value="deliveryOnTime" type="radio">
                                                    <span style="color: black">Entrega na Hora</span>
                                                </label>
                                            </div>
                                        @endif
                                        {{--FINAL DOS BOTÕES DE FORMA DE ENTREGA--}}
                                        {{--HOTEL--}}
                                        <div class="hide-delivery hotelInfo">
                                            <div class="input-field col s12 m8 mt-5">
                                                <select name="hotelId[{{$cont}}]" class="select2 browser-default validate">
                                                    <option value disabled selected>Selecione</option>
                                                    @foreach ($hotels as $hotel)
                                                        <option value="{{ $hotel->id }}">{{ $hotel->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="input-field col s12 m4 mt-5">
                                                <input type="text" name="hotelroom[{{$cont}}]" id="hotelroom" class="validate">
                                                <label for="hotelroom">Quarto</label>
                                            </div>
                                            <div class="input-field col s12 m4">
                                                <input name="hoteldate[{{$cont}}]" class="active flatpickr-date colorlabel .validate" placeholder="Informe uma data">
                                                <label for="hoteldate" class="active">Data de Entrega</label>
                                            </div>
                                            <div class="input-field col s12 m4">
                                                <input class="active flatpickr-hour colorlabel .validate" name="hotelhour[{{$cont}}]" data-error='.errorAlert' placeholder="Informe um horário">
                                                <label for="hotelhour">
                                                    Horário de Entrega
                                                    <small class="errorAlert"></small>
                                                </label>
                                            </div>
                                            <div class="input-field col s12 m4">
                                                <input name="hotelcheckout[{{$cont}}]" class="active flatpickr-date colorlabel" placeholder="Informe uma data">
                                                <label for="hotelcheckout" class="active">Data de Saída do Cliente</label>
                                            </div>
                                        </div>
                                        {{--VEM BUSCAR--}}
                                        <div class="hide-delivery localInfo">
                                            <div class="input-field col s12 m4 mt-5">
                                                <input name="localdatedelivery[{{$cont}}]" class="active flatpickr-date colorlabel .validate" placeholder="Informe uma data">
                                                <label for="localdatedelivery" class="active">Data de Entregra</label>
                                            </div>
                                            <div class="input-field col s12 m4 mt-5">
                                                <input name="localhourdelivery[{{$cont}}]" class="active flatpickr-hour colorlabel .validate" placeholder="Informe um horário">
                                                <label for="localhourdelivery" class="active">Horário de Entrega</label>
                                            </div>
                                            <div class="input-field col s12 m4 mt-5">
                                                <input name="localcheckout[{{$cont}}]" class="active flatpickr-date colorlabel" placeholder="Informe uma data">
                                                <label for="localcheckout" class="active">Data de Saída do Cliente</label>
                                            </div>
                                        </div>
                                        {{--TEMPORADA--}}
                                        <div class="hide-delivery seasonInfo">
                                            <div class="input-field col s12 mt-5">
                                                <input type="text" name="seasonstreet[{{$cont}}]" id="seasonstreet" class="validate">
                                                <label for="seasonstreet">Rua</label>
                                            </div>
                                            <div class="input-field col s12 m2">
                                                <input type="number" name="seasonnumber[{{$cont}}]" id="seasonnumber" class="validate">
                                                <label for="seasonnumber">Número</label>
                                            </div>
                                            <div class="input-field col s12 m5">
                                                <input type="text" name="seasondistrict[{{$cont}}]" id="seasondistrict" class="validate">
                                                <label for="seasondistrict">Bairro</label>
                                            </div>
                                            <div class="input-field col s12 m5">
                                                <select name="seasoncity[{{$cont}}]" class="validate">
                                                    <option disabled selected value="0">Selecione</option>
                                                    <option value="gramado">Gramado</option>
                                                    <option value="canela">Canela</option>
                                                </select>
                                                <label>Cidade</label>
                                            </div>
                                            <div class="input-field col s12">
                                                <input type="text" name="seasoncomplement[{{$cont}}]" id="seasoncomplement">
                                                <label for="seasoncomplement">Complemento</label>
                                            </div>
                                            <div class="input-field col s12 m4">
                                                <input name="seasondatedelivery[{{$cont}}]" class="active flatpickr-date colorlabel .validate" placeholder="Informe uma data">
                                                <label for="seasondatedelivery">Data de Entrega</label>
                                            </div>
                                            <div class="input-field col s12 m4">
                                                <input name="seasonhour[{{$cont}}]" class="active flatpickr-hour colorlabel .validate" placeholder="Informe um horário">
                                                <label for="seasonhour">Horário Preferencial</label>
                                            </div>
                                            <div class="input-field col s12 m4">
                                                <input name="seasondatasaida[{{$cont}}]" class="active flatpickr-date colorlabel .validate" placeholder="Informe uma data">
                                                <label for="seasondatasaida">Data de Saída do Cliente</label>
                                            </div>
                                        </div>
                                        {{--DESPACHAR--}}
                                        <div class="hide-delivery despacharInfo">
                                            @php
                                                $hasAddress = 0;
                                            @endphp
                                            @foreach ($budgetInfos['data']['customer']['0']['enderecos'] as $address)
                                                <input hidden name="addressId[{{$cont}}]" value="{{$address['enderecopessoa']}}">
                                                @if ($address['ativo'] == 1 && $address['pessoa'] != 0)
                                                    @php
                                                        $hasAddress = 1;
                                                    @endphp
                                                    <div class="input-field col s12 m6 mt-5">
                                                        <input value="{{ $address['municipio']['descricao'] !== '0' ? $address['municipio']['descricao'] : "Não informado"}}" disabled class="colorlabel">
                                                        <label for="cidade" class="active">Cidade</label>
                                                    </div>
                                                    <div class="input-field col s12 m6 mt-5">
                                                        <input value="{{ $address['cep'] !== '0' ? $address['cep'] : "Não informado"}}" disabled class="cep colorlabel">
                                                        <label for="cep" class="active">CEP</label>
                                                    </div>
                                                    <div class="input-field col s12 m5">
                                                        <input value="{{ $address['bairrodistrito'] !== ' ' ? $address['bairrodistrito'] : "Não informado"}}" disabled class="colorlabel">
                                                        <label for="bairro" class="active">Bairro</label>
                                                    </div>
                                                    <div class="input-field col s12 m5">
                                                        <input value="{{ $address['logradouro'] !== ' ' ? $address['logradouro'] : "Não informado" }}" disabled class="colorlabel">
                                                        <label for="rua" class="active">Rua</label>
                                                    </div>
                                                    <div class="input-field col s12 m2">
                                                        <input value="{{ $address['numero'] !== ' ' ? $address['numero'] : "Não informado"}}" disabled class="colorlabel">
                                                        <label for="numero" class="active">Numero</label>
                                                    </div>
                                                    <div class="input-field col s12">
                                                        <input value="{{ $address['complemento'] !== ' ' ? $address['complemento'] : "Não informado"}}" disabled class="colorlabel">
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
                                        </div>
                                        {{-- Entrega na hora --}}
                                        <div class="hide-delivery deliveryOnTimeInfo"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @php
            $cont++;
        @endphp
    @endfor
    <button class="btn waves-effect waves-light right mr-0 mb-2" type="submit">
        Finalizar
    </button>
</form>


@endsection

{{-- vendor scripts --}}
@section('vendor-script')
    <script src="{{asset('vendors/flatpickr/flatpickr.js')}}"></script>
    <script src="{{asset('vendors/flatpickr/pt.js')}}"></script>
    <script src="{{asset('vendors/select2/select2.full.min.js')}}"></script>
    <script src="{{asset('vendors/jquery-mask/jquery.mask.min.js')}}"></script>
@endsection

{{-- page scripts --}}
@section('page-script')
    <script type="text/javascript">
        $(".flatpickr-date").flatpickr({
            dateFormat: "d/m/Y",
            monthSelectorType: "static",
            locale: "pt"
        });
    </script>

    <script type="text/javascript">
        $(".flatpickr-hour").flatpickr({
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i",
            time_24hr: true
        });
    </script>

    <script type="text/javascript">
        $(".select2").select2({
        dropdownAutoWidth: true,
        width: '100%'
        });
    </script>

    <script>
        $(document).ready(function(){
            $('.cep').mask('00000-000');
        });
    </script>

<script src="{{ asset('js/scripts/orcamento-delivery.js') }}"></script>
@endsection
