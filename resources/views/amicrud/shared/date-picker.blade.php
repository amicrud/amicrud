@if(isset($search_date_from)||isset($search_date_to))

<div class="input-daterange input-group mr-2" 
@if (isset($search_date_width))
    style="width:{{$search_date_width}}"
@endif>

    @isset($search_date_from)
    <input type="text" class="input-sm form-control date-picker @isset($search_date_from['class']) {{$search_date_from['class']}} @endisset " name="search_date_from" value="{{$search_date_from['value']}}" 
    @isset($search_date_from['id'])
    id="{{$search_date_from['id']}}"
    @endisset placeholder="Date From..." />
    @endisset

    @isset($search_date_to)
    <span class="input-group-addon m-1 mt-2"><i class="fa-solid fa-calendar"></i></span>
    <input type="text" class="input-sm form-control date-picker @isset($search_date_to['class']) {{$search_date_to['class']}} @endisset " name="search_date_to" value="{{$search_date_to['value']}}" 
    @isset($search_date_to['id'])
    id="{{$search_date_to['id']}}"
    @endisset placeholder="Date To..." />
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
