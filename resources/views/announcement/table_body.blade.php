@foreach ($announcements as $announcement)
    <tr>
        <td style="width: 2%"><input type="checkbox" name="selectedIds[]"  data-url="{{route('announcement.edit',$announcement)}}" value="{{ $announcement->id }}"></td>
        <td style="width: 18%" class="text-primary"><a target="_blank" href={{$announcement->url_link}}>{{ $announcement->title }}</a></td>
        <td style="width: 10%">
            {{$announcement->category->name}}
        </td>
        <td style="width: 10%">
            @foreach($announcement->relatedCategories as $category)
            {{ $category->name }}<br>
            @endforeach
            
        </td>
        <td style="overflow: hidden;
        width: 100%;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;">{{ $announcement->description }}</td>
        <td style="width: 5%">{{ $announcement->published==1 ? 'Yes' : 'No' }}</td>
        <td style="width: 15%">{{ $announcement->publisher->name }}</td>
        <td style="width: 15%">{{ Carbon\Carbon::parse($announcement->date_announcement)->format('d/M/Y') }}</td>
    </tr>
@endforeach

