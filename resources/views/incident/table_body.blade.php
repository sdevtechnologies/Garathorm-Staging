@foreach ($incidents as $incident)
    <tr>
        <td ><input type="checkbox" name="selectedIds[]"  data-url="{{route('incident.edit',$incident)}}" value="{{ $incident->id }}"></td>
        <td  class="text-primary title"><a target="_blank" href={{$incident->url_link}}>{{ $incident->title }}</a></td>
        <td class="category">
            {{$incident->category->name}}
        </td>
        <td class="related">
            @foreach($incident->relatedCategories as $category)
            {{ $category->name }}<br>
            @endforeach
            
        </td>
        <td class="description">{{ $incident->description }}</td>
        <td class="publisher">{{ $incident->published==1 ? 'Yes' : 'No' }}</td>
        <td class="publisher-name">{{ $incident->publisher->name }}</td>
        <td class="date">{{ Carbon\Carbon::parse($incident->date_incident)->format('d/M/Y') }}</td>
    </tr>
@endforeach

