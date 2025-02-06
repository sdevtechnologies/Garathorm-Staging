@foreach ($DNSs as $DNS)
    <tr>
        <td><input type="checkbox" name="selectedIds[]"  data-url="{{route('DNS.edit',$DNS)}}" value="{{ $DNS->id }}"></td>
        <td style="width: 30%" class="text-primary"><a target="_blank" href={{$DNS->url_link}}>{{ $DNS->title }}</a></td>
        <td style="width: 20%">{{ $DNS->category }}</td>
        <td style="width: 30%">{{ $DNS->description }}</td>
        <td style="width: 20%">{{ Carbon\Carbon::parse($DNS->date_issue)->format('d/M/Y') }}</td>
    </tr>
@endforeach

