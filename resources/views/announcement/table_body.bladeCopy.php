@foreach ($announcements as $announcement)
    <tr>
        <td><input type="checkbox" name="selectedIds[]"  data-url="{{route('announcement.edit',$announcement)}}" value="{{ $announcement->id }}"></td>
        <td style="width: 23%" class="text-primary"><a target="_blank" href={{$announcement->url_link}}>{{ $announcement->title }}</a></td>
        <td style="width: 15%">
           
            {{ $announcement->category->name }}
        
            
        </td>
        <td style="width: 30%">{{ $announcement->description }}</td>
        <td style="width: 15%">{{ $announcement->publisher->name }}</td>
        <td style="width: 15%">{{ Carbon\Carbon::parse($announcement->date_announcement)->format('d/M/Y') }}</td>
    </tr>
@endforeach

