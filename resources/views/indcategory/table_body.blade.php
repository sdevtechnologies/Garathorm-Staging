@foreach ($categories as $category)
    <tr>
        <td><input type="checkbox" name="selectedIds[]"  data-url="{{route('indcategory.edit',$category)}}" value="{{ $category->id }}"></td>
        <td style="width: 100%" class="text-primary">{{ $category->name }}</td>
    </tr>
@endforeach

