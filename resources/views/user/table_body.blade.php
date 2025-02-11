@foreach ($users as $user)
    <tr>
        <td><input type="checkbox" name="selectedIds[]"  data-url="{{route('user.edit',$user)}}" value="{{ $user->id }}"></td>
        <td class="text-primary name-width">{{ $user->name }}</td>
        <td class="name-width">{{ $user->email }}</td>
        <td class="role-width">{{$user->getRoleNames()}}</td>
    </tr>
@endforeach

