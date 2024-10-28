{{-- layout --}}
@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title','Lista de Hotéis')

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
                        <span>Hotel</span>
                    </h5>
                </div>
                <div class="col s12 m6 16 right-align-md">
                    <ol class="breadcrumbs mb-0">
                        <li class="breadcrumbs-item active">Hotel</li>
                        <li class="breadcrumbs-item active">Lista de hotéis</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="section users-edit">
    <div class="card">
        <div class="card-content">
            <div class="row">
                <div class="col s12 right-align">
                    <form class="search-element" method="GET" action="{{ route('hotel.index') }}">
                        <div class="input-field mb-0 mt-0 mr-2">
                            <input placeholder="Buscar..." id="search" name="search" type="text" class="validate" value="{{ $search !== null ? $search : ''}}">
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
                        <th>Id</th>
                        <th>Nome</th>
                        <th>Ações</th>
                    </thead>
                    <tbody>
                        @foreach ($hotels as $hotelList)
                        <tr>
                            <td>{{ $hotelList->id }}</td>
                            <td>{{ $hotelList->name }}</td>
                            <td>
                                <a href="{{ route('hotel.edit', $hotelList) }}"><i class="material-icons">edit</i></a>
                                <form action="{{ route('hotel.destroy', $hotelList->id) }}" method="POST" class="inline-form">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="destroy form-button-icon red-text">
                                        <i class="material-icons delete">delete</i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="right-align">
                    {{ $hotels->withQueryString()->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
