{{-- layout --}}
@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title','Listagem de usuários')

{{-- vendors styles --}}
@section('vendor-style')
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/data-tables/css/jquery.dataTables.min.css')}}">
    <link rel="stylesheet" type="text/css"
          href="{{asset('vendors/data-tables/extensions/responsive/css/responsive.dataTables.min.css')}}">
@endsection

{{-- page styles --}}
@section('page-style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/pages/page-users.css')}}">
@endsection

{{-- page content --}}
@section('content')
    <!-- users list start -->
    <div class="card">
        <div class="card-content">
            <div class="row">
                <div class="col s12 m6">
                    @can('user-create')
                        <a class="waves-effect waves-light btn-small" href="{{ route('register') }}">
                            <i class="material-icons left">add</i>Criar
                        </a>
                    @endcan
                </div>
                <div class="col s12 m6 right-align">
                    <form class="search-element" method="get" action="{{ route('usuarios.index') }}" >
                        <div class="input-field mb-0 mt-0 mr-2">
                            <input placeholder="Buscar..." id="search" name="search" type="text" class="validate" value="{{ $search !== null ? $search : ''}}" >
                        </div>
                        <button type="submit" class="btn-floating btn-small mb-1 waves-effect waves-light box-icon-btn">
                            <i class="material-icons">search</i>
                        </button>
                    </form>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Email</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    @can('user-edit')
                                        <a href="{{ route('usuarios.edit', $user->id) }}"><i class="material-icons">edit</i></a>
                                    @endcan
                                    @can("user-delete")
                                        <form action="{{ route('usuarios.destroy', $user->id) }}" method="POST" class="inline-form">
                                            @csrf
                                            @method('DELETE')
                                                <button type="submit" class=" form-button-icon red-text">
                                                <i class="material-icons delete">delete</i>
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
                    {{ $users->withQueryString()->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection

{{-- vendor scripts --}}
@section('vendor-script')
@endsection

{{-- page script --}}
@section('page-script')
@endsection
