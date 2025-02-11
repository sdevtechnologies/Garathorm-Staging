@foreach ($categories as $category)
    <tr>
        <td><input type="checkbox" name="selectedIds[]"  data-url="{{route('lawcategory.edit',$category)}}" value="{{ $category->id }}"></td>
        <td class="text-primary table-width">{{ $category->name }}</td></div>
    </tr>
@endforeach

