@foreach ($VAPTs as $VAPT)
    <tr>
        <td><input type="checkbox" name="selectedIds[]"  data-url="{{route('VAPT.edit',$VAPT)}}" value="{{ $VAPT->id }}"></td>
        <td class="text-primary name-width"><a target="_blank" href={{$VAPT->url_link}}>{{ $VAPT->title }}</a></td>
        <td class="cat-width">{{ $VAPT->category }}</td>
        <td class="name-width">{{ $VAPT->description }}</td>
        <td class="cat-width">{{ Carbon\Carbon::parse($VAPT->date_issue)->format('d/M/Y') }}</td>
    </tr>
@endforeach

