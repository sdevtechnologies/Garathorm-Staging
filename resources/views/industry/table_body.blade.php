@foreach ($industries as $industry)
    <tr>
        <td style="width: 2%"><input type="checkbox" name="selectedIds[]"  data-url="{{route('industry.edit',$industry)}}" value="{{ $industry->id }}"></td>
        <td style="width: 18%" class="text-primary"><a target="_blank" href={{$industry->url_link}}>{{ $industry->title }}</a></td>
        <td style="width: 10%">
            {{$industry->category->name}}
        </td><td style="width: 10%">
            @foreach($industry->relatedCategories as $category)
            {{ $category->name }}<br>
            @endforeach
            
        </td>
        <td style="overflow: hidden;
        width: 100%;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;">{{ $industry->description }}</td>
        <td style="width: 5%">{{ $industry->published==1 ? 'Yes' : 'No' }}</td>
        <td style="width: 15%">{{ $industry->publisher->name }}</td>
        <td style="width: 15%">{{ Carbon\Carbon::parse($industry->date_published)->format('d/M/Y') }}</td>
    </tr>
@endforeach

