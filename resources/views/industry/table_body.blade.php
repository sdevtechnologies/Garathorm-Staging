@foreach ($industries as $industry)
    <tr>
    <td ><input type="checkbox" name="selectedIds[]"  data-url="{{route('incident.edit',$industry)}}" value="{{ $industry->id }}"></td>
        <td  class="text-primary title"><a target="_blank" href={{$industry->url_link}}>{{ $industry->title }}</a></td>
        <td class="category">
            {{$industry->category->name}}
        </td>
        <td class="related">
            @foreach($industry->relatedCategories as $category)
            {{ $category->name }}<br>
            @endforeach
            
        </td>
        <td class="description">{{ $industry->description }}</td>
        <td class="publisher">{{ $industry->published==1 ? 'Yes' : 'No' }}</td>
        <td class="publisher-name">{{ $industry->publisher->name }}</td>
        <td class="date">{{ Carbon\Carbon::parse($industry->date_incident)->format('d/M/Y') }}</td></tr>
@endforeach

