    
    @php
        $string_limit = isset($export) ? 100 : (isset($string_limit)?$string_limit:20) ;
    @endphp
    <div style="height: 400px !important;overflow: scroll;">
        <table id="mini-datatable" class="table table-striped table-bordered table-condensed ">
            <thead>
            <tr class="list-item-header-row">
                @forelse($display_field as $column_name => $custom_name)
                    <th class="column-title" style="display:{{$column_name=='id'?'none':''}}">{{ form_labels($custom_name) }}</th>
                @empty
                @endforelse
                @if(isset($show_actions) && $show_actions && !isset($export))
                    <th width="70">Action</th>
                @endif
            </tr>
            </thead>
            <tbody>
            @forelse($list_contents as $c)
                <tr data-id="{{ $c->id }}">
                    @forelse($display_field as $column_name => $custom_name)
                        <td style="display:{{$column_name=='id'?'none':''}};">
                           

                            @if($formable[$column_name]['type']=='select')
                                {{ $c->{$column_name} ? form_labels(short_string(ucfirst($formable[$column_name]['select_items'][$c->{$column_name}]))) :null }}
                            @else
                            {!! short_string($c->{$column_name},$string_limit) !!}
                            @endif


                        </td>
                    @empty
                    @endforelse
                    @if(isset($show_actions) && $show_actions && !isset($export))
                    <td style="display: inline-flex;">
                        <a class="btn btn-sm btn-danger  delete-details" data-url="{{route($form_delete_route,$c->id)}}" data-name="{{Str::singular($model_name)}}" data-target="{{$form_target}}"><i class="fa fa-trash text-white"></i></a>

                        <a class="btn btn-sm btn-success edit-details" data-url="{{route($form_edit_route,$c->id)}}" data-name="{{Str::singular($model_name)}}" data-target="{{$form_target}}" ><i class="fa fa-pencil text-white"></i></a>
                    </td>
                    @else
                    <td>
                    <a class="btn btn-sm btn-success edit-details" data-url="{{route($form_edit_route,$c->id)}}" data-name="{{Str::singular($model_name)}}" data-target="{{$form_target}}" ><i class="fa fa-pencil text-white"></i></a>
                   </td>
                    @endif
                </tr>
            @empty
            @endforelse
            </tbody>

        </table>
    </div>
