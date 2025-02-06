@foreach ($laws as $law)
    <tr>
        <td style="width: 2%"><input type="checkbox" name="selectedIds[]"  data-url="{{route('laws.edit',$law)}}" value="{{ $law->id }}"></td>
        <td style="width: 18%" class="text-primary" ><a target="_blank" href={{$law->url_link}}>{{ $law->title }}</a></td>
        <td style="width: 10%">
            {{$law->category->name}}
        </td>
        <td style="width: 10%">
            
            @foreach($law->relatedCategories as $category)
                {{ $category->name }}
            <br>
            @endforeach
            
        </td>
        <td style="overflow: hidden;
    width: 100%;
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;">{{ $law->description}}</td>
        <td style="width: 5%">{{ $law->published==1 ? 'Yes' : 'No' }}</td>
        <td style="width: 15%">{{ $law->publisher->name }}</td>
        <td style="width: 15%">{{ Carbon\Carbon::parse($law->date_published)->format('d/M/Y') }}</td>
    </tr>
@endforeach

