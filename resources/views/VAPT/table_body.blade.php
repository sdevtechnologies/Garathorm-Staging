@foreach ($VAPTs as $VAPT)
    <tr>
        <td><input type="checkbox" name="selectedIds[]"  data-url="{{route('VAPT.edit',$VAPT)}}" value="{{ $VAPT->id }}"></td>
        <td style="width: 30%" class="text-primary"><a target="_blank" href={{$VAPT->url_link}}>{{ $VAPT->title }}</a></td>
        <td style="width: 20%">{{ $VAPT->category }}</td>
        <td style="width: 30%">{{ $VAPT->description }}</td>
        <td style="width: 20%">{{ Carbon\Carbon::parse($VAPT->date_issue)->format('d/M/Y') }}</td>
    </tr>
@endforeach

