

    <table class="table align-middle table-nowrap" id="amicrudTable" >
        <!-- Table Head -->
        <thead class="table-light">
            <tr>
                <th scope="col" style="width: 50px;">#</th>
                @forelse($display_field as $column_name => $custom_name)
                <th class="sort" data-sort="{{$custom_name}}">{{ amicrud_form_labels($custom_name) }}</th>
                @empty
                @endforelse
                
            </tr>
        </thead>
                            <!-- Table Body -->
         <tbody class="list form-check-all">
            @forelse($list_contents as $k => $c)
            <tr data-id="{{ $c->id }}">
                <td scope="row">
                    {{$k+1}}
                </td>
                @forelse($display_field as $column_name => $custom_name)
                 <td>
                   @if ($formable[$column_name]['type']=='file')
                   <div class="flex-shrink-0">
                    <a href="{{asset($c->{$column_name})}}" target="_blank">
                    Open File
                    </a>
                  </div>
                   @elseif(in_array($column_name,['status','flow_status','action_status']))
                   <span class="btn badge bg-soft-{{ amicrud_status_class($c->{$column_name}) }} text-{{ amicrud_status_class($c->{$column_name}) }}">{{ $c->{$column_name} }}</span>
                   @elseif($formable[$column_name]['type']=='select')
                    {{ $c->{$column_name} ? amicrud_form_labels(ucfirst($formable[$column_name]['select_items'][$c->{$column_name}])) :null }}
                   @else 
                   {!! amicrud_form_labels($c->{$column_name}) !!}
                   @endif
                 </td>
                @empty
                @endforelse
            
            </tr>
            @empty
            @endforelse
        </tbody>
   </table>