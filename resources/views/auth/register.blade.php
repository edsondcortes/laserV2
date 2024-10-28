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
    <!-- users edit start -->
    <div class="section users-edit">
        <div class="card">
            <div class="card-content">
                <!-- <div class="card-body"> -->
                <div class="row">
                    <div class="col s12" id="account">
                        <form id="userCreate" method="post" action="{{ route('register') }}">
                            @csrf
                            <div class="row">
                                <div class="col s12">
                                    <div class="row">
                                        <div class="col s12 input-field">
                                            <input id="name" name="name" type="text" class="validate"
                                                   data-error=".errorName" required>
                                            <label for="name">Nome</label>
                                            <small class="errorName"></small>
                                        </div>
                                        <div class="col s12 input-field">
                                            <input id="email" name="email" type="email" class="validate"
                                                   data-error=".errorEmail" required>
                                            <label for="email">E-mail</label>
                                            <small class="errorEmail"></small>
                                        </div>
                                        <div class="col s12 input-field">
                                            <input id="password" name="password" type="password" class="validate"
                                                   data-error=".errorPassword" required>
                                            <label for="password">Senha</label>
                                            <small class="errorPassword"></small>
                                        </div>
                                        <div class="col s12 input-field">
                                            <input id="password_confirmation" name="password_confirmation" type="password" class="validate"
                                                   data-error=".errorPasswordConfirmation" required>
                                            <label for="password_confirmation">Confirmar a senha</label>
                                            <small class="errorPasswordConfirmation"></small>
                                        </div>
                                        <div class="col s12">
                                            <label class="col-form-label">Nível de acesso</label>
                                            <select id="role" name="role" class="select2 browser-default" required>
                                                @foreach($roles as $role)
                                                    <option value="{{ $role->name }}">{{ $role->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="input-field col s12">
                                            <button class="btn waves-effect waves-light right mr-0" type="submit" name="action">Cadastrar
                                                <i class="material-icons left">add</i>
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
    </div>
@endsection

{{-- vendor scripts --}}
@section('vendor-script')
    <script src="{{asset('vendors/jquery-validation/jquery.validate.min.js')}}"></script>
    <script src="{{asset('vendors/jquery-validation/localization/messages_pt_BR.js')}}"></script>
    <script src="{{asset('vendors/select2/select2.full.min.js')}}"></script>
@endsection

{{-- page scripts --}}
@section('page-script')
    <script src="{{ asset('js/scripts/user-create.js') }}"></script>
@endsection
