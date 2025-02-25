@foreach ($industries as $industry)
    <tr>
    <td class="td-checkbox"><input type="checkbox" name="selectedIds[]"  data-url="{{route('industry.edit',$industry)}}" value="{{ $industry->id }}"></td>
        <td  class="text-primary title"><a target="_blank" href={{$industry->url_link}}>{{ $industry->title }}</a></td>
        <td class="td-category">
            {{$industry->category->name}}
        </td>
        <td class="td-related">
            @foreach($industry->relatedCategories as $category)
            {{ $category->name }}<br>
            @endforeach
            
        </td>
        <td class="td-description">{{ $industry->description }}</td>
        <td class="td-publisher">{{ $industry->published==1 ? 'Yes' : 'No' }}</td>
        <td class="td-publisher-name">{{ $industry->publisher->name }}</td>
        <td class="td-date">{{ Carbon\Carbon::parse($industry->date_incident)->format('d/M/Y') }}</td></tr>
@endforeach

