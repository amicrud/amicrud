@if(isset($search_date_from)||isset($search_date_to))

<div class="input-daterange input-group" 
@if (isset($search_date_width))
    style="width:{{$search_date_width}}"
@endif>

    @isset($search_date_from)
    <input type="text" class="input-sm form-control date-picker @isset($search_date_from['class']) {{$search_date_from['class']}} @endisset " name="search_date_from" value="{{$search_date_from['value']}}" 
    @isset($search_date_from['id'])
    id="{{$search_date_from['id']}}"
    @endisset />
    @endisset

    @isset($search_date_to)
    <span class="input-group-addon"><i class="mdi mdi-calendar-arrow-right"></i></span>
    <input type="text" class="input-sm form-control date-picker @isset($search_date_to['class']) {{$search_date_to['class']}} @endisset " name="search_date_to" value="{{$search_date_to['value']}}" 
    @isset($search_date_to['id'])
    id="{{$search_date_to['id']}}"
    @endisset />
    @endisset

</div>
@endif
@isset($ajax)
<script>
    $(document).ready(function() {
     $('.date-picker').datepicker({ 
        clearBtn: true,
        autoclose: true
     });
   });
</script>
@endisset
