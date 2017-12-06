                @extends('layouts.app')

                @section('additional-vendorcss')
                <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/tables/jsgrid/jsgrid-theme.min.css') }}">
                <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/tables/jsgrid/jsgrid.min.css') }}">
                @endsection

                @section('content')
                <div class="content-header row">
                    <div class="content-header-left col-md-6 col-xs-12 mb-2">
                        <h3 class="content-header-title mb-0">Informasi Dropping</h3>
                        <div class="row breadcrumbs-top">
                            <div class="breadcrumb-wrapper col-xs-12">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="">Dropping</a>
                                    </li>
                                    <li class="breadcrumb-item active">Informasi Dropping
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="content-body"><!-- Basic scenario start -->
                    <section id="basic">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-xs-12">
                                <div class="card">
                                    <div class="card-header">
                                      <h4 class="card-title">Pencarian Dropping</h4>
                                      <a class="heading-elements-toggle"><i class="ft-align-justify font-medium-3"></i></a>
                                    </div>
                                    <div class="card-body collapse in">
                                      <div class="card-block">
                                        <form method="POST" action="{{ url('dropping/filter') }}">
                                          <div class="row">
                                            {{ csrf_field() }}
                                            <div class="col-lg-6 col-xl-3 mb-1">
                                                  <select class="select2 form-control" name="transyear">
                                                    <option disabled="">Berdasarkan Tahun</option>
                                                    <option value="0">Semua Tahun</option>
                                                    <?php
                                                      $thn_skr = date('Y');
                                                      for($x=$thn_skr; $x >= 2005; $x--){
                                                    ?>
                                                      <option {{ ($filters['transyear'] == $x) ? 'selected=""' : '' }} value="<?php echo $x;?>" {{ ($x == $filters['transyear'] ? 'selected=""' : '') }}><?php echo $x;?></option>
                                                      <?php }?>
                                                  </select>
                                            </div>
                                            <div class="col-lg-6 col-xl-3 mb-1">
                                                  <select class="select2 form-control" name="periode">
                                                    <option disabled="">Berdasar Periode</option>
                                                    <option value="0">Semua Periode</option>
                                                    <option {{ $filters['periode'] == '1' ? 'selected=""' : '' }} value="1">Periode I</option>
                                                    <option {{ $filters['periode'] == '2' ? 'selected=""' : '' }} value="2">Periode II</option>
                                                    <option {{ $filters['periode'] == '3' ? 'selected=""' : '' }} value="3">Periode III</option>
                                                    <option {{ $filters['periode'] == '4' ? 'selected=""' : '' }} value="4">Periode IV</option>
                                                  </select>
                                            </div>
                                            <div class="col-lg-6 col-xl-3 mb-1">
                                                  <select class="select2 form-control" name="kcabang">
                                                    <option disabled="">Berdasar Kantor Cabang</option>
                                                    <option value="0" selected>Semua Cabang</option>
                                                    @foreach($kcabangs as $cabang)
                                                      {{ $id = $cabang->VALUE."00" }}
                                                      @if(Gate::check("unit_".$id) )
                                                      <option value="{{ $cabang->DESCRIPTION }}" {{ ($cabang->DESCRIPTION == $filters['kcabang'] ? 'selected=""' : '') }}>{{ $cabang->DESCRIPTION }}</option>
                                                      @endif
                                                    @endforeach
                                                  </select>
                                            </div>
                                            <div class="col-lg-3 col-xl-3 mb-1">
                                              <button type="submit" class="btn btn-outline-primary"><i class="fa fa-search"></i> Cari</button>
                                              @if (checkActiveMenu('dropping') != 'active')
                                              <a href="{{ url('dropping') }}" class="btn btn-danger"><i class="fa fa-times"></i></a>
                                              @endif
                                            </div>
                                          </div>
                                          {{-- <div class="row">
                                              <div class="col-xs-2 pull-right">
                                                <div class="form-group">
                                                  <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> Cari</button>
                                                </div>
                                              </div>
                                            @if (checkActiveMenu('dropping') != 'active')
                                              <div class="col-xs-2">
                                                <div class="form-group">
                                                  <a href="{{ url('dropping') }}" class="btn btn-danger"><i class="fa fa-times"></i> Reset Filter</a>
                                                </div>
                                              </div>
                                            @endif
                                          </div> --}}
                                        </form>
                                      </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="card">
                                    <div class="card-header">
                                        <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                                    </div>
                                    <div class="card-body collapse in">
                                        <div class="card-block card-dashboard ">
                                            <!-- <p>Grid with filtering, editing, inserting, deleting, sorting and paging. Data provided by controller.</p> -->
                                            <div id="basicScenario"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                    <!-- Basic scenario end -->
                </div>
                @endsection

                @section('customjs')
                <!-- BEGIN PAGE VENDOR JS-->
                <script type="text/javascript" src="{{ asset('app-assets/vendors/js/ui/jquery.sticky.js') }}"></script>
                <script type="text/javascript" src="{{ asset('app-assets/vendors/js/charts/jquery.sparkline.min.js') }}"></script>
                <script src="{{ asset('app-assets/vendors/js/tables/jsgrid/jsgrid.min.js') }}" type="text/javascript"></script>
                <script src="{{ asset('app-assets/vendors/js/tables/jsgrid/griddata.js') }}" type="text/javascript"></script>
                <script src="{{ asset('app-assets/vendors/js/tables/jsgrid/jquery.validate.min.js') }}" type="text/javascript"></script>
                <script src="{{ asset('app-assets/vendors/js/forms/select/select2.full.min.js') }}" type="text/javascript"></script>
                <!-- END PAGE VENDOR JS-->
                <!-- BEGIN PAGE LEVEL JS-->
                <script type="text/javascript" src="{{ asset('app-assets/js/scripts/ui/breadcrumbs-with-stats.min.js') }}"></script>
                {{-- <script src="{{ asset('app-assets/js/scripts/tables/jsgrid/jsgrid.min.js') }}" type="text/javascript"></script> --}}
                <script src="{{ asset('app-assets/js/scripts/forms/select/form-select2.min.js') }}" type="text/javascript"></script>
                <!-- END PAGE LEVEL JS-->

                <script type="text/javascript">
                  $(document).ready(function() {
                    $("#basicScenario").jsGrid( {
                      width: "100%",
               
                      sorting: true,
                      paging: true,
                      autoload: true,
               
                      pageSize: 5,
                      pageButtonCount: 10,
                      noDataContent: "Data Belum Tersedia atau silahkan lakukan pencarian",
                      loadMessage: "Mohon, ditunggu...",
                      
                      controller: {
                        loadData: function(filter) {
                          return $.ajax({
                              type: "GET",
                              url: "{{ (checkActiveMenu('dropping') == 'active' ? url('dropping') : url('dropping/get/filtered/'.$filters['transyear'].'/'.$filters['periode'].'/'.$filters['kcabang']) ) }}",
                              data: filter,
                              dataType: "JSON"
                          })
                        }
                      }, 
                      fields: [
                          { name: "journalnum", type: "text", title: "Nomor Jurnal", width: 120 },
                          { name: "bank", type: "text", title: "Nama Bank", width: 120 },
                          { name: "banknum", type: "text", title: "No. Rekening", width: 160 },
                          { name: "transdate", type: "text", title: "Tanggal Dropping", align: "center", width: 160 },
                          { name: "debit", type: "text", align: "right", title: "Nominal", width: 120 },
                          { name: "company", type: "text", title: "Kantor Cabang", width: 120 },
                          /*{ name: "stat", type: "text", title: "Status Posting", 
                            itemTemplate:function(e) {
                              var content = e == '1' ? "Sesuai" : (e == '0' ? "Tidak sesuai" : 'Belum posting');
                              var tag = e == '1' ? "tag-success" : (e == '0' ? "tag-default" : 'tag-info');
                              return "<span class='tag "+tag+"'>"+content+"</span>" ;
                            } 
                          },*/
                          @if(Gate::check('lihat_p_d'))
                          { name: "id_dropping", type: "text", align:"center", title: "Penyesuaian", width: 120,
                            itemTemplate:function(l) {
                              return "<a href='{{ url('/dropping/penyesuaian') }}/"+ l +"' class='btn btn-warning btn-sm'>Pilih</a>"
                            }
                          },
                          @endif
                          @if(Gate::check('lihat_tt_d'))
                          { name: "id_dropping", type: "text", align:"center", title: "Penarikan", width: 120,
                            itemTemplate:function(e) {
                              return "<a href='{{ url('/dropping/tariktunai') }}/"+ e +"' class='btn btn-success btn-sm'>Lanjut</a>"
                            }
                          }
                          @endif
                      ]
                    })
                  });
                </script>
                @endsection