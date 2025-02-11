@foreach ($announcements as $announcement)
    <tr class="announcement-table">
        <td class="announcement-checkbox"><input type="checkbox" name="selectedIds[]"  data-url="{{route('announcement.edit',$announcement)}}" value="{{ $announcement->id }}"></td>
        <td  class="text-primary announcement-title"><a target="_blank" href={{$announcement->url_link}}>{{ $announcement->title }}</a></td>
        <td  class="announcement-category">
            {{$announcement->category->name}}
        </td>
        <td class="announcement-related">
            @foreach($announcement->relatedCategories as $category)
            {{ $category->name }}<br>
            @endforeach
            
        </td>
        <td class="announcement-description">{{ $announcement->description }}</td>
        <td class="announcement-publisher">{{ $announcement->published==1 ? 'Yes' : 'No' }}</td>
        <td class="announcement-publisher-name">{{ $announcement->publisher->name }}</td>
        <td class="announcement-date">{{ Carbon\Carbon::parse($announcement->date_announcement)->format('d/M/Y') }}</td>
    </tr>
@endforeach

