<div class="table-responsive table-card mt-3 mb-1">
    <table class="table align-middle table-nowrap" id="amicrudTable" >
        <!-- Table Head -->
        <thead class="table-light">
            <tr>
                <th scope="col" style="width: 50px;">#</th>
                @forelse($display_field as $column_name => $custom_name)
                <th class="sort" data-sort="{{$custom_name}}">{{ amicrud_form_labels($custom_name) }}</th>
                @empty
                @endforelse
                @if(isset($show_actions) && $show_actions)
                <th class="sort" data-sort="action">Action</th>
                @endif
                
            </tr>
        </thead>
                            <!-- Table Body -->
         <tbody class="list form-check-all">
           @include('amicrud::amicrud.table.table')
        </tbody>
   </table>
</div>

@if ($list_contents->count() && ($list_contents instanceof \Illuminate\Pagination\LengthAwarePaginator))
<div class="d-flex justify-content-end">
    <div class="pagination">
                 {{ $list_contents->links('amicrud::vendor.pagination.bootstrap-4') }}  
    </div>
</div>
@endif