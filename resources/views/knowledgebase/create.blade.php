<x-app-layout>
    <x-slot name="selectedMenu">
        {{"knowledgebase"}}
    </x-slot>
    
    <link rel="stylesheet" href="{{URL::to('custom/css/announcement/edit-create.css')}}"/>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="d-flex justify-content-between">
                <h3 class="text-2xl">Knowledgebase</h3>
            </div>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-3">
                <div class="container mx-auto px-4 py-4">
                    <div class="text-right">
                        <a href="{{route('knowledgebases.index')}}" class="btn btn-danger"><i class="fa-solid fa-xmark pe-2"></i>Close</a>
                    </div>
                    @if ($errors->any())
                        <div class="mt-2">
                            <div class="alert alert-danger">
                                <ul class="m-1">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif
                    <form action="{{ route('knowledgebases.store') }}" method="POST" enctype="multipart/form-data">
                        <label class="fst-italic text-danger">Note: All fields mark with (*) are required.</label>
                        @csrf
                        <div class="mb-4">
                            <label for="title" class="fw-bold"><span class="text-danger">*</span>Title</label>
                            <div class="d-flex flex-row w-full pasteContainer">
                                <div class="w-full inputDiv">
                                    <input type="text" name="title"  value="{{ old('title') }}" placeholder="Title" id="title" class="form-control" required>
                                </div>
                                <div class="ml-2">
                                    <button type="button" class="btn btn-primary btn-paste">Paste</button>
                                </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-md-3">
                                <label for="category" class="fw-bold"><span class="text-danger">*</span>Category</label>
                                <select name="category" id="category" class="form-control" required>
                                    <option value="">Select Category</option>
                                    @foreach ($categories as $category)
                                        <option value="{{$category->id}}" {{ old('category')==$category->id ? "selected" : "" }}>{{$category->name}}</option>    
                                    @endforeach
                                    
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="assignusers" class="fw-bold"><span class="text-danger">*</span>Assign Users</label><br>
                                <select name="assignusers[]" id="assignusers" class="js-example-basic-multiple js-states form-control" multiple="multiple" >
                            
                                    @foreach ($users as $user)
                                        <option value="{{$user->id}}" {{ old('assignusers')==$user->id ? "selected" : "" }}>{{$user->name}}</option>    
                                    @endforeach
                                    
                                </select>
                            </div>
                            <div class="col-md-1">
                                <label for="mandatory" class="fw-bold"><span class="text-danger">*</span>Mandatory</label><br>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" value="1" name="mandatory" id="mandatoryyes" checked>
                                    <label class="form-check-label" for="mandatoryyes">
                                    Yes
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" value="0" name="mandatory" id="mandatoryno">
                                    <label class="form-check-label" for="mandatoryno">
                                    No
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-1">
                                <label for="status" class="fw-bold"><span class="text-danger">*</span>Status</label><br>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" value="0" name="status" id="statusyes" checked>
                                    <label class="form-check-label" for="statusyes">
                                    Pending
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" value="1" name="status" id="statusno">
                                    <label class="form-check-label" for="statusno">
                                    Completed
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-3 ml-3">
                                <label for="file" class="fw-bold">
                                    <span class="text-danger">*</span> Upload File
                                </label>

                                <input class="form-upload-file" type="file" name="image" id="image" 
                                    accept=".jpg, .jpeg, .gif, .txt, .pdf">

                                <small class="text-muted">Allowed formats: JPG, GIF, TXT, PDF</small>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label for="url" class="fw-bold"><span class="text-danger">*</span>URL Link</label>
                            <div class="d-flex flex-row w-full pasteContainer">
                                <div class="w-full inputDiv">
                                    <input type="text" name="url_link" value="{{ old('url_link') }}" id="url" placeholder="https://url.com" class="form-control">
                                </div>
                                <div class="ml-2">
                                    <button type="button" class="btn btn-primary" id="copyLink">Copy</button>
                                </div>
                                <div class="ml-1">
                                    <button type="button" class="btn btn-primary btn-paste">Paste</button>
                                </div>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label for="description" class="fw-bold"><span class="text-danger">*</span>Description</label>
                            <div class="d-flex flex-row w-full pasteContainer">
                                <div class="w-full inputDiv">
                                    <textarea rows="7" name="description" id="description"  placeholder="Add a short description" class="form-control h-full" required>{{ old('description') }}</textarea>
                                </div>
                                <div class="ml-2">
                                    <button type="button" class="btn btn-primary" id="copyDescription">Copy</button>
                                    
                                </div>
                                <div class="ml-1">
                                    <button type="button" class="btn btn-primary btn-paste">Paste</button>
                                </div>
                            </div>
                                    <!--<textarea name="description" id="description" rows="3" class="form-control" required></textarea>-->
                        </div>
                        <div class="d-flex justify-content-center">
                            <button type="submit" name="action" value="save" class="btn btn-primary w-25 ">Save</button>
                            <!--<button type="submit" name="action" value="save_notify_all" class="btn btn-primary w-25 ml-2">Save and Notify All</button>
                            <button type="submit" name="action" value="save_notify_admin" class="btn btn-primary w-25 ml-2">Save and Notify Admin</button>
                            -->
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.30.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>
    -->
    <!-- Popperjs -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" crossorigin="anonymous"></script>
    <!-- Tempus Dominus JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/@eonasdan/tempus-dominus@6.9.4/dist/js/tempus-dominus.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@eonasdan/tempus-dominus@6.7.16/dist/js/jQuery-provider.js"></script>
    <script type="module" src="{{URL::to('custom/js/date_picker.js')}}"></script>
    <script src="{{URL::to('custom/js/create_edit.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
</x-app-layout>