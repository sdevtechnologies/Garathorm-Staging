<x-app-layout>

    <x-slot name="selectedMenu">
        {{"Incident"}}
    </x-slot>
    <link rel="stylesheet" href="{{URL::to('custom/css/table-header.css')}}"/>
 
    <div class="py-12">
        
        
        <div class="mx-auto sm:px-6 lg:px-8">
            <div class="d-flex justify-content-between">
                <h3 class="text-2xl">Incidents and Announcements</h3>
                <a class="btn btn-light-green" href="{{ route('incident.create') }}"><i class="fa-solid fa-plus pe-1"></i>Add Incidents and Announcements</a>
            </div>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-3">
                <div class=" mx-auto px-4 py-4">
                    @if(session()->has('success'))
                        <div class="alert alert-success" role="alert">
                            <i class="fa-solid fa-circle-check pe-3"></i>
                            {{session()->get('success')}}
                        </div>
                    @endif
                    @if(session()->has('error'))
                        <div class="alert alert-danger" role="alert">
                            <i class="fa-solid fa-circle-xmark pe-3"></i>
                            {{session()->get('error')}}
                        </div>
                    @endif
                    <div class="d-flex flex-row">
                        <a class="btn btn-primary m-1" id="AllButton" href="{{ route('incident.index')}}" >All</a> 
                        <a class="btn btn-primary m-1" id="whatsNewButton" href="{{ route('incident.whatsnewindex')}}" >What's New</a> 
                        <a class="btn btn-primary m-1" id="viewModeButton"><i class="fa-regular fa-eye pe-2"></i>View/Edit</a>
                        <form id="copySelectedForm" action="{{route('incident.copySelected') }}" method="POST">
                            @csrf
                            <input type="hidden" id="selectedCopyIds" name="selectedCopyIds">
                            
                        </form>
                        <button id="copySelectedItems"
                            class="btn btn-primary m-1"><i class="fa-regular fa-copy pe-2"></i>Copy Selected</button>
                        <a class="btn btn-danger m-1" id="deleteModeButton"><i class="fa-solid fa-trash pe-2"></i></i>Remove</a>
                        <form id="deleteSelectedForm" action="{{ route('incident.deleteSelected') }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" id="selectedIds" name="selectedIds">
                            
                        </form>
                    
                        <form action="{{ url()->current() }}" method="GET" class="flex-fill">
                            <div class="flex items-center">
                                <input type="text" name="search" value="{{$search}}"
                                    class="border-gray-300 m-1 w-auto focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm flex-1 mr-2 py-1 px-2"
                                    placeholder="Search...">
                            </div>
                        </form>
                    </div>
                    <table class="w-full mt-4 table">
                        <thead>
                            <tr class="table-header-row">
                                <th class="th-checkbox"></th> <!-- Add this for alignment -->
                                <th class="th-title">@sortablelink('title')</th>
                                <th class="th-category">@sortablelink('category.name','Category')</th>
                                <th class="th-related">Related Category</th>
                                <th class="th-col-description">Description</th>
                                
                                <th class="th-publisher">@sortablelink('published','Publish')
                                </th>
                                <th class="th-publisher-name">@sortablelink('publisher.name','Publisher')</th>
                                <th class="th-date-incident">@sortablelink('date_incident','Date of Incident')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @include('incident.table_body')
                        </tbody>
                    </table>
		    </div>
                    
                    {{ $incidents->appends(\Request::except('page'))->render() }}
                        
                    
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{URL::to('custom/js/laws_frameworks.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</x-app-layout>