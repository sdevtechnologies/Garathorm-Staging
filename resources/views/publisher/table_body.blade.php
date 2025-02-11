@foreach ($publishers as $publisher)
    <tr>
        <td><input type="checkbox" name="selectedIds[]"  data-url="{{route('publisher.edit',$publisher)}}" value="{{ $publisher->id }}"></td>
        <td class="text-primary table-width">{{ $publisher->name }}</td>
    </tr>
@endforeach

