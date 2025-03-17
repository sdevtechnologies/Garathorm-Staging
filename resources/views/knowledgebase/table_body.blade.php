@foreach ($knowledgebases as $knowledgebase)
    <tr>
        <td ><input type="checkbox" name="selectedIds[]"  data-url="{{route('knowledgebases.edit',$knowledgebase)}}" value="{{ $knowledgebase->id }}"></td>
        <td  class="text-primary title"><a target="_blank" href={{$knowledgebase->url_link}}>{{ $knowledgebase->title }}</a></td>
        <td class="category">
            {{$knowledgebase->category->name}}
        </td>
        <td class="col-description" >{{ $knowledgebase->description }}</td>
        <td ></td>
        <td class="file">
            @php         
            $fullPath = $knowledgebase->image; 
            $parts = explode("knowledgebase/", $fullPath);
            $filename = end($parts);
            @endphp

            @if($filename)
                <a href="/{{$knowledgebase->image}}" >{{$filename}}</a>
            @else
                No File
            @endif
        </td>

        <td class="mandatory" >{{ $knowledgebase->mandatory==1 ? 'Yes' : 'No' }}</td>

        <td class="assigned-users">
            @foreach($knowledgebase->relatedCategories as $category)
            {{$category->name}}<br>
            @endforeach
        </td>
        <td class="dropdown status" >
            <button class="btn btn-secondary" type="button" id="statusDropdown{{ $knowledgebase->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                {{ $knowledgebase->status == 0 ? 'Pending' : 'Completed' }}
            </button>
            <!-- <ul class="dropdown-menu show-on-left" aria-labelledby="statusDropdown{{ $knowledgebase->id }}">
                <li><a class="dropdown-item change-status" href="#" data-id="{{ $knowledgebase->id }}" data-status="Pending">Pending</a></li>
                <li><a class="dropdown-item change-status" href="#" data-id="{{ $knowledgebase->id }}" data-status="Completed">Completed</a></li>
            </ul> -->
        </td>
    
    </tr>
@endforeach
 
