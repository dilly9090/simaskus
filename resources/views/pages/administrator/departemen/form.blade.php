<form action="#" class="horizontal-form" id="form-departemen" method="POST">
    {{ csrf_field() }}
    @if ($id!=-1)
        {{ method_field('PATCH') }}
    @endif
    <div class="form-body">
        <div class="row">
            <div class="col-md-12">
                <div class="form-group has-success">
                    <label class="control-label">Kode Departemen</label>
                    <input type="text" id="code" name="code" class="form-control input-circle" placeholder="Kode Departemen" value="{{$id==-1 ? '' : $det->code}}">
                </div>
            </div>
        </div>
        <div class="row">
            <!--/span-->
            <div class="col-md-12">
                <div class="form-group has-success">
                    <label class="control-label">Nama Departemen</label>
                    <input type="text" id="nama_departemen" name="nama_departemen" class="form-control input-circle" placeholder="Nama Departemen" value="{{$id==-1 ? '' : $det->nama_departemen}}">
                </div>
            </div>
            <!--/span-->
        </div>
        {{-- <div class="row">
            <!--/span-->
            <div class="col-md-12">
                <div class="form-group has-success">
                    <label class="control-label">Nama Pimpinan</label>
                    <select class="bs-select form-control has-success col-md-12" syule="width:100% !important" data-placeholder="Pilih Pimpinan" name="pimpinan_id" id="pimpinan_id" onchange="pilihdepartemen(this.value)">
                        <option value="-1">-Pilih Pimpinan-</option>
                        <option value="0">-Input Data Pimpinan Baru-</option>
                        @foreach ($dosen as $i => $v)
                            @if ($id!=-1)
                                @if ($det->pimpinan_id==$v->id)
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
            <!--/span-->
        </div> --}}
        
    </div>
</form>
<script>
    $('.bs-select').parents('.bootbox').removeAttr('tabindex');
    $('.bs-select').select2({'width':'100%'});
</script>
<style>
    #pimpinan_id_chosen,.select2-selection
    {
        width:100% !important;
    }
</style>