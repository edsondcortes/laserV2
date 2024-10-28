{{-- layout --}}
@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title','Edição de nível de acesso')

{{-- vendor styles --}}
@section('vendor-style')
@endsection

{{-- page style --}}
@section('page-style')
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
                        <form id="roleEdit" method="post" action="{{ route('role.update', $role->id) }}">
                            @csrf
                            @method('put')
                            <div class="row">
                                <div class="col s12">
                                    <div class="input-field">
                                        <label class="form-label">Nome</label>
                                        <input class="form-control" type="text" name="name" value="{{ $role->name }}" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col s12">
                                    <div class="mb-2">
                                        <strong>Permissões:</strong>
                                    </div>
                                    @foreach($permission as $value)
                                        <div class="col s12 m6 xl4">
                                            <div class="switch">
                                                <label>
                                                    <input type="checkbox" name="permission[]" value="{{$value->id}}" {{ $role->hasPermissionTo($value->name) ? 'checked' : '' }}>
                                                    <span class="lever"></span>
                                                    @lang('permissions.' . $value->name)
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col s12">
                                    <button class="btn waves-effect waves-light right mr-0" type="submit" name="action">Atualizar
                                        <i class="material-icons left">refresh</i>
                                    </button>
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
@endsection

{{-- page scripts --}}
@section('page-script')
    <script src="{{ asset('js/scripts/role-edit.js') }}"></script>
@endsection
