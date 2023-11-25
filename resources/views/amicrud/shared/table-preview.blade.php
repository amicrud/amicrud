<style>
    .review-table-th {
      background: #515b7d;
      color: #eee;
    }
</style>   
@if ($record  instanceof \Illuminate\Support\Collection)


@forelse ($record as $k => $item)
@php
$modelAttributes = $item->getAttributes();
$columns = array_keys($modelAttributes);
$values = array_values($modelAttributes);
$numColumnsPerSet = $perRow; // Set the desired number of columns per set
$rowCount = ceil(count($columns) / $numColumnsPerSet);
@endphp
<div class="card">
<div class="card-body">
    <div class="table-responsive">
      <table class="table table-bordered border-primary table-nowrap align-middle mb-0">
 <h4>#{{$k+1}}.</h4>
    @for ($i = 0; $i < $rowCount; $i++)
        <thead>
        <tr class="review-table-th">
            @for ($j = $i * $numColumnsPerSet; $j < min(($i * $numColumnsPerSet) + $numColumnsPerSet, count($columns)); $j++)
                <th>{{ form_labels($columns[$j]) }}</th>
            @endfor
        </tr>
        </thead>
        <tbody>
        <tr>
            @for ($j = $i * $numColumnsPerSet; $j < min(($i * $numColumnsPerSet) + $numColumnsPerSet, count($columns)); $j++)
            <td>
            @if (in_array($columns[$j],$files))
            <a href="{{asset($values[$j])}}" class="btn btn-sm btn-outline-primary btn-icon-text" target="_blank"><i class="ri-gallery-line  fs-16"></i> view</a>
            @else
            {{ form_labels($values[$j]) }}
            @endif 
            </td>
            @endfor
        </tr>
      </tbody>
     
    @endfor
</table>
</div>
</div>
</div>
@empty
@endforelse
    



@else

@php
    $modelAttributes = $record->getAttributes();
    $columns = array_keys($modelAttributes);
    $values = array_values($modelAttributes);
    $numColumnsPerSet = $perRow; // Set the desired number of columns per set
    $rowCount = ceil(count($columns) / $numColumnsPerSet);
@endphp
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered border-primary table-nowrap align-middle mb-0">

        @for ($i = 0; $i < $rowCount; $i++)
            <thead>
            <tr class="review-table-th">
                @for ($j = $i * $numColumnsPerSet; $j < min(($i * $numColumnsPerSet) + $numColumnsPerSet, count($columns)); $j++)
                    <th>{{ form_labels($columns[$j]) }}</th>
                @endfor
            </tr>
            </thead>
            <tbody>
            <tr>
                @for ($j = $i * $numColumnsPerSet; $j < min(($i * $numColumnsPerSet) + $numColumnsPerSet, count($columns)); $j++)
                <td>
                @if (in_array($columns[$j],$files))
                <a href="{{asset($values[$j])}}" class="btn btn-sm btn-outline-primary btn-icon-text" target="_blank"><i class="ri-gallery-line  fs-16"></i> view</a>
                @else
                {{ form_labels($values[$j]) }}
                @endif 
                </td>
                @endfor
            </tr>
          </tbody>
         
        @endfor
    </table>
</div>
</div>
</div>

@endif
