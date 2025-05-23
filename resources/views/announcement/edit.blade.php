<x-app-layout>
    <x-slot name="selectedMenu">
        {{"Announcement"}}
    </x-slot>
    <link rel="stylesheet" href="{{URL::to('custom/css/announcement/announcement.css')}}"/>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="d-flex justify-content-between">
                <h3 class="text-2xl">Geopolitical risk</h3>
            </div>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-3">
                <div class="container mx-auto px-4 py-4">
                    <div class="text-right">
                        <a href="{{route('announcement.index')}}" class="btn btn-danger"><i class="fa-solid fa-xmark pe-2"></i>Close</a>
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
                    <form action="{{ route('announcement.update',$announcement) }}" method="POST">
                        <label class="fst-italic text-danger">Note: All fields mark with (*) are required.</label>
                        @csrf
                        @method('PUT')
                        <div class="mb-4">
                            <label for="title" class="fw-bold"><span class="text-danger">*</span>Title</label>
                            <input type="text" name="title"  value="{{old('title') ? old('title') : $announcement->title}}" placeholder="Title" id="title" class="form-control" required>
                        </div>
                        <div class="row mb-4">
                            <div class="col-md-3">
                                <label for="category" class="fw-bold"><span class="text-danger">*</span>Category</label>
                                <select name="category" id="category" class="form-control" required>
                                    
                                    @foreach ($categories as $category)
                                        <option value="{{$category->id}}" <?php if (old('category')){
                                            echo (old('category')==$category->id ? "selected" : "");
                                        }else{
                                            echo ($announcement->category_id==$category->id ? "selected" : "");
                                        } 
                                        ?>>{{$category->name}}</option>
                                    @endforeach
                                    
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="relatedcategory" class="fw-bold">Related Category</label>
                                <select id="relatedcategory" name="relatedcategory[]"  class="js-example-basic-multiple js-states form-control" multiple="multiple">
                                  
                                    @foreach ($categories as $category)
                                        <option value="{{$category->id}}" <?php if (old('relatedcategory')){
                                            echo (old('relatedcategory')==$category->id ? "selected" : "");
                                        }else{
                                            echo ($selectedCategories->contains('id',$category->id) ? "selected" : "");
                                        } 
                                        ?>>{{$category->name}}</option>
                                    @endforeach
                                    
                                </select>
                            </div>
                            <div class="col-md-1">
                                <label for="published" class="fw-bold"><span class="text-danger">*</span>Publish</label><br>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" value="1" name="published" id="publishedyes" <?php 
                                        if (old('published') && old('published')==1) {
                                            echo "checked";
                                        }elseif (old('published') && old('published')==0){
                                            echo "";
                                        }elseif ($announcement->published==1) {
                                            echo "checked";
                                        }
                                        ?>
                                    >
                                    <label class="form-check-label" for="publishedyes">
                                    Yes
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" value="0" name="published" id="publishedno" <?php 
                                    if (old('published') && old('published')==0) {
                                        echo "checked";
                                    }elseif (old('published') && old('published')==1){
                                        echo "";
                                    }elseif ($announcement->published==0) {
                                        echo "checked";
                                    }
                                    ?> >
                                    <label class="form-check-label" for="publishedno">
                                    No
                                    </label>
                                </div>
                                
                            </div>
                            <div class="col-md-3">
                                <label for="publisher" class="fw-bold"><span class="text-danger">*</span>Publisher</label>
                                <select name="publisher" id="publisher" class="form-control" required>
                                    
                                    @foreach ($publishers as $publisher)
                                        <option value="{{$publisher->id}}" <?php if (old('publisher')){
                                            echo (old('publisher')==$publisher->id ? "selected" : "");
                                        }else{
                                            echo ($announcement->publisher_id==$publisher->id ? "selected" : "");
                                        } 
                                        ?>>{{$publisher->name}}</option>
                                    @endforeach
                                    
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="date_announcement" class="fw-bold"><span class="text-danger">*</span>Date of announcement</label>
                                <div class="input-group log-event"id="date_announcement" data-td-target-input="nearest" data-td-target-toggle="nearest">
                                    <input id="date_announcementInput"  name="date_announcement" type="text" class="form-control" data-td-target="#date_announcement" value="{{old('date_announcement') ? old('date_announcement') : Carbon\Carbon::parse($announcement->date_announcement)->format('d/M/Y')}}"/>
                                    <span class="input-group-text" data-td-target="#date_announcement" data-td-toggle="datetimepicker" >
                                    <i class="fas fa-calendar"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label for="url" class="fw-bold"><span class="text-danger">*</span>URL Link</label>
                            <div class="d-flex flex-row w-full">
                                <div class="w-full">
                                    <input type="text" name="url_link" value="{{old('url_link') ? old('url_link') : $announcement->url_link}}" id="url" placeholder="https://url.com" class="form-control" required >
                                </div>
                                <div class="ml-2">
                                    <button type="button" class="btn btn-primary" id="copyLink">Copy</button>
                                </div>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label for="description" class="fw-bold"><span class="text-danger">*</span>Description</label>
                            <div class="d-flex flex-row w-full">
                                <div class="w-full">
                                    <textarea rows="7" name="description" id="description" placeholder="Add a short description" class="form-control h-full" required>{{old('description') ? old('description') : $announcement->description}}</textarea>
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
</x-app-layout>