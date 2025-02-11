@foreach ($laws as $law)
    <tr>
    <td ><input type="checkbox" name="selectedIds[]"  data-url="{{route('incident.edit',$law)}}" value="{{ $law->id }}"></td>
        <td  class="text-primary title"><a target="_blank" href={{$law->url_link}}>{{ $law->title }}</a></td>
        <td class="category">
            {{$law->category->name}}
        </td>
        <td class="related">
            @foreach($law->relatedCategories as $category)
            {{ $category->name }}<br>
            @endforeach
            
        </td>
        <td class="description">{{ $law->description }}</td>
        <td class="publisher">{{ $law->published==1 ? 'Yes' : 'No' }}</td>
        <td class="publisher-name">{{ $law->publisher->name }}</td>
        <td class="date">{{ Carbon\Carbon::parse($law->date_incident)->format('d/M/Y') }}</td>
</tr>
@endforeach

