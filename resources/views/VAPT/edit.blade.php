<x-app-layout>
    <x-slot name="selectedMenu">
        {{"VAPT"}}
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="d-flex justify-content-between">
                <h3 class="text-2xl">VAPT TOOLS</h3>
            </div>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-3">
                <div class="container mx-auto px-4 py-4">
                    <div class="text-right">
                        <a href="{{route('VAPT.index')}}" class="btn btn-danger"><i class="fa-solid fa-xmark pe-2"></i>Close</a>
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
                    <form action="{{ route('VAPT.update',$VAPT) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-4">
                            <label for="title" class="fw-bold">Title</label>
                            <input type="text" name="title"  value="{{old('title') ? old('title') : $VAPT->title}}" placeholder="Title" id="title" class="form-control" required>
                        </div>
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="category" class="fw-bold">Category</label>
                                <select name="category" id="category" class="form-control" required>
                                    <option value="">Select Category</option>
                                    <option value="WEB" <?php if (old('category')){
                                        echo (old('category')=="WEB" ? "selected" : "");
                                    }else{
                                        echo ($VAPT->category=="WEB" ? "selected" : "");
                                    } 
                                    ?>>WEB</option>
                                    <option value="MOBILE" <?php if (old('category')){
                                        echo (old('category')=="MOBILE" ? "selected" : "");
                                    }else{
                                        echo ($VAPT->category=="MOBILE" ? "selected" : "");
                                    } 
                                    ?>>MOBILE</option>
                                    <option value="DNS" <?php if (old('category')){
                                        echo (old('category')=="DNS" ? "selected" : "");
                                    }else{
                                        echo ($VAPT->category=="DNS" ? "selected" : "");
                                    } 
                                    ?>>DNS</option>
                                    <option value="HIPAA" <?php if (old('category')){
                                        echo (old('category')=="HIPAA" ? "selected" : "");
                                    }else{
                                        echo ($VAPT->category=="HIPAA" ? "selected" : "");
                                    } 
                                    ?>>HIPAA</option>
                                    <option value="ISO" <?php if (old('category')){
                                        echo (old('category')=="ISO" ? "selected" : "");
                                    }else{
                                        echo ($VAPT->category=="ISO" ? "selected" : "");
                                    } 
                                    ?>>ISO</option>
                                    <option value="IAM" <?php if (old('category')){
                                        echo (old('category')=="IAM" ? "selected" : "");
                                    }else{
                                        echo ($VAPT->category=="IAM" ? "selected" : "");
                                    } 
                                    ?>>IAM</option>
                                    <option value="PCI" <?php if (old('category')){
                                        echo (old('category')=="PCI" ? "selected" : "");
                                    }else{
                                        echo ($VAPT->category=="PCI" ? "selected" : "");
                                    } 
                                    ?>>PCI</option>
                                    <option value="GDPR" <?php if (old('category')){
                                        echo (old('category')=="GDPR" ? "selected" : "");
                                    }else{
                                        echo ($VAPT->category=="GDPR" ? "selected" : "");
                                    } 
                                    ?>>GDPR</option>
                                    <option value="CII" <?php if (old('category')){
                                        echo (old('category')=="CII" ? "selected" : "");
                                    }else{
                                        echo ($VAPT->category=="CII" ? "selected" : "");
                                    } 
                                    ?>>CII</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="date_issue" class="fw-bold">Date of Issue</label>
                                <div class="input-group date" id="datepicker">
                                    <input type="text" class="form-control" name="date_issue"  value="{{old('date_issue') ? old('date_issue') : Carbon\Carbon::parse($VAPT->date_issue)->format('d/M/Y')}}" id="date_issue" required/>
                                    <span class="input-group-append">
                                      <span class="input-group-text bg-light d-block">
                                        <i class="fa fa-calendar"></i>
                                      </span>
                                    </span>
                                  </div>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label for="url" class="fw-bold">URL Link</label>
                            <input type="text" name="url_link" value="{{old('url_link') ? old('url_link') : $VAPT->url_link}}" id="url" placeholder="https://url.com" class="form-control" >
                        </div>
                        <div class="mb-4">
                            <label for="description" class="fw-bold">Description</label>
                            <textarea name="description" id="description" placeholder="Add a short description" class="form-control" >{{old('description') ? old('description') : $VAPT->description}}</textarea>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.30.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>
    <script src="{{URL::to('custom/js/tools_date_picker.js')}}"></script>
</x-app-layout>