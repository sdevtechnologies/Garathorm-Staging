@foreach ($publishers as $publisher)
    <tr>
        <td><input type="checkbox" name="selectedIds[]"  data-url="{{route('publisher.edit',$publisher)}}" value="{{ $publisher->id }}"></td>
        <td style="width: 100%" class="text-primary">{{ $publisher->name }}</td>
    </tr>
@endforeach

