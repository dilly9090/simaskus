@extends('layouts.master')
@section('title')
    <title>Beranda :: SIMA-sp</title>
@endsection

@section('konten')
    {{-- @include('home') --}}
<div class="page-content">                        
    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <a href="{{url('beranda')}}">Beranda</a>
                <i class="fa fa-circle"></i>
                <a href="#">Rekapitulasi Jumlah Bimbingan</a>
            </li>
           
        </ul>
        
    </div>
    <!-- END PAGE BAR -->
    <!-- BEGIN PAGE TITLE-->
    <h1 class="page-title"> Sistem Informasi Mata Kuliah Spesial</h1>
    <div class="row">
         <div class="col-md-12">
            <div class="portlet light bordered">
                <div class="portlet-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="tools pull-right"> 
                                Tahun Ajaran
                                <select class="bs-select has-success" data-placeholder="Tahun Ajaran" id="tahunajaran" name="tahunajaran" onchange="getdata()">
                                    @foreach ($tahunajaran as $item)
                                        @if ($thnajaran==$item->id)
                                            <option value="{{$thnajaran}}" selected="selected">{{$item->tahun_ajaran}} {{$item->jenis}}</option>
                                        @else
                                            <option value="{{$item->id}}">{{$item->tahun_ajaran}} {{$item->jenis}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-9">
                            <h3>List Data Bimbingan</h3>
                            <hr>
                            <table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_4">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th> Tahun Akademik </th>
                                        <th> Jenis Bimbingan </th>
                                        <th> Nama Mahasiswa </th>
                                        {{-- <th> Tombol Aksi </th> --}}
                                    </tr>
                                </thead>
                                
                                <tbody>
                                    @php
                                        $no=1;
                                    @endphp
                                    @foreach ($data as $item)
                                        <tr>
                                            <td class="text-center">{{$no}}</td>
                                            <td class="text-left">{{$item->tahun_ajaran}} {{$item->jenis}}</td>
                                            <td class="text-left">{{$item->jenispengajuan}}</td>
                                            <td class="text-left"><b>NPM : {{$item->npm}}</b><br>{{$item->nama}}</td>
                                        </tr>
                                        @php
                                            $no++;
                                        @endphp
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-3">
                            <h3>Jumlah Data Bimbingan</h3>
                            <hr>
                            <div style="background: #eee;">
                                <a class="dashboard-stat dashboard-stat-v2 green" href="#">
                                    <div class="visual">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <div class="details text-center">
                                        <div class="desc" style="padding-top:20px;">Jumlah Bimbingan</div>
                                        <div class="number text-center" style="font-size:23px;padding-top:0px;">S1 : <b>{{isset($jlh['S1']) ? count($jlh['S1']) : 0}}x</b></div>
                                    </div>
                                </a>
                                <a class="dashboard-stat dashboard-stat-v2 blue" href="#">
                                    <div class="visual">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <div class="details text-center">
                                        <div class="desc" style="padding-top:20px;">Jumlah Bimbingan</div>
                                        <div class="number text-center" style="font-size:23px;padding-top:0px;">S2 : <b>{{isset($jlh['S2']) ? count($jlh['S2']) : 0}}x</b></div>
                                    </div>
                                </a>
                                <a class="dashboard-stat dashboard-stat-v2 red" href="#">
                                    <div class="visual">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <div class="details text-center">
                                        <div class="desc" style="padding-top:20px;">Jumlah Bimbingan</div>
                                        <div class="number text-center" style="font-size:23px;padding-top:0px;">S3 : <b>{{isset($jlh['S3']) ? count($jlh['S3']) : 0}}x</b></div>
                                    </div>
                                </a>
                                
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('footscript')
<script>
    $(document).ready(function(){
        $('#sample_4').DataTable();
    });

    function getdata()
    {
        var bln=$('#tahunajaran').val();
        location.href='{{url("/")}}/rekap-pembimbing/'+bln;
    }
</script>
<style>
    .table td,
    .table th
    {
        font-size: 11px !important;
    }
</style>
@endsection