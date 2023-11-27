
@extends($page_layout)

@push('amicrud_css')

    @if(config('amicrud.load_fontawesome'))
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    @endif

    @if(config('amicrud.load_bootstrap'))
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    @endif

@endpush

@section('title') {{amicrud_form_labels($crud_name)}} @endsection
@section('content')

    <div class="row"> 
      <div class="card w-100">
        <div class="card-body">
            <h4 class="mt-0 header-title"> View
                {{(isset($add_model)&&$add_model) ? ', Add' :'' }}
                {{(isset($edit_model)&&$edit_model) ? ', Edit' :'' }}
                {{(isset($delete_model)&&$delete_model) ? '& Delete ' :'' }}
                 
                {{amicrud_form_labels($crud_name)}}</h4>
           <div class="row">
            <div class="col-md-3 p-0">
                <div class="card-footer bg-white p-0">
                    <input type="search" class="form-control" id="mini-search" placeholder="Search..." name="name">
                </div>
                <div class="card-body p-0" id="list-target">
                    {{-- @include("amicrud.shared.list")   --}}
                </div> <!-- end card body-->
            </div>

            <div class="col-md-9 p-0">
                @include("amicrud::amicrud.shared.alert")
                {{-- <h4 class="mt-0 header-title">Create {{amicrud_form_labels($crud_name)}}</h4> --}}
                <div class="row ml-1">
                    @if($form_info)
                    <p class=" alert-info p-2 rounded">
                        {!! $form_info??'' !!}
                    </p>
                    @endif
                </div>
                <div id="form-target">
                    @include($form_view)      
                </div>
            </div>
           </div>
        </div>
      </div>

    </div>


@endsection

@push('amicrud_js')

  @if(config('amicrud.load_jquery'))
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  @endif

  @if(config('amicrud.load_bootstrap'))
    <!-- Bootstrap Bundle (includes Popper) -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
  @endif

  @if(config('amicrud.load_bootstrap_datepicker'))
    <!-- Bootstrap Datepicker JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    <script>
        $('.date-picker').datepicker({ 
          clearBtn: true,
          autoclose: true
        });
    </script>
  @endif

  @if(config('amicrud.load_sweetalert'))
    <!-- Sweet Alerts js -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
  @endif

@include('amicrud::amicrud.formsjs')

@endpush