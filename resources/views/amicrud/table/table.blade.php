@forelse($list_contents as $k => $c)
<tr data-id="{{ $c->id }}">
    <td scope="row">
        {{$k+1}}
        {{-- <div class="form-check">
            <input class="form-check-input" type="checkbox" value="{{$c->id}}">
        </div> --}}
    </td>
    @forelse($display_field as $column_name => $custom_name)
     <td>
       @if ($formable[$column_name]['type']=='file')
       <div class="flex-shrink-0">
        <a href="{{asset($c->{$column_name})}}" target="_blank">
        <img src="{{asset($c->{$column_name})}}" alt="" class="avatar-xs">
        </a>
      </div>
      @elseif(in_array($column_name,['status','flow_status','action_status']))
      
            @if ($c->{$column_name}==1)
            <span class="btn badge bg-soft-success text-success">Active</span>
            @elseif($c->{$column_name}==0)
            <span class="btn badge bg-soft-danger text-danger">Pending</span>
            @else
            <span class="btn badge bg-soft-{{ amicrud_status_class($c->{$column_name}) }} text-{{ amicrud_status_class($c->{$column_name}) }}">{{ $c->{$column_name} }}</span>
            @endif

       @elseif($formable[$column_name]['type']=='select')
        {{ $c->{$column_name} ? amicrud_form_labels(amicrud_short_string(ucfirst($formable[$column_name]['select_items'][$c->{$column_name}]))) :null }}
       @else 
       {!! amicrud_form_labels(amicrud_short_string($c->{$column_name},(isset($string_limit)?$string_limit:20))) !!}
       @endif
     </td>
    @empty
    @endforelse

    @if(isset($show_actions) && $show_actions)
    <td>
        <div class="d-flex gap-2">
            {{-- @dd($show_actions,isset($edit_model),$edit_model) --}}
            @if(isset($edit_model)&&$edit_model)
            <div class="edit mr-2">
                <button class="btn btn-sm btn-success edit-item-btn" data-url="{{amicrud_sign_url(route($form_edit_route,$c->id))}}" data-name="{{Str::singular($crud_name)}}">Edit</button>
            </div>
            @endif
            @if(isset($delete_model)&&$delete_model)
            <div class="remove">
                <button class="btn btn-sm btn-danger remove-item-btn"  data-url="{{amicrud_sign_url(route($form_delete_route,$c->id))}}" data-name="{{Str::singular($crud_name)}}">Remove</button>
            </div>
            @endif
        </div>
    </td>
    @endif
   
    @if(isset($view_url) && $view_url)
    <td>
      <a class="btn btn-sm btn-primary" href="{{route($view_url,['id'=>$c->id])}}">
        @if (isset($label)) {{$label}} @else View @endif
    </a>
    </td>
    @endif
 

</tr>
@empty
@endforelse