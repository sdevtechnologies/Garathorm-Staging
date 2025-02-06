@foreach ($incidents as $incident)
    <tr>
        <td><input type="checkbox" name="selectedIds[]"  data-url="{{route('incident.edit',$incident)}}" value="{{ $incident->id }}"></td>
        <td style="width: 23%" class="text-primary"><a target="_blank" href={{$incident->url_link}}>{{ $incident->title }}</a></td>
        <td style="width: 15%">
           
            {{ $incident->category->name }}
        
            
        </td>
        <td style="width: 30%">{{ $incident->description }}</td>
        <td style="width: 15%">{{ $incident->publisher->name }}</td>
        <td style="width: 15%">{{ Carbon\Carbon::parse($incident->date_incident)->format('d/M/Y') }}</td>
    </tr>
@endforeach

