{{-- layout --}}
@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title','Listagem de níveis de acesso')

{{-- vendors styles --}}
@section('vendor-style')
@endsection

{{-- page styles --}}
@section('page-style')
@endsection

{{-- page content --}}
@section('content')
    <!-- users list start -->
    <div class="card">
        <div class="card-content">
            <div class="row">
                <div class="col s12 m6">
                    @can('role-create')
                        <a class="waves-effect waves-light btn-small" href="{{ route('role.create') }}">
                            <i class="material-icons left">add</i>Criar
                        </a>
                    @endcan
                </div>
                <div class="col s12 m6 right-align">
                    <form class="search-element" method="get" action="{{ route('role.index') }}" >
                        <div class="input-field mb-0 mt-0 mr-2">
                            <input placeholder="Buscar..." id="search" name="search" type="text" class="validate" value="{{ $search !== null ? $search : ''}}" >
                        </div>
                        <button type="submit" class="btn-floating btn-small mb-1 waves-effect waves-light box-icon-btn">
                            <i class="material-icons">search</i>
                        </button>
                    </form>
                </div>
            </div>
            @if(count($roles) >= 1)
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Nome</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($roles as $role)
                            <tr>
                                <td>{{ $role->id }}</td>
                                <td>{{ $role->name }}</td>
                                <td>
                                    @can('role-edit')
                                        <a href="{{ route('role.edit', $role->id) }}"><i class="material-icons">edit</i></a>
                                    @endcan
                                    @can('role-delete')
                                        <form id="roleDestroy{{ $role->id }}" class="inline-form" method="post" action="{{ route('role.destroy', $role->id) }}">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class="form-button-icon red-text">
                                                <i class="material-icons text-secondary position-relative text-lg">delete</i>
                                            </button>
                                        </form>
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="row mt-2">
                    <div class="col s12 pagination-center">
                        {{ $roles->withQueryString()->links() }}
                    </div>
                </div>
            @else
                <div class="row">
                    <div class="col s12">
                        <h6>Não ha permissões cadastradas</h6>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection

{{-- vendor scripts --}}
@section('vendor-script')
@endsection

{{-- page script --}}
@section('page-script')
@endsection
