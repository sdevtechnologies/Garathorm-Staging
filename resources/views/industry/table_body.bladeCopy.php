@foreach ($industries as $industry)
    <tr>
        <td><input type="checkbox" name="selectedIds[]"  data-url="{{route('industry.edit',$industry)}}" value="{{ $industry->id }}"></td>
        <td style="width: 23%" class="text-primary"><a target="_blank" href={{$industry->url_link}}>{{ $industry->title }}</a></td>
        <td style="width: 15%">
            {{ $industry->category->name }}
            
        </td>
        <td style="width: 30%">{{ $industry->description }}</td>
        <td style="width: 15%">{{ $industry->publisher->name }}</td>
        <td style="width: 15%">{{ Carbon\Carbon::parse($industry->date_published)->format('d/M/Y') }}</td>
    </tr>
@endforeach

