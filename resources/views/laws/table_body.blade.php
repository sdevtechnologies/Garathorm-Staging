@foreach ($laws as $law)
    <tr>
    <td class="td-checkbox"><input type="checkbox" name="selectedIds[]"  data-url="{{route('laws.edit',$law)}}" value="{{ $law->id }}"></td>
        <td  class="text-primary td-title"><a target="_blank" href={{$law->url_link}}>{{ $law->title }}</a></td>
        <td class="td-category">
            {{$law->category->name}}
        </td>
        <td class="td-related">
            @foreach($law->relatedCategories as $category)
            {{ $category->name }}<br>
            @endforeach
            
        </td>
        <td class="td-description">{{ $law->description }}</td>
        <td class="td-publisher">{{ $law->published==1 ? 'Yes' : 'No' }}</td>
        <td class="td-publisher-name">{{ $law->publisher->name }}</td>
        <td class="td-date">{{ Carbon\Carbon::parse($law->date_incident)->format('d/M/Y') }}</td>
</tr>
@endforeach

