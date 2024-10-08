@extends('layout.presensi')
@section('header')
    <!-- App Header -->
    <div class="appHeader bg-primary text-light">
        <div class="left">
            <a href="javascript:;" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">Daftar Izin</div>
        <div class="right"></div>
    </div>
    <!-- * App Header -->
@endsection

@section('content')

<div class="row" style="margin-top: 70px">
    <div class="col">
        @php
            $messagesucces = Session::get('success');
            $messageerror = Session::get('error');
        @endphp
        @if (Session::get('success'))
            <div class="alert alert-success">
                {{ $messagesucces }}
            </div>
        @endif
        @if (Session::get('error'))
            <div class="alert alert-warning">
                {{ $messagesucces }}
            </div>
        @endif
    </div>
</div>

<div class="fab-button bottom-right" style="margin-bottom: 70px">
   <a href="{{ route('izin.create') }}" class="fab">
    <ion-icon name="add-outline"></ion-icon>
   </a>
</div>
@endsection
