<!-- App Bottom Menu -->
<div class="appBottomMenu">
    <a href="{{route('dashboard')}}" class="item  {{ ((\Route::is('dashboard'))) ? 'active' : '' }}">
        <div class="col">
            <ion-icon name="home-outline" role="img" class="md hydrated" aria-label="home outline"></ion-icon>
            <strong>Home</strong>
        </div>
    </a>
    <a href="{{route('history')}}" class="item {{ ((\Route::is('history'))) ? 'active' : '' }}">
        <div class="col">
            <ion-icon name="document-text-outline" role="img" class="md hydrated"
                aria-label="document text outline"></ion-icon>
            <strong>Histori</strong>
        </div>
    </a>
    <a href="{{route('presensi.create')}}" class="item">
        <div class="col">
            <div class="action-button large">
                <ion-icon name="camera" role="img" class="md hydrated" aria-label="add outline"></ion-icon>
            </div>
        </div>
    </a>
    <a href="{{route('izin.index')}}" class="item {{ ((\Route::is('izin'))) ? 'active' : '' }}">
        <div class="col">
            <ion-icon name="calendar-outline" role="img" class="md hydrated"
                aria-label="calendar-outline"></ion-icon>
            <strong>Izin</strong>
        </div>
    </a>
    <a href="{{route('karyawan.edit', Auth::guard('karyawan')->user()->nik)}}" class="item  {{ ((\Route::is('karyawan'))) ? 'active' : '' }}">
        <div class="col">
            <ion-icon name="people-outline" role="img" class="md hydrated" aria-label="people outline"></ion-icon>
            <strong>Profile</strong>
        </div>
    </a>
    <a href="{{route('proseslogout')}}" class="item">
        <div class="col">
            <ion-icon name="people-outline" role="img" class="md hydrated" aria-label="people outline"></ion-icon>
            <strong>Logout</strong>
        </div>
    </a>
</div>
<!-- * App Bottom Menu -->
