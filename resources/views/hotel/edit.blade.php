{{-- layout --}}
@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title','Lista de Hotéis')

{{-- vendors styles --}}
@section('vendor-style')
@endsection

{{-- page styles --}}
@section('page-style')
@endsection

{{-- page content --}}
@section('content')
<div class="row">
    <div id="breadcrumbs-wrapper">
        <div class="container">
            <div class="row">
                <div class="col s12 m6 16">
                    <h5 class="breadcrumbs-title mt-0 mb0">
                        <span>Hotel</span>
                    </h5>
                </div>
                <div class="col s12 m6 16 right-align-md">
                    <ol class="breadcrumbs mb-0">
                        <li class="breadcrumbs-item active">Hotel</li>
                        <li class="breadcrumbs-item active">Edição de Hotel</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- users list start -->
    <div class="card">
        <div class="card-content">
            <div class="row">
                <div class="col s12">
                    <form id="hotelCreate" method="POST" action="{{ route('hotel.update', $editHotel) }}">
                        @csrf
                        @method('put')
                        <div class="row">
                            <div class="col s12">
                                <div class="row">
                                    <div class="input-field col s12">
                                        <input id="name" name="name" type="text" class="validate"
                                                value="{{ $editHotel->name }}"
                                                data-error=".errorName" required>
                                        <label for="name">Nome</label>
                                        <small class="errorName"></small>
                                    </div>
                                    <div class="input-field col s12">
                                        <input id="street" name="street" type="text" class="validate"
                                                value="{{ $editHotel->street }}"
                                                data-error=".errorName" required>
                                        <label for="street">Rua</label>
                                        <small class="errorName"></small>
                                    </div>
                                    <div class="input-field col s12">
                                        <input id="number" name="number" type="text" class="validate"
                                                value="{{ $editHotel->number }}"
                                                data-error=".errorName" required>
                                        <label for="number">Número</label>
                                        <small class="errorName"></small>
                                    </div>
                                    <div class="input-field col s12">
                                        <input id="district" name="district" type="text" class="validate"
                                                value="{{ $editHotel->district }}"
                                                data-error=".errorName" required>
                                        <label for="text">Bairro</label>
                                        <small class="errorName"></small>
                                    </div>
                                    <div class="input-field col s12">
                                        <input id="city" name="city" type="text" class="validate"
                                                value="{{ $editHotel->city }}"
                                                data-error=".errorName" required>
                                        <label for="city">Cidade</label>
                                        <small class="errorName"></small>
                                    </div>
                                    <div class="input-field col s12">
                                        <input id="fone" name="fone" type="text" class="phone_with_ddd validate"
                                                value="{{ $editHotel->fone }}"
                                                data-error=".errorName" required>
                                        <label for="fone">Telefone</label>
                                        <small class="errorName"></small>
                                    </div>
                                    <div class="input-field col s12">
                                        <button class="btn waves-effect waves-light right mr-0">
                                            Atualizar
                                            <i class="material-icons left">refresh</i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('vendor-script')
    <script src="{{asset('vendors/jquery-validation/jquery.validate.min.js')}}"></script>
    <script src="{{asset('vendors/jquery-mask/jquery.mask.min.js')}}"></script>
@endsection

@section('page-script')
<script type="text/javascript">
    $('.phone_with_ddd').mask('(00) 00000-0000');
</script>
@endsection
