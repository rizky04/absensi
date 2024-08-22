@extends('layout.presensi')
@section('header')
    <!-- App Header -->
    <div class="appHeader bg-primary text-light">
        <div class="left">
            <a href="javascript:;" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">Histori Absensi</div>
        <div class="right"></div>
    </div>
@endsection

@section('content')
    <div class="col" style="margin-top: 4rem">
        <div class="form-group boxed">
            <div class="input-wrapper">
                <select name="bulan" id="bulan" class="form-control">
                    <option value="">Bulan</option>
                    @for ($i = 1; $i <= 12; $i++)
                        <option value="{{ $i }}" {{ date('m') == $i ? 'selected' : '' }}>
                            {{ $namabulan[$i] }}</option>
                    @endfor
                </select>
            </div>
        </div>
        <div class="form-group boxed">
            <div class="input-wrapper">
                <select name="tahun" id="tahun" class="form-control">
                    <option value="">Tahun</option>
                    {{-- @foreach($years as $year)
                                <option value="{{ $year }}">{{ $year }}</option>
                            @endforeach --}}
                    @php
                        $tahunmulai = 2023;
                        $tahunskrng = date('Y');
                    @endphp
                    @for ($tahun = $tahunmulai; $tahun <= $tahunskrng; $tahun++)
                        <option value="{{ $tahun }}" {{ date('Y') == $tahun ? 'selected' : '' }}>
                            {{ $tahun }}</option>
                    @endfor
                </select>
            </div>
        </div>
        <div class="form-group boxed">
            <div class="input-wrapper">
                <button type="button" class="btn btn-primary btn-block" id="getdata">
                    <ion-icon name="search-outline"></ion-icon>
                    Search
                </button>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col" id="showhistori"></div>
    </div>
@endsection

@push('myscript')
    <script type="text/javascript">
        $(function() {
            $("#getdata").click(function() {
                var bulan = $("#bulan").val();
                var tahun = $("#tahun").val();
                $.ajax({
                    type: 'POST',
                    url: "{{ route('gethistori') }}",
                    data: {
                        _token : "{{ csrf_token() }}",
                        bulan  : bulan,
                        tahun  : tahun,
                    },
                    chache: false,
                    success: function(respond) {
                        console.log(respond);
                        $("#showhistori").html(respond);
                    }
                });
            });
        });
    </script>
    {{-- <script>
        $(document).ready(function(){
            $('#filter-button').click(function(){
                var bulan = $('#bulan').val();
                var tahun = $('#tahun').val();

                $.ajax({
                    url: "{{ route('gethistori') }}",
                    type: "GET",
                    data: {
                        _token : "{{ csrf_token() }}",
                        bulan: bulan,
                        tahun: tahun
                    },
                    success: function(data) {
                        var html = '<table class="table table-bordered"><thead><tr><th>Tanggal Presensi</th><th>Jam</th></tr></thead><tbody>';
                        $.each(data, function(key, presensi){
                            html += '<tr>';
                            html += '<td>' + presensi.tgl_presensi + '</td>';
                            html += '<td>' + presensi.jam_in + '</td>';
                            html += '</tr>';
                        });
                        html += '</tbody></table>';
                        $('#result').html(html);
                    },
                    error: function(xhr, status, error) {
                        console.log(xhr.responseText);
                    }
                });
            });
        });
    </script> --}}
@endpush
