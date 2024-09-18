@extends('layouts.admin')
@section('content')
<div class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    Dashboard
                </div>

                <div class="card-body">
                    @if(session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
                        <!-- Navbar -->
                        <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" data-scroll="true">
                          <div class="container-fluid py-1 px-3">
                            
                            <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
                              
                             
                              <button type="button" class="btn btn-success" style="margin:10px;">Efris Update: <b id="updated">{{$setting->updated_at}}</b></button>
                              <button type="button" onclick="updateaes()" class="btn btn-primary" style="margin:10px;">UPDATED</button>


                             
                            </div>
                          </div>
                        </nav>
                        <!-- End Navbar -->
                        <div class="container-fluid py-4">
                          <div class="row">
                            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                              <div class="card">
                                <div class="card-header p-3 pt-2">
                                  <div class="icon icon-lg icon-shape bg-gradient-dark shadow-dark text-center border-radius-xl mt-n4 position-absolute">
                                    <i class="material-icons opacity-10">Customers</i>
                                  </div>
                                  <div class="text-end pt-1">
                                    <h4 class="mb-0">{{$customers}}</h4>
                                  </div>
                                </div>
                                <hr class="dark horizontal my-0">
                               
                              </div>
                            </div>
                            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                              <div class="card">
                                <div class="card-header p-3 pt-2">
                                  <div class="icon icon-lg icon-shape bg-gradient-primary shadow-primary text-center border-radius-xl mt-n4 position-absolute">
                                    <i class="material-icons opacity-10">Vans</i>
                                  </div>
                                  <div class="text-end pt-1">
                                    <p class="text-sm mb-0 text-capitalize">Vans</p>
                                    <h4 class="mb-0">{{$vans}}</h4>
                                  </div>
                                </div>
                                <hr class="dark horizontal my-0">
                                
                              </div>
                            </div>
                            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                              <div class="card">
                                <div class="card-header p-3 pt-2">
                                  <div class="icon icon-lg icon-shape bg-gradient-success shadow-success text-center border-radius-xl mt-n4 position-absolute">
                                    <i class="material-icons opacity-10">Routes</i>
                                  </div>
                                  <div class="text-end pt-1">
                                    <p class="text-sm mb-0 text-capitalize">Routes</p>
                                    <h4 class="mb-0">{{$routes}}</h4>
                                  </div>
                                </div>
                                <hr class="dark horizontal my-0">
                               
                              </div>
                            </div>
                            <div class="col-xl-3 col-sm-6">
                              <div class="card">
                                <div class="card-header p-3 pt-2">
                                  <div class="icon icon-lg icon-shape bg-gradient-info shadow-info text-center border-radius-xl mt-n4 position-absolute">
                                    <i class="material-icons opacity-10">dealers</i>
                                  </div>
                                  <div class="text-end pt-1">
                                    <p class="text-sm mb-0 text-capitalize">Dealers</p>
                                    <h4 class="mb-0">{{$dealers}}</h4>
                                  </div>
                                </div>
                                <hr class="dark horizontal my-0">
                                
                              </div>
                            </div>
                          </div>
                          
                        </div>
                      </main>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade bd-example-modal-lg spinnermodal"  data-backdrop="static" data-keyboard="false" tabindex="-1">
    <div class="modal-dialog modal-sm">
        <div class="modal-content" style="width: 48px">
            <span class="fa fa-spinner fa-spin fa-3x"></span>
        </div>
    </div>
</div>
@endsection
@section('scripts')
@parent

@endsection