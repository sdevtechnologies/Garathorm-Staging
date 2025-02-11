@foreach ($DNSs as $DNS)
    <tr>
        <td><input type="checkbox" name="selectedIds[]"  data-url="{{route('DNS.edit',$DNS)}}" value="{{ $DNS->id }}"></td>
        <td class="text-primary name-width"><a target="_blank" href={{$DNS->url_link}}>{{ $DNS->title }}</a></td>
        <td class="cat-width">{{ $DNS->category }}</td>
        <td class="name-width">{{ $DNS->description }}</td>
        <td class="cat-width">{{ Carbon\Carbon::parse($DNS->date_issue)->format('d/M/Y') }}</td>
    </tr>
@endforeach

