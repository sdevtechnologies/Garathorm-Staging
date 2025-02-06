@foreach ($laws as $law)
    <tr>
        <td><input type="checkbox" name="selectedIds[]"  data-url="{{route('laws.edit',$law)}}" value="{{ $law->id }}"></td>
        <td style="width: 23%" class="text-primary" ><a target="_blank" href={{$law->url_link}}>{{ $law->title }}</a></td>
        <td style="width: 15%">
            
            {{ $law->category->name }}<br>
           
            
        </td>
        <td style="width: 30%">{{ $law->description}}</td>
        <td style="width: 15%">{{ $law->publisher->name }}</td>
        <td style="width: 15%">{{ Carbon\Carbon::parse($law->date_published)->format('d/M/Y') }}</td>
    </tr>
@endforeach

