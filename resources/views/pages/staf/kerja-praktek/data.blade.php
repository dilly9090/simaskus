<div class="portlet light portlet-fit portlet-datatable bordered">
    <div class="row" style="padding:5px 20px;">

        <div class="col-md-6">&nbsp;</div>
        <div class="col-md-6">
            <div class="btn-group pull-right">
                @php
                    $state=0;
                @endphp
                @foreach ($pengajuan as $i => $v)
                    @php
                        if (strpos(strtolower($v->jenispengajuan->jenis),'kerja praktek')!==false)
                        {
                            $state=1;
                        }                         
                    @endphp
                @endforeach
                @if ($state==0)
                    
                <a href="{{url('data-kp/-1/'.Auth::user()->kat_user)}}" id="sample_editable_1_new" class="btn sbold green"> Tambah Data
                    <i class="fa fa-plus"></i>
                </a>
                @endif
            </div>
        </div>
    </div>
    <div class="portlet-body">
        <table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_4">
            <thead>
                <tr>
                    <th>No</th>
                    <th> Tanggal Pengajuan </th>
                    <th> Nama Mahasiswa (NPM) </th>
                    @if ($pengajuan->count() !=0)
                        @if ($pengajuan[0]->status_pengajuan!=0)
                            <th> Grup KP </th>
                            <th> Lokasi KP</th>
                            <th> Waktu <br>Kerja Praktek </th>
                            <th> Status <br>Pelaksanaan KP </th>
                        @endif
                    @endif
                    <th> Status <br>Pengajuan</th>
                    <th> # </th>
                </tr>
            </thead>
            
            <tbody>
            @foreach ($pengajuan as $i => $v)
                @php
                    $idpengajuan=$v->id;
                @endphp
                <tr class="odd gradeX">
                    <td>{{(++$i)}}</td>
                    <td>{{tgl_indo($v->created_at)}}</td>
                    <td>{{$v->mahasiswa->nama}}<br><span class="font-blue-madison">NPM : {{$v->mahasiswa->npm}}</span></td>
                    
                    @if ($v->status_pengajuan!=0)  
                        <td>
                            @if (isset($grupkp[$v->mahasiswa_id]))
                                @foreach ($grupkp[$v->mahasiswa_id] as $grup_id=> $grp)
                                    <span class="label label-success label-sm"><i class="fa fa-users"></i> {{$grp->nama_kelompok}}</span>
                                @endforeach
                            @else
                                <span class="label label-warning label-sm">Belum Memiliki Grup</span>
                            @endif
                        </td>
                        <td>
                            @if (isset($grupkp[$v->mahasiswa_id]))
                                @foreach ($grupkp[$v->mahasiswa_id] as $grup_id=> $grp)
                                    @if (isset($infokp[$grp->code]))
                                        <span class="label label-primary label-sm"><i class="fa fa-building"></i> {{$infokp[$grp->code]['instansiperusahaan']->isi}}</span>
                                    @endif
                                @endforeach
                            @endif
                        </td>
                        <td class="text-center">
                            @if (isset($grupkp[$v->mahasiswa_id]))
                                @foreach ($grupkp[$v->mahasiswa_id] as $grup_id=> $grp)
                                    @if (isset($infokp[$grp->code]))
                                        <b><i class="fa fa-clock-o"></i> {{$infokp[$grp->code]['periode-awal']->isi}}</b><br>s.d.<br>
                                        <b><i class="fa fa-clock-o"></i> {{$infokp[$grp->code]['periode-selesai']->isi}}</b>
                                    @endif
                                @endforeach
                            @endif
                        </td>
                        <td class="text-center">
                            {!! $v->status_kp == 0 ? '<span class="label label-warning label-sm"><i class="fa fa-exclamation-circle"></i> Belum Di Mulai</span>' : ($v->status_kp == 1 ? '<span class="label label-success label-sm">Sedang Aktif</span>' : ($v->status_kp == 2 ? '<span class="label label-success label-sm">Sudah Selesai</span>' : '<span class="label label-danger label-sm">Tidak Disetujui</span>'))!!}
                        </td>
                    @endif
                    <td>{!! $v->status_pengajuan == 0 ? '<span class="label label-info label-sm">Belum Di Verifikasi</span>' : ($v->status_pengajuan == 1 ? '<span class="label label-success label-sm">Di Setujui</span>' : '<span class="label label-danger label-sm">Tidak Disetujui</span>')!!}</td>

                    <td>
                        <div style="width:110px;">
                            <a href="{{url('data-kp-detail/'.$v->id.'/'.Auth::user()->kat_user)}}" class="btn btn-xs btn-success"><i class="fa fa-eye"></i></a>
                            <a href="{{url('data-kp/'.$v->id.'/'.Auth::user()->kat_user)}}" class="btn btn-xs btn-primary"><i class="fa fa-edit"></i></a>
                            <a href="javascript:hapus({{$v->id}})" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></a>
                        </div>
                    </td>
                </tr>

            @endforeach                
            </tbody>
        </table>
    </div>
</div>
<style>
    .table td,
    .table th
    {
        font-size: 11px !important;
    }
</style>