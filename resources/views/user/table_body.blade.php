@foreach ($users as $user)
    <tr>
        <td><input type="checkbox" name="selectedIds[]"  data-url="{{route('user.edit',$user)}}" value="{{ $user->id }}"></td>
        <td style="width: 35%" class="text-primary">{{ $user->name }}</td>
        <td style="width: 35%">{{ $user->email }}</td>
        <td style="width: 30%">{{$user->getRoleNames()}}</td>
    </tr>
@endforeach

