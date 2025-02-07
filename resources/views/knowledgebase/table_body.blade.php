@foreach ($knowledgebases as $knowledgebase)
    <tr>
        <td style="width: 2%"><input type="checkbox" name="selectedIds[]"  data-url="{{route('knowledgebases.edit',$knowledgebase)}}" value="{{ $knowledgebase->id }}"></td>
        <td style="width: 18%" class="text-primary"><a target="_blank" href={{$knowledgebase->url_link}}>{{ $knowledgebase->title }}</a></td>
        <td style="width: 10%">
            {{$knowledgebase->category->name}}
        </td>
        <td style="width: 10%">
            @foreach($knowledgebase->relatedCategories as $category)
            {{ $category->name }}<br>
            @endforeach
            
        </td>
        <td style="overflow: hidden;
        width: 100%;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;">{{ $knowledgebase->description }}</td>

        <td style="width: 15%">{{ $knowledgebase->mandatory==1 ? 'Yes' : 'No' }}</td>
        <td style="width: 10%">
        @foreach($knowledgebase->relatedCategories as $category)
        <div class="dropdown">
        <button class="btn btn-secondary dropdown-toggle" type="button" id="statusDropdown{{ $knowledgebase->id }}" data-bs-toggle="dropdown" aria-expanded="false">
            {{ $category->status == 0 ? "Pending" : "Complete"}}<br>
        </button>
        <ul class="dropdown-menu" aria-labelledby="statusDropdown{{ $knowledgebase->id }}">
            <li><a class="dropdown-item change-status" href="#" data-id="{{ $category->status }}" data-status="Pending">Pending</a></li>
            <li><a class="dropdown-item change-status" href="#" data-id="{{ $category->status }}" data-status="Completed">Completed</a></li>
        </ul>
        </div>
        @endforeach
        </td>
    </tr>
@endforeach
