@extends('layouts.master')
@section('title')
    <title>{{$id==-1 ? 'Tambah Data Pengajuan Skripsi' :'Edit Data Pengajuan Skripsi'}} :: SIMA-sp</title>
    <link href="{{asset('assets/global/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('konten')
    <div class="page-content">
        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li>
                    <a href="{{url('beranda')}}">Beranda</a>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <a href="{{url('skripsi-pengajuan-admin')}}">Pengajuan</a>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <span>Form Pengauan</span>
                </li>
            </ul>
            
        </div>
        <!-- END PAGE BAR -->
        <!-- BEGIN PAGE TITLE-->
        <h1 class="page-title"> Pengajuan 
            
            <small>{{$id==-1 ? 'Tambah Data' :'Edit Data'}}</small>
            
        </h1>
        <!-- END PAGE TITLE-->
        <!-- END PAGE HEADER-->
        <div class="" style="padding-bottom:30px;margin-bottom:50px;">
            <div class="portlet light portlet-fit portlet-datatable bordered">
                <div class="row" style="padding:5px 20px;">

                    <div class="col-md-6">&nbsp;</div>
                    <div class="col-md-6">
                        <div class="btn-group pull-right">
                            <a href="{{url('pengajuan')}}" id="sample_editable_1_new" class="btn sbold green"> Kembali
                                <i class="fa fa-chevron-left"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="portlet-body">
                    <!-- BEGIN FORM-->
                    @php
                        $mahasiswa=\App\Model\Mahasiswa::where('id',Auth::user()->id_user)->with('programstudi')->first();
                    @endphp
                    @if ($mahasiswa->programstudi->jenjang=='S3')
                        <form action="{{$id==-1 ? url('pengajuan-s3') : url('pengajuan-s3/'.$id) }}" class="horizontal-form" id="form-pengajuan" method="POST" enctype="multipart/form-data">
                    @else
                        <form action="{{$id==-1 ? url('pengajuan') : url('pengajuan/'.$id) }}" class="horizontal-form" id="form-pengajuan" method="POST" enctype="multipart/form-data">
                    @endif
                        {{ csrf_field() }}
                        @if ($id!=-1)
                            {{ method_field('PATCH') }}
                        @endif
                        <div class="form-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group has-success">
                                        <label class="control-label">Tahun Akademik</label>
                                        <select class="bs-select form-control has-success" data-placeholder="Pilih Tahun Akademik" id="tahun_ajaran" name="tahun_ajaran">
                                            <option value="-1">-Pilih Tahun Akademik-</option>
                                            @foreach ($ta as $i => $v)
                                                @if (strpos($v,date('Y'))!==false)
                                                    @if ($id!=-1)
                                                        @if ($det->tahunajaran_id==$v->id)
                                                            <option value="{{$v->id}}" selected="selected">{{$v->tahun_ajaran}} : {{$v->jenis}}</option>    
                                                        @else
                                                            <option value="{{$v->id}}">{{$v->tahun_ajaran}} : {{$v->jenis}}</option>
                                                        @endif
                                                    @else
                                                        <option value="{{$v->id}}">{{$v->tahun_ajaran}} : {{$v->jenis}}</option>
                                                    @endif
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group has-success">
                                        <label class="control-label">Mata Kuliah Spesial</label>
                                        <select class="bs-select form-control has-success" data-placeholder="Pilih Jenis" id="jenis_id" name="jenis_id" onchange="jenis(this.value)">
                                            <option value="-1">-Pilih Jenis-</option>
                                            @foreach ($jenispengajuan as $i => $v)
                                                @php
                                                    if (strpos(strtolower($v->jenis),'praktek')!==false)
                                                        continue;

                                                    
                                                    // dd($mahasiswa->programstudi);
                                                @endphp

                                                @if ($v->keterangan=='S1' || $v->keterangan=='S2' || $v->keterangan=='S3')
                                                    @if ($mahasiswa->programstudi->jenjang==$v->keterangan)
                                                        @if ($id!=-1)
                                                            @if ($det->jenis_id==$v->id)
                                                                <option value="{{$v->id}}" selected="selected">{{$v->jenis}}</option>    
                                                            @else
                                                                <option value="{{$v->id}}">{{$v->jenis}}</option>
                                                            @endif
                                                        @else
                                                            <option value="{{$v->id}}">{{$v->jenis}}</option>
                                                        @endif
                                                    @endif
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <!--/span-->
                                <div class="col-md-6" style="display: none">
                                     <div class="form-group has-success">
                                        <label class="control-label">IPK Terakhir</label>
                                        <input type="text" id="ipk_terakhir" name="ipk_terakhir" class="form-control input-circle" placeholder="IPK Terakhir" value="{{$id==-1 ? '0' : $det->ipk_terakhir}}" style="width:50%;">
                                    </div>
                                </div>
                                @if ($mahasiswa->programstudi->jenjang=='S3')                                    
                                    <div class="col-md-6">
                                        <div class="form-group has-success">
                                            <label class="control-label">Topik Yang Diajukan (*optional)</label>
                                            <input type="text" id="topik_diajukan" name="topik_diajukan" class="form-control input-circle" placeholder="Topik Yang Diajukan" value="{{$id==-1 ? '-' : $det->topik_diajukan}}">
                                        </div>
                                    </div>
                                @else
                                    <input type="hidden" id="topik_diajukan" name="topik_diajukan" class="form-control input-circle" placeholder="Topik Yang Diajukan" value="{{$id==-1 ? '-' : $det->topik_diajukan}}">
                                    
                                @endif
                                <!--/span-->
                            </div>
                            <div class="row">
                                
                                <div class="col-md-6" style="display: none">
                                     <div class="form-group has-success">
                                        <label class="control-label">Jumlah SKS Lulus</label>
                                        <input type="text" id="jumlah_sks_lulus" name="jumlah_sks_lulus" class="form-control input-circle" placeholder="Jumlah SKS Lulus" value="{{$id==-1 ? '0' : $det->jumlah_sks_lulus}}" style="width:50%;">
                                    </div>
                                </div>
                                <!--/span-->
                                
                                <!--/span-->
                            </div>
                            <div class="row">
                                <div class="col-md-6" style="display:none">
                                     <div class="form-group has-success">
                                        <label class="control-label">Bidang Skripsi</label>
                                        <input type="text" id="bidang" name="bidang" class="form-control input-circle" placeholder="Bidang Skripsi" value="{{$id==-1 ? '-' : $det->bidang}}">
                                    </div>
                                </div>
                                <!--/span-->
                                <div class="col-md-6">
                                     <div class="form-group has-success">
                                        <label class="control-label">Skema Penelitian (*optional)</label>
                                        <select class="bs-select form-control has-success" data-placeholder="Pilih Skema" id="skema" name="skema">
                                            <option value="-1">-Pilih Skema-</option>
                                            <option value="Sendiri" {{$id!=-1 ? ($det->skema=="Sendiri" ? 'selected="selected"' : '-') : '-'}}>Sendiri</option>
                                            <option value="Penelitian Dosen" {{$id!=-1 ? ($det->skema=="Penelitian Dosen" ? 'selected="selected"' : '-') : '-'}}>Penelitian Dosen</option>
                                        </select>
                                    </div>
                                </div>
                                <!--/span-->
                            </div>
                            @if ($mahasiswa->programstudi->jenjang=='S2' || $mahasiswa->programstudi->jenjang=='S3')
                                <div class="row" style="">
                            @else
                                    @if (isset($det->status_pengajuan))
                                        @if ($det->status_pengajuan==1)
                                            <div class="row" style="">    
                                        @else
                                            <div class="row" style="display:none;">    
                                        @endif
                                     @else
                                        <div class="row" style="display:none;">    
                                    @endif
                            @endif
                            
                                <div class="col-md-6">
                                     <div class="form-group has-success">
                                        <label class="control-label">Judul Bahasa Indonesia</label>
                                        <input type="text" id="judul_ind" name="judul_ind" class="form-control input-circle" placeholder="Judul (Bahasa Indonesia)" value="{{$id==-1 ? '-' : $det->judul_ind}}">
                                    </div>
                                </div>
                                <!--/span-->
                                <div class="col-md-6">
                                    <div class="form-group has-success">
                                        <label class="control-label">Judul Bahasa Inggris</label>
                                        <input type="text" id="judul_eng" name="judul_eng" class="form-control input-circle" placeholder="Judul (Bahasa Inggris)" value="{{$id==-1 ? '-' : $det->judul_eng}}">
                                    </div>
                                </div>
                                <!--/span-->
                            </div>
                            <input type="hidden" name="deskripsi" value="">
                            {{-- <div class="row">
                                <div class="col-md-12">
                                     <div class="form-group has-success">
                                        <label class="control-label">Deskripsi</label>
                                        <textarea class="wysihtml5 form-control" rows="6" name="deskripsi_rencana">{{$id!=-1 ? $det->deskripsi_rencana : '-'}}</textarea>
                                    </div>
                                </div>
                            </div> --}}
                           
                            <div class="row" style="display:none">
                                <!--/span-->
                                <div class="col-md-12">
                                    <div class="form-group has-success">
                                        <label class="control-label">Abstrak (Indonesia)</label>
                                        <textarea class="wysihtml5 form-control" rows="6" name="abstrak_ind">{{$id!=-1 ? $det->abstrak_ind : '-'}}</textarea>
                                        <small>* Bisa Menyusul</small>
                                    </div>
                                </div>
                                <!--/span-->
                            </div>
                            <div class="row" style="display:none">
                                <div class="col-md-12">
                                    <div class="form-group has-success">
                                        <label class="control-label">Abstrak (Inggris)</label>
                                        <textarea class="wysihtml5 form-control" rows="6" name="abstrak_eng">{{$id!=-1 ? $det->abstrak_eng : '-'}}</textarea>
                                        <small>* Bisa Menyusul</small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                     &nbsp;
                                </div>
                                <!--/span-->
                                
                                <!--/span-->
                            </div>
                           
                        
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-3"> 
                                    <div class="form-group has-success">
                                        <label class="control-label">Pengajuan Ke</label>
                                            <select class="form-control" data-placeholder="Pengajuan Ke" name="pengambilan_ke" id="pengambilan_ke" style="width:100%" onchange="cekmengulang(this.value)">
                                            @for ($x=1;$x<=5;$x++)
                                                @if ($id!=-1)
                                                    @if ($det->pengambilan_ke==$x)
                                                        <option value="{{$x}}" selected="selected">{{$x}}</option>    
                                                    @else
                                                        <option value="{{$x}}">{{$x}}</option>
                                                    @endif
                                                @else
                                                    <option value="{{$x}}">{{$x}}</option>
                                                @endif
                                            @endfor
                                            </select>
                                    </div>
                                    <div class="form-group has-success">
                                        <input type="hidden" name="dosen_ketua">
                                        {{-- <label class="control-label">Dosen Ketua Kelompok Ilmu</label>
                                        <div id="prog_studi">
                                            <select class="form-control select2"data-placeholder="Pilih " name="dosen_ketua" id="dosen_ketua">
                                                <option value="0">Pilih Dosen</option>
                                                @foreach ($dosen as $i => $v)
                                                @if ($v->status_ketua_kelompok==1)
                                                    
                                                    @if ($id!=-1)
                                                        @if ($det->dosen_id==$v->id)
                                                            <option value="{{$v->id}}" selected="selected">{{$v->nama}}</option>    
                                                        @else
                                                        <option value="{{$v->id}}">{{$v->nama}}</option>
                                                        @endif
                                                    @else
                                                        <option value="{{$v->id}}">{{$v->nama}}</option>
                                                    @endif
                                                @endif
                                            @endforeach
                                            </select>
                                        </div> --}}
                                    </div>
                                     <div class="form-group has-success" id="dosen-mengulang" style="display:none">
                                        <label class="control-label">Dosen Pembimbing Sebelumnya (Buat yang mengulang)</label>
                                        <div id="prog_studi">
                                            <select class="form-control select2" data-placeholder="Pilih Dosen" name="pembimbing_sebelumnya" id="pembimbing_sebelumnya">
                                                <option value="0">Pilih Dosen</option>
                                                @foreach ($dosen as $i => $v)
                                                @if ($id!=-1)
                                                    @if ($det->dosen_id==$v->id)
                                                        <option value="{{$v->id}}" selected="selected">{{$v->nama}}</option>    
                                                    @else
                                                        <option value="{{$v->id}}">{{$v->nama}}</option>
                                                    @endif
                                                @else
                                                    <option value="{{$v->id}}">{{$v->nama}}</option>
                                                @endif
                                            @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            <div class="col-md-3"> 
                                    <div class="form-group has-success">
                                        <label class="control-label">Status Dosen Pembimbing</label>
                                            <select class="form-control" data-placeholder="Status Dosen Pembimbing" name="pengambilan_ke" id="pengambilan_ke" style="width:100%" onchange="cekstatusdosen(this.value)">
                                                <option value="1">Dosen Departemen</option>
                                                <option value="2">Seluruh Dosen Fakultas</option>
                                            </select>
                                    </div>
                                </div>
                        </div>
                        
                        <div class="row">
                            @if ($mahasiswa->programstudi->jenjang=='S3')
                                <div class="col-md-6"> 
                                    <div id="jlh-pembimbing"></div>
                                </div>
                                <div class="col-md-6"> 
                                    <div id="kolom_topik"></div>
                                </div>
                            @else
                                @if ($id!=-1)
                                    <div class="col-md-12"> 
                                        @foreach ($dospem as $idx=> $item)
                                        @php
                                            if($idx%2!=0)
                                            {
                                                $border='background:#eee;';
                                            }
                                            else
                                            {
                                                $border='border:1px solid #eee;';
                                            }
                                        @endphp 
                                            <div class="row" style="margin:2px 0px;padding:10px 0;{{$border}};height:116px">
                                                <div class="col-md-5"><input type="text" readonly value="{{$item['dosen']['nama']}}" class="form-control" /></div>    
                                                <div class="col-md-7">
                                                    @if (isset($kolom_topik[$item['dosen_id']]))
                                                        <input type="text" name="kolom_topik[{{$item['dosen_id']}}]" class="form-control" placeholder="Topik" value="{{$kolom_topik[$item['dosen_id']]->topik}}">
                                                        <textarea class="form-control" name="deskripsi_topik[{{$item['dosen_id']}}]" id="deskripsi-topik" placeholder="Deskripsi" style="margin-top:5px;">{{$kolom_topik[$item['dosen_id']]->deskripsi}}</textarea>        
                                                    @else
                                                        <input type="text" name="kolom_topik[{{$item['dosen_id']}}]" class="form-control" placeholder="Topik">
                                                        <textarea class="form-control" name="deskripsi_topik[{{$item['dosen_id']}}]" id="deskripsi-topik" placeholder="Deskripsi" style="margin-top:5px;"></textarea>    
                                                    @endif
                                                    
                                                </div>    
                                            </div>                                            
                                        @endforeach
                                    </div>    
                                @else
                                    <div class="col-md-12"> 
                                        <div id="jlh-pembimbing"></div>
                                    </div>
                                    <div class="col-md-7"> 
                                        <div id="kolom_topik"></div>
                                    </div>    
                                @endif
                                
                            @endif
                        </div>
                        <div class="row">
                            <div class="col-md-12" id="alasan-mengulang" style="display:none"> 
                                    <div class="form-group has-success">
                                        <label class="control-label">Alasan Mengulang (* Jika Mengulang)</label>
                                        <textarea class="wysihtml5 form-control" rows="6" name="alasan_mengulang">{{$id!=-1 ? $det->alasan_mengulang : ''}}</textarea>
                                    </div>
                                </div>
                            <div class="col-md-6"> 
                                    {{-- <div class="form-group has-success">
                                        <label class="control-label">Upload daftar Bimbingan dari SIAK-NG</label>
                                        <input type="file" name="bukti_bimbingan" class="form-control"><br>
                                        <span class="label label-danger">Info</span> <small>Upload bukti daftar bimbingan dalam format jpg, jpeg, png atau PDF. Maksimal ukuran file 10 MB. <br><a href="javascript:contohbuktibimbingan()">Klik disini untuk melihat contoh</a></small>
                                    </div> --}}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12"> 
                                <div class="form-actions " style="width:100%;float:right">
                                    
                                    <button type="button" id="simpan" class="btn blue pull-right">
                                        <i class="fa fa-save"></i> Simpan
                                    </button>
                                    <a href="{{URL::previous()}}" class="btn default pull-right">Batal</a>
                                </div>
                            </div>
                        </div>
                    </form>
                    <!-- END FORM-->
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('footscript')
<style>
.select2-selection__choice
{
    margin-bottom:20px !important;
}
</style>
<script src="{{asset('assets/global/plugins/bootstrap-wysihtml5/wysihtml5-0.3.0.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/global/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.js')}}" type="text/javascript"></script>
<script>
    function cekmengulang(val)
    {
        if(val>1)
        {
            $('#dosen-mengulang').css({'display':'inline'});
            $('#alasan-mengulang').css({'display':'inline'});
        }
        else{
            $('#dosen-mengulang').css({'display':'none'});
            $('#alasan-mengulang').css({'display':'none'});
        }
    }
    function cekstatusdosen(val)
    {
        var jenis=$('#jenis_id').val();
        if(val==1)
        {
            $('#jlh-pembimbing').load('{{url("jlh_pembimbing")}}/'+jenis);
        }
        else{
            $('#jlh-pembimbing').load('{{url("jlh_pembimbing")}}/'+jenis+'/'+val);
        }
        
    }
    function jenis(val)
    {
        $('#jlh-pembimbing').load('{{url("jlh_pembimbing")}}/'+val,function(){
            
        });
    }

    $(document).ready(function(){
        $('.select2').parents('.bootbox').removeAttr('tabindex');
        $('.select2').select2();
        
        

        $('#departemen').change(function(){
            var id=$(this).val();
            $('#prog_studi').load('{{url("program-studi")}}/'+id);
        });

        $('.wysihtml5').wysihtml5({
                "stylesheets": ["{{asset('assets/global/plugins/bootstrap-wysihtml5/wysiwyg-color.css')}}"]
        });
        // swal("Good job!", "You clicked the button!", "success")
        $('#simpan').on('click',function(){
            // $('#form-pengajuan').submit();
            var tahun_ajaran = $('#tahun_ajaran').val();
            var jenis_id = $('#jenis_id').val();
            var skema = $('#skema').val();
            var dosen_pem = $('#dosen_pem').val();

            if(tahun_ajaran=='-1')
            {
                pesan("Tahun Akademik Harus Dipilih",'error');
                $('#tahun_ajaran').focus();
            }
            else if(jenis_id=='-1')
            {
                pesan("Mata Kuliah Spesial Harus Dipilih",'error');
                $('#jenis_id').focus();
            }    
            else if(skema=='-1')
            {
                pesan("Skema Penelitian harus dipilih",'error');
                $('#skema').focus();
            }
            else if(dosen_pem=='-1')
            {
                pesan("Usulan Nama Pembimbing Harus dipilih",'error');
                $('#dosen').focus();
            }
            else
            {
                swal({
                    title: "Apakah Anda Yakin",
                    text: "Data yang diinput sudah benar, dan ingin di Simpan ?",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-info",
                    confirmButtonText: "Ya, Simpan",
                    cancelButtonText: "Tidak",
                    closeOnConfirm: true,
                    closeOnCancel: true
                },
                function(isConfirm) {
                    if (isConfirm) {
                        //swal("Deleted!", "Your imaginary file has been deleted.", "success");
                        $('#form-pengajuan').submit();
                    } 
                });
            }
        });
    });

    function contohbuktibimbingan()
    {
        var url='{{asset("img/buktiBimbingan.jpg")}}';
        $('.modal-title').text('Contoh Bukti Bimbingan');
        $('.modal-body').html("<img src='"+url+"' style='width:100%'>");
        $('#ajax').modal('show');
    }
</script>
@endsection