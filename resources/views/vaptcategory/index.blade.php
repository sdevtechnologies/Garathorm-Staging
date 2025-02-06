<x-app-layout>

    <x-slot name="selectedMenu">
        {{"VAPCat"}}
    </x-slot>
    
    <div class="py-12">
        
        
        <div class="mx-auto sm:px-6 lg:px-8">
            <div class="d-flex justify-content-between">
                <h3 class="text-2xl">Category - VAPT</h3>
                <a class="btn btn-light-green" href="{{ route('vaptcategory.create') }}"><i class="fa-solid fa-plus pe-1"></i>Add Category</a>
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
                        <a class="btn btn-primary m-1" id="viewModeButton"><i class="fa-regular fa-eye pe-2"></i>View</a>
                        <a class="btn btn-danger m-1" id="deleteModeButton"><i class="fa-solid fa-trash pe-2"></i></i>Remove</a>
                        <form id="deleteSelectedForm" action="{{ route('vaptcategory.deleteSelected') }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" id="selectedIds" name="selectedIds">
                            
                        </form>
                    
                        <form action="{{ route('vaptcategory.index') }}" method="GET" class="flex-fill">
                            <div class="flex items-center">
                                <input type="text" name="search" value'="{{$search}}"
                                    class="border-gray-300 m-1 w-auto focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm flex-1 mr-2 py-1 px-2"
                                    placeholder="Search...">
                            </div>
                        </form>
                    </div>
                    
                    
                    <table class="w-full mt-4 table">
                        <thead>
                            <tr>
                                <th ></th>
                                <th >@sortablelink('name','Category Name')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @include('vaptcategory.table_body')
                        </tbody>
                    </table>
                    
                    {{ $categories->links()}}
                        
                    
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{URL::to('custom/js/laws_frameworks.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</x-app-layout>
