                @extends('layouts.app')

                @section('additional-vendorcss')
                <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/tables/jsgrid/jsgrid-theme.min.css') }}">
                <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/tables/jsgrid/jsgrid.min.css') }}">
                <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/forms/selects/select2.min.css') }}">
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
                            <div class="col-xs-7">
                                <div class="card">
                                    <div class="card-header">
                                      <h4 class="card-title">Pencarian Dropping</h4>
                                      <a class="heading-elements-toggle"><i class="ft-align-justify font-medium-3"></i></a>
                                      
                                    </div>
                                    <div class="card-body collapse in">
                                      <div class="card-block">
                                        <div class="row">
                                          <div class="col-xs-4">
                                              <div class="form-group">
                                                <label>Tahun</label>
                                                <select class="select2 form-control" name="tahun">
                                                  <?php
                                                    $thn_skr = date('Y');
                                                    for($x=$thn_skr; $x >= 2005; $x--){
                                                  ?>
                                                    <option value="<?php echo $x;?>"><?php echo $x;?></option>
                                                    <?php }?>
                                                </select>
                                              </div>
                                          </div>
                                          <div class="col-xs-4">
                                              <div class="form-grpup">
                                                <label>Periode</label>
                                                <select class="select2 form-control" name="periode">
                                                  <option value="1">I</option>
                                                  <option value="2">II</option>
                                                  <option value="3">III</option>
                                                  <option value="4">IV</option>
                                                </select>
                                              </div>
                                          </div>
                                          <div class="col-xs-4">
                                              <div class="form-grpup">
                                                <label>Cabang</label>
                                                <select class="select2 form-control" name="cabang">
                                                  <option>Jakarta</option>
                                                  <option>Bandung</option>
                                                  <option>Jogja</option>
                                                  <option>Surabaya</option>
                                                </select>
                                              </div>
                                          </div>
                                        </div>
                                        <div class="row">
                                          <div class="col-xs-2">
                                            <div class="form-grpup">
                                              <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> Filter</button>
                                            </div>
                                          </div>
                                        </div>
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
                      width:"100%", 
                      // height:"400px",
                      sorting:!0, 
                      autoload:!0,
                      paging:!0,
                      pagesize:15,
                      pageButtonCount:5, 
                      controller: {
                        loadData: function(filter) {
                          return $.ajax({
                              type: "GET",
                              url: "{{ url('dropping/get') }}",
                              data: filter,
                              dataType: "JSON"
                          })
                        }
                      }, 
                      fields: [
                          { name: "journalnum", type: "text", title: "Nomor Jurnal", width: 90 },
                          { name: "namabank", type: "text", title: "Nama Bank", width: 80 },
                          { name: "rekbank", type: "text", title: "No. Rekening", width: 100 },
                          { name: "transdate", type: "date", title: "Tanggal Dropping", dateFormat: "d-m-Y", width: 100 },
                          { name: "debit", type: "text", title: "Jumlah", width: 100 },
                          { name: "cabang", type: "text", title: "Cabang", width: 100 },
                          { name: "id_drop", type: "control", itemTemplate:function(e) {
                            return "<a href='{{ url('/dropping/tariktunai') }}/"+ e +"' class='btn btn-success btn-sm'>Lanjut</a>"
                          }
                        }
                      ]
                    })
                  });
                </script>
                @endsection