<x-app-layout>
    <x-slot name="selectedMenu">
        {{"Industry"}}
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="d-flex justify-content-between">
                <h3 class="text-2xl">Industry References and Best Practices</h3>
            </div>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-3">
                <div class="container mx-auto px-4 py-4">
                    <div class="text-right">
                        <a href="{{route('industry.index')}}" class="btn btn-danger"><i class="fa-solid fa-xmark pe-2"></i>Close</a>
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
                    <form action="{{ route('industry.update',$industry) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-4">
                            <label for="title" class="fw-bold">Title</label>
                            <input type="text" name="title"  value="{{old('title') ? old('title') : $industry->title}}" placeholder="Title" id="title" class="form-control" required>
                        </div>
                        <div class="row mb-4">
                            <div class="col-md-4">
                                <label for="category" class="fw-bold">Category</label>
                                <select id="category" name="category" id="category" class="form-control"  style="width:100%;" required>
                                    <option value="">Select Category</option>
                                    @foreach ($categories as $category)
                                        <option value="{{$category->id}}" <?php if (old('category')){
                                            echo (old('category')==$category->id ? "selected" : "");
                                        }else{
                                            echo ($industry->category->id==$category->id ? "selected" : "");
                                        } 
                                        ?>>{{$category->name}}</option>
                                    @endforeach
                                    
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="publisher" class="fw-bold">Publisher</label>
                                <select name="publisher" id="publisher" class="form-control" style="width: 100%" required>
                                    <option value="">Select Publisher</option>
                                    @foreach ($publishers as $publisher)
                                        <option value="{{$publisher->id}}" <?php if (old('publisher')){
                                            echo (old('publisher')==$publisher->id ? "selected" : "");
                                        }else{
                                            echo ($industry->publisher_id==$publisher->id ? "selected" : "");
                                        } 
                                        ?>>{{$publisher->name}}</option>
                                    @endforeach
                                    
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="date_incident" class="fw-bold">Date Published</label>
                                <div class="input-group log-event"id="date_incident" data-td-target-input="nearest" data-td-target-toggle="nearest">
                                    <input id="date_incidentInput"  name="date_published" type="text" class="form-control" data-td-target="#date_incident" value="{{old('date_published') ? old('date_published') : Carbon\Carbon::parse($industry->date_published)->format('d/M/Y')}}"/>
                                    <span class="input-group-text" data-td-target="#date_incident" data-td-toggle="datetimepicker" >
                                    <i class="fas fa-calendar"></i>
                                    </span>
                                </div>
                                
                            
                            </div>
                        </div>
                        <div class="mb-4">
                            <label for="url" class="fw-bold">URL Link</label>
                            <div class="d-flex flex-row w-full">
                                <div class="w-full">
                                    <input type="text" name="url_link" value="{{old('url_link') ? old('url_link') : $industry->url_link}}" id="url" placeholder="https://url.com" class="form-control" required>
                                </div>
                                <div class="ml-2">
                                    <button type="button" class="btn btn-primary" id="copyLink">Copy</button>
                                </div>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label for="description" class="fw-bold">Description</label>
                            <div class="d-flex flex-row w-full">
                                <div class="w-full">
                                    <textarea rows="7" name="description" id="description" placeholder="Add a short description" class="form-control h-full" required >{{old('description') ? old('description') : $industry->description}}</textarea>
                                </div>
                                <div class="ml-2">
                                    <button type="button" class="btn btn-primary" id="copyDescription">Copy</button>
                                </div>
                            </div>
                                    <!--<textarea name="description" id="description" rows="3" class="form-control" required></textarea>-->
                        </div>
                        <div class="d-flex justify-content-center">
                            <button type="submit" class="btn btn-primary w-25 ">Update</button></div>
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
        /*$('#date_published').datetimepicker({
            format: 'DD/MMM/YYYY',
            locale: 'en'
        });*/
    });
    </script>
</x-app-layout>