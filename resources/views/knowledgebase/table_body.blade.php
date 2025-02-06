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
        <td style="width: 5%">{{ $knowledgebase->mandatory==1 ? 'Yes' : 'No' }}</td>
    </tr>
@endforeach

