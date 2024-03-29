@extends('core.app')

@section('components')
    <div class="col-12">
        <div class="card bg-card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <h4>{{ $title }}</h4>
                    <form action="{{ route('cari-cuti') }}" class="d-flex col-4">
                        <input type="text" name="query" required class="form-control me-0 me-lg-2" placeholder="Cari nama pegawai" id="">
                        @if (request()->routeIs('cari-cuti'))
                        <a href="{{ route('data-cuti') }}" class="btn border me-0 me-lg-2 border-secondary rounded-0">Back</a>
                        @endif
                        <button class="btn bg-search">Search</button>
                    </form>
                </div>

                <div class="table-responsive my-4 col-12">
                    <table class="table table-striped">
                        <thead class="bg-th">
                            <tr>
                                <th>NIP</th>
                                <th>Nama</th>
                                <th>Jabatan</th>
                                <th>Mulai</th>
                                <th>Selesai</th>
                                <th>Keterangan</th>
                                <th>Bukti</th>
                            </tr>
                        </thead>
                        <tbody class="bg-td">
                            @foreach($recapCuti as $recap)
                            <tr>
                                <td>{{ $recap->user->nip }}</td>
                                <td>{{ $recap->user->nama }}</td>
                                <td>{{ $recap->user->jabatan->nama_jabatan }}</td>
                                <td>{{ $recap->tanggal_awal }}</td>
                                <td>{{ $recap->tanggal_akhir }}</td>
                                <td>{{ $recap->keperluan }}</td>
                                <td><a href="{{ $recap->bukti }}" class="text-danger">Lihat</a></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="d-flex mb-2 justify-content-between">
                        @if (!$recapCuti->isEmpty())
                        
                        <p class="border border-dark px-2">Showing {{ $recapCuti->firstItem() }} to {{ $recapCuti->lastItem() }} of {{ $recapCuti->total() }} entries</p>
                        {{ $recapCuti->links() }}
                        @endif
    
                    </div>

                    @if (!$recapCuti->isEmpty())
                    <div class="d-flex justify-content-end">
                        <form action="{{ route('export-pdf-cuti') }}" method="POST">
                            @csrf
                            <button formtarget="_blank" type="submit" class="btn btn-info text-light">Cetak PDF</button>
                        </form>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection