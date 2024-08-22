@extends('layout.presensi')
@section('header')
    <!-- App Header -->
    <div class="appHeader bg-primary text-light">
        <div class="left">
            <a href="javascript:;" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">Form Izin</div>
        <div class="right"></div>
    </div>
    <!-- * App Header -->
@endsection

@section('content')
    <form action="{{ route('izin.store') }}" method="POST" id="from_izin" enctype="multipart/form-data" style="margin-top: 4rem">
        @method('POST')
        @csrf
        <div class="col">
            <div class="form-group boxed">
                <div class="input-wrapper">
                    <input type="date" class="form-control" id="tgl_izin" name="tgl_izin" placeholder="tanggal"
                        autocomplete="off">
                </div>
            </div>
            <div class="form-group boxed">
                <div class="input-wrapper">
                    <select name="status" id="status" class="form-control">
                        <option value="">Izin / Sakit</option>
                        <option value="i">Izin</option>
                        <option value="s">Sakit</option>
                    </select>
                </div>
            </div>
            <div class="form-group boxed">
                <div class="input-wrapper">
                    <textarea name="keterangan" id="keterangan" cols="30" rows="5" placeholder="Keterangan" class="form-control"></textarea>
                </div>
            </div>
            <div class="form-group boxed">
                <div class="input-wrapper">
                    <button type="submit" class="btn btn-primary btn-block">
                        <ion-icon name="add-outline"></ion-icon>
                        Tambah Data Izin
                    </button>
                </div>
            </div>
        </div>
    </form>
@endsection

@push('myscript')
    <script>
        $(document).ready(function() {
            $('#from_izin').submit(function() {
                var tgl_izin = $('#tgl_izin').val();
                var status = $('#status').val();
                var keterangan = $('#keterangan').val();
                if (tgl_izin == "") {
                    Swal.fire({
                        title: 'Oops !',
                        text: 'Isi Tanggal Izin',
                        icon: 'error',
                    });
                    return false;
                } else if (status == "") {
                    Swal.fire({
                        title: 'Oops !',
                        text: 'Isi Status',
                        icon: 'error',
                    });
                    return false;
                }else if (keterangan == "") {
                    Swal.fire({
                        title: 'Oops !',
                        text: 'Isi Keterangan',
                        icon: 'error',
                    });
                    return false;
                }
            })
        })
    </script>
@endpush
