
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exports</title>
    <style>
        body {
    font-family: Arial, sans-serif;
     font-size: 12px; /* Adjust as needed */
}

.table-container {
    max-width: 100%;
    margin-bottom: 5px;
}

th, td {
    word-wrap: break-word;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 5px;
}

table, th, td {
    border: 1px solid #ddd;
}

th, td {
    padding: 5px;
    text-align: left;
}

th {
    background-color: #f2f2f2;
}

.company-header {
    text-align: center;
    margin-bottom: 20px;
}

.company-logo {
    max-width: 30px;
    max-height: 30px;
}

    </style>
</head>
<body>

<div class="table-container">
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
</div>
</div>

<!-- Add more tables or sections as needed -->

<!-- Page break for PDF export -->
{{-- <div class="page-break"></div> --}}

<!-- Another section or table -->

</body>
</html>

