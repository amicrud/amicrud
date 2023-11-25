    
    
    <div style="height: 400px !important;overflow: scroll;">
        <table id="mini-datatable" class="table table-striped table-bordered table-condensed dataTable jambo_table">
            <thead>
            <tr class="list-item-header-row">
                @forelse($fields as $k=>$f)
                    <th class="column-title" style="display:{{$k=='id'?'none':''}}">{{ form_labels($k) }}</th>
                @empty
                @endforelse
                @if(isset($show_actions) && $show_actions)
                    <th width="70">Action</th>
                @endif
            </tr>
            </thead>
            <tbody>
            @forelse($list_contents as $c)
                <tr data-id="{{ $c->id }}">
                    @forelse($fields as $f)
                        <td style="display:{{$f=='id'?'none':''}};">{!! Illuminate\Support\Str::limit( $c->{$f}) !!}</td>
                    @empty
                    @endforelse
                    @if(isset($show_actions) && $show_actions)
                    <td style="display: inline-flex;">
                        <a class="btn btn-sm btn-danger  delete-details" data-url="{{route($form_delete_url,$c->id)}}" data-name="{{$type}}" data-target="#{{$form_target}}"><i class="fa fa-trash text-white"></i></a>

                        <a class="btn btn-sm btn-success edit-details" href="{{route($form_edit_url,$c->id)}}" rel="modal:open" ><i class="fa fa-pencil text-white"></i></a>
                    </td>
                    @else
                    <td>
                        <a class="btn btn-sm btn-success edit-details" href="{{route($form_edit_url,$c->id)}}" rel="modal:open" ><i class="fa fa-pencil text-white"></i></a>
                   </td>
                    @endif
                </tr>
            @empty
            @endforelse
            </tbody>

        </table>
    </div>
