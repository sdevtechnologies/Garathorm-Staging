@foreach ($categories as $category)
    <tr>
        <td><input type="checkbox" name="selectedIds[]"  data-url="{{route('dnscategory.edit',$category)}}" value="{{ $category->id }}"></td>
        <td class="text-primary">{{ $category->name }}</td>
    </tr>
@endforeach

