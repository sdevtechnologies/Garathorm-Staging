@foreach ($knowledgebases as $knowledgebase)
    <tr>
        <td><input type="checkbox" name="selectedIds[]"  data-url="{{route('knowledgebase.edit',$knowledgebase)}}" value="{{ $knowledgebase->id }}"></td>
        <td style="width: 23%" class="text-primary"><a target="_blank" href={{$knowledgebase->url_link}}>{{ $knowledgebase->title }}</a></td>
        <td style="width: 15%">
           
            {{ $knowledgebase->category->name }}
        
            
        </td>
        <td style="width: 30%">{{ $knowledgebase->description }}</td>
        <td style="width: 15%">{{ $knowledgebase->publisher->name }}</td>
        <td style="width: 15%">{{ Carbon\Carbon::parse($knowledgebase->date_knowledgebase)->format('d/M/Y') }}</td>
    </tr>
@endforeach

