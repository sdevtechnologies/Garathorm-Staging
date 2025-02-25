@foreach ($incidents as $incident)
    <tr>
        
        <td class="td-checkbox"><input type="checkbox" name="selectedIds[]"  data-url="{{route('incident.edit',$incident)}}" value="{{ $incident->id }}"></td>
        <td  class="text-primary td-title"><a target="_blank" href={{$incident->url_link}}>{{ $incident->title }}</a></td>
        <td class="td-category">
            {{$incident->category->name}}
        </td>
        <td class="td-related">
            @foreach($incident->relatedCategories as $category)
            {{ $category->name }}<br>
            @endforeach
            
        </td>
        <td class="td-description">{{ $incident->description }}</td>
        <td class="td-publisher">{{ $incident->published==1 ? 'Yes' : 'No' }}</td>
        <td class="td-publisher-name">{{ $incident->publisher->name }}</td>
        <td class="td-date">{{ Carbon\Carbon::parse($incident->date_incident)->format('d/M/Y') }}</td>
    </tr>
@endforeach

