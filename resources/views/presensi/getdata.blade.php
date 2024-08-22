@if ($histori->isEmpty())
    <div class="alert alert-warning">
        <p>Tidak ada data</p>
    </div>
@endif

@foreach ($histori as $d)
    <ul class="listview image-listview">
        <li>
            <div class="item">
                @php
                    $path = Storage::url('uploads/absensi/' . $d->foto_in);
                @endphp
                <img src="{{ url($path) }}" alt="iamge" class="image">
               <div class="in">
                <div>
                    <b>{{ date('d-m-Y', strtotime($d->tgl_presensi)) }}</b>
                </div>
                <span class="badge {{ $d->jam_in < "08:00:00" ? "badge-success" : "badge-danger"}}">
                    {{ $d->jam_in }}
                </span>
                <span class="badge bg-primary">{{ $d->jam_out }}</span>
               </div>
            </div>
        </li>
    </ul>
@endforeach
