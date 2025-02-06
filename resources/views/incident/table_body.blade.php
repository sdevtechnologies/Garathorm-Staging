@foreach ($incidents as $incident)
    <tr>
        <td style="width: 2%"><input type="checkbox" name="selectedIds[]"  data-url="{{route('incident.edit',$incident)}}" value="{{ $incident->id }}"></td>
        <td style="width: 18%" class="text-primary"><a target="_blank" href={{$incident->url_link}}>{{ $incident->title }}</a></td>
        <td style="width: 10%">
            {{$incident->category->name}}
        </td>
        <td style="width: 10%">
            @foreach($incident->relatedCategories as $category)
            {{ $category->name }}<br>
            @endforeach
            
        </td>
        <td style="overflow: hidden;
        width: 100%;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;">{{ $incident->description }}</td>
        <td style="width: 5%">{{ $incident->published==1 ? 'Yes' : 'No' }}</td>
        <td style="width: 15%">{{ $incident->publisher->name }}</td>
        <td style="width: 15%">{{ Carbon\Carbon::parse($incident->date_incident)->format('d/M/Y') }}</td>
    </tr>
@endforeach

