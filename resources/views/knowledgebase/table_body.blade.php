@foreach ($knowledgebases as $knowledgebase)

    @if(Auth::check() && Auth::user()->hasRole('admin'))
     <!-- This is for For Users -->
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
        <td style="width: 11%; color:#0c6fff;">Files</td>

        <td style="width: 11%">{{ $knowledgebase->mandatory==1 ? 'Yes' : 'No' }}</td>
        <td style="width: 4%"> </td>
        <td class="dropdown" style="width: 13%">
            <button class="btn btn-secondary" type="button" id="statusDropdown{{ $knowledgebase->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                {{ $knowledgebase->status ?? 'Pending' }}
            </button>
            <ul class="dropdown-menu show-on-left" aria-labelledby="statusDropdown{{ $knowledgebase->id }}">
                <li><a class="dropdown-item change-status" href="#" data-id="{{ $knowledgebase->id }}" data-status="Pending">Pending</a></li>
                <li><a class="dropdown-item change-status" href="#" data-id="{{ $knowledgebase->id }}" data-status="Completed">Completed</a></li>
            </ul>
        </td>
    </tr>

    @else <!-- This is for admin -->
    <tr>
        <td style="width: 2%"><input type="checkbox" name="selectedIds[]"  data-url="{{route('knowledgebases.edit',$knowledgebase)}}" value="{{ $knowledgebase->id }}"></td>
        <td style="width: 8%" > Client Name</td>
        <td style="width: 15%" class="text-primary"><a target="_blank" href={{$knowledgebase->url_link}}>{{ $knowledgebase->title }}</a></td>
        <td style="width: 10%">
            {{$knowledgebase->category->name}}
        </td>
        <td style="width: 15%">
            @foreach($knowledgebase->relatedCategories as $category)
            {{ $category->name }}<br>
            @endforeach
            
        </td>
        <td style="overflow: hidden;
        width: 100%;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;">{{ $knowledgebase->description }}</td>
        <td style="width: 12%; color:#0c6fff;">Files</td>

        <td style="width: 5%">{{ $knowledgebase->mandatory==1 ? 'Yes' : 'No' }}</td>
        <td style="width: 4%"> </td>
        <td class="dropdown" style="width: 13%">
            <button class="btn btn-secondary" type="button" id="statusDropdown{{ $knowledgebase->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                {{ $knowledgebase->status ?? 'Pending' }}
            </button>
            <ul class="dropdown-menu show-on-left" aria-labelledby="statusDropdown{{ $knowledgebase->id }}">
                <li><a class="dropdown-item change-status" href="#" data-id="{{ $knowledgebase->id }}" data-status="Pending">Pending</a></li>
                <li><a class="dropdown-item change-status" href="#" data-id="{{ $knowledgebase->id }}" data-status="Completed">Completed</a></li>
            </ul>
        </td>
    </tr>
    @endif
    <style> 
        .show-on-left {
            position: absolute;
            top: 0;
            right: 100%; /* Moves the dropdown to the left */
            display: none; /* Hidden by default */
            white-space: nowrap; /* Keeps items in a single row */
            background: white;
            padding: 5px;
            border-radius: 5px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        }

        .dropdown:hover .show-on-left {
            display: flex; /* Show when hovering/clicking */
            gap: 10px; /* Adds space between items */
        }

        /* Disable button when dropdown is visible */
        .dropdown:hover button {
            pointer-events: none; /* Disable clicks */
        }

        /* Add color styles for Pending and Completed */
        .show-on-left .dropdown-item[data-status="Pending"] {
            color: #0d6fff; /* Blue */
        }

        .show-on-left .dropdown-item[data-status="Completed"] {
            color: #303030; /* Dark Gray */
        }
    </style>
    <script> 
        document.querySelectorAll('.change-status').forEach(item => {
            item.addEventListener('click', function(event) {
                event.preventDefault();
                const status = item.getAttribute('data-status');
                const button = item.closest('.dropdown').querySelector('button');
                
                // Change the text of the button to the selected status
                button.textContent = status;

                // Change the color based on the selected status
                if (status === 'Pending') {
                    button.style.backgroundColor = '#0d6fff'; // Blue
                } else if (status === 'Completed') {
                    button.style.backgroundColor = '#60ad3e'; // Dark Gray
                }
            });
        });
    </script>

@endforeach