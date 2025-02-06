<x-app-layout>

    <x-slot name="selectedMenu">
        {{""}}
    </x-slot>
    
    <div class="py-12">
        
        
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="d-flex justify-content-between">
                <h3 class="text-2xl">Import</h3>
            </div>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-3">
                <div class="container mx-auto px-4 py-4">
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
                    <form action="{{route('import')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="d-flex flex-row">
                            <div>
                                <label>Form:</label>
                                <select class="form-control" name="Form">
                                    <option value="Law">Laws and Frameworks</option>
                                    <option value="Industry">Industry References and Best Practices</option>
                                    <option value="Incident">Incidents and Announcements</option>
                                    <option value="DNS">DNS</option>
                                    <option value="VAPT">VAPT</option>
                                </select>
                            </div>
                            <div class="ml-2">
                                <label>File:</label><br>
                                <input type="file" name="file"/>
                            </div>
                            <div class="d-flex align-items-end">
                                <button class="btn btn-primary">Import</button>
                            </div>
                        </div>
                    </form>
                    
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{URL::to('custom/js/laws_frameworks.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</x-app-layout>
