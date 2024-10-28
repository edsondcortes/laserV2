{{-- layout --}}
@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title','Cadatro de Hotéis')

{{-- Page Content --}}

@section('content')
<div class="row">
    <div id="breadcrumbs-wrapper">
        <div class="container">
            <div class="row">
                <div class="col s12 m6 16">
                    <h5 class="breadcrumbs-title mt-0">
                        <span>Cadastro de Hotéis</span>
                    </h5>
                </div>
                <div>
                    <div class="col s12 m6 16 right-align-md">
                        <ol class="breadcrumbs" mb-0>
                            <li class="breadcrumbs-item active">Hotéis</li>
                            <li class="breadcrumbs-item active">Cadastro</li>
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
                            <form id="hotelCreate" method="POST" action="{{ route('hotel.store') }}">
                                @csrf
                                <div class="input-field col s12 m5">
                                    <input type="text" name="nomeHotel" id="nomeHotel" class="validate" data-error=".errorHotel" required>
                                    <label for="nomeHotel">
                                        Nome
                                    </label>
                                    <small class="errorHotel"></small>
                                </div>
                                <div class="input-field col s12 m5">
                                    <input type="text" name="nomeRua" id="nomeRua" class="validate" data-error=".errorHotel" required>
                                    <label for="nomeRua">
                                        Rua
                                    </label>
                                    <small class="errorHotel"></small>
                                </div>
                                <div class="input-field col s12 m2">
                                    <input type="text" name="numero" id="numero" class="validate" data-error=".errorHotel" required>
                                    <label for="numero">
                                        Número
                                    </label>
                                    <small class="errorHotel"></small>
                                </div>
                                <div class="input-field col s12 m4">
                                    <input type="text" name="bairro" id="bairro" class="validate" data-error=".errorHotel" required>
                                    <label for="bairro">
                                        Bairro
                                    </label>
                                    <small class="errorHotel"></small>
                                </div>
                                <div class="input-field col s12 m4">
                                    <select name="cidade">
                                        <option value disabled selected>Cidade</option>
                                        <option value="gramado">Gramado</option>
                                        <option value="canela">Canela</option>
                                    </select>
                                </div>
                                <div class="input-field col s12 m4">
                                    <input type="text" name="telefone" id="phone_with_ddd" class="phone_with_ddd validate" data-error=".errorHotel" required>
                                    <label for="phone_with_ddd" class="active">
                                        Telefone
                                    </label>
                                    <small class="errorHotel"></small>
                                </div>
                                <div class="input-field col s12">
                                    <button class="btn waves-effect waves-light right mr-0" type="submit" name="action">
                                        Cadastrar
                                        <i class="material-icons left">add</i>
                                    </button>
                                </div>
                            </form>
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
    <script src="{{asset('vendors/jquery-mask/jquery.mask.min.js')}}"></script>
@endsection

{{-- page scripts --}}
@section('page-script')
     <script type="text/javascript">
        $('.phone_with_ddd').mask('(00) 00000-0000');
    </script>

    <script src="{{ asset('js/scripts/hotel.js') }}"></script>
@endsection

