@foreach ($categories as $category)
    <tr>
        <td><input type="checkbox" name="selectedIds[]"  data-url="{{route('inccategory.edit',$category)}}" value="{{ $category->id }}"></td>
        <td class="text-primary table-width">{{ $category->name }}</td>
    </tr>
@endforeach

