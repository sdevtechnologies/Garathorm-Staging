<x-app-layout>
    <x-slot name="selectedMenu">
        {{"Incident"}}
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="d-flex justify-content-between">
                <h3 class="text-2xl">Incidents and Announcements</h3>
            </div>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-3">
                <div class="container mx-auto px-4 py-4">
                    <div class="text-right">
                        <a href="{{route('incident.index')}}" class="btn btn-danger"><i class="fa-solid fa-xmark pe-2"></i>Close</a>
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
                    <form action="{{ route('incident.store') }}" method="POST">
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
                                <select name="category" id="category" class="form-control" style="width: 100%" required>
                                    <option value="">Select Category</option>
                                    @foreach ($categories as $category)
                                        <option value="{{$category->id}}" {{ old('category')==$category->id ? "selected" : "" }}>{{$category->name}}</option>    
                                    @endforeach
                                    
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="relatedcategory" class="fw-bold">Related Category</label><br>
                                <select name="relatedcategory[]" id="relatedcategory" class="js-example-basic-multiple js-states form-control" multiple="multiple" style="width:100%;">
                            
                                    @foreach ($categories as $category)
                                        <option value="{{$category->id}}" {{ old('relatedcategory')==$category->id ? "selected" : "" }}>{{$category->name}}</option>    
                                    @endforeach
                                    
                                </select>
                            </div>
                            <div class="col-md-1">
                                <label for="published" class="fw-bold"><span class="text-danger">*</span>Publish</label><br>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" value="1" name="published" id="publishedyes" checked>
                                    <label class="form-check-label" for="publishedyes">
                                    Yes
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" value="0" name="published" id="publishedno">
                                    <label class="form-check-label" for="publishedno">
                                    No
                                    </label>
                                </div>
                                
                            </div>
                            <div class="col-md-3">
                                <label for="publisher" class="fw-bold"><span class="text-danger">*</span>Publisher</label>
                                <select name="publisher" id="publisher" class="form-control" style="width: 100%" required>
                                    <option value="">Select Publisher</option>
                                    @foreach ($publishers as $publisher)
                                        <option value="{{$publisher->id}}" {{ old('publisher')==$publisher->id ? "selected" : "" }}>{{$publisher->name}}</option>    
                                    @endforeach
                                    
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="date_incident" class="fw-bold"><span class="text-danger">*</span>Date of Incident</label>
                                <div class="input-group log-event"id="date_incident" data-td-target-input="nearest" data-td-target-toggle="nearest">
                                    <input id="date_incidentInput"  name="date_incident" type="text" class="form-control" data-td-target="#date_incident" value="{{ old('date_incident') }}"/>
                                    <span class="input-group-text" data-td-target="#date_incident" data-td-toggle="datetimepicker" >
                                    <i class="fas fa-calendar"></i>
                                    </span>
                                </div>
                                <!--
                                <label for="date_incident" class="fw-bold">Date of Incident</label>
                                <div class="input-group date" id="datepicker">
                                    <input type="text" class="form-control" name="date_incident"  value="{{ old('date_incident') }}" id="date_incident" required/>
                                    <span class="input-group-append">
                                      <span class="input-group-text bg-light d-block">
                                        <i class="fa fa-calendar"></i>
                                      </span>
                                    </span>
                                </div>-->
                            </div>
                        </div>
                        <div class="mb-4">
                            <label for="url" class="fw-bold"><span class="text-danger">*</span>URL Link</label>
                            <div class="d-flex flex-row w-full pasteContainer">
                                <div class="w-full inputDiv">
                                    <input type="text" name="url_link" value="{{ old('url_link') }}" id="url" placeholder="https://url.com" class="form-control" required>
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
    <script>
    $(document).ready(function () {
        /*$('#date_incident').datetimepicker({
            format: 'DD/MMM/YYYY',
            locale: 'en'
        });*/
        $("#category").select2({
            tags: true,
            width: 'resolve',
            placeholder: "Select category"
        });
        $("#relatedcategory").select2({
            tags: true,
            width: 'resolve',
            placeholder: "Select related categories"
        });
        $("#publisher").select2({
            tags: true,
            width: 'resolve',
            placeholder: "Select publisher"
        });
    });
    
    </script>
</x-app-layout>