<x-app-layout>
    <x-slot name="selectedMenu">
        {{"DNS"}}
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="d-flex justify-content-between">
                <h3 class="text-2xl">DNS</h3>
            </div>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-3">
                <div class="container mx-auto px-4 py-4">
                    <div class="text-right">
                        <a href="{{route('DNS.index')}}" class="btn btn-danger"><i class="fa-solid fa-xmark pe-2"></i>Close</a>
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
                    <form action="{{ route('DNS.update',$DNS) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-4">
                            <label for="title" class="fw-bold">Title</label>
                            <input type="text" name="title"  value="{{old('title') ? old('title') : $DNS->title}}" placeholder="Title" id="title" class="form-control" required>
                        </div>
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="category" class="fw-bold">Category</label>
                                <select name="category" id="category" class="form-control" required>
                                    <option value="">Select Category</option>
                                    <option value="A Record" <?php if (old('category')){
                                        echo (old('category')=="A Record" ? "selected" : "");
                                    }else{
                                        echo ($DNS->category=="A Record" ? "selected" : "");
                                    } 
                                    ?>>A Record</option>
                                    <option value="AAAA Record" <?php if (old('category')){
                                        echo (old('category')=="AAAA Record" ? "selected" : "");
                                    }else{
                                        echo ($DNS->category=="AAAA Record" ? "selected" : "");
                                    } 
                                    ?>>AAAA Record</option>
                                    <option value="BLACKLISTING" <?php if (old('category')){
                                        echo (old('category')=="BLACKLISTING" ? "selected" : "");
                                    }else{
                                        echo ($DNS->category=="BLACKLISTING" ? "selected" : "");
                                    } 
                                    ?>>BLACKLISTING</option>
                                    <option value="CNAME Record" <?php if (old('category')){
                                        echo (old('category')=="CNAME Record" ? "selected" : "");
                                    }else{
                                        echo ($DNS->category=="CNAME Record" ? "selected" : "");
                                    } 
                                    ?>>CNAME Record</option>
                                    <option value="DKIM" <?php if (old('category')){
                                        echo (old('category')=="DKIM" ? "selected" : "");
                                    }else{
                                        echo ($DNS->category=="DKIM" ? "selected" : "");
                                    } 
                                    ?>>DKIM</option>
                                    <option value="DMARC" <?php if (old('category')){
                                        echo (old('category')=="DMARC" ? "selected" : "");
                                    }else{
                                        echo ($DNS->category=="DMARC" ? "selected" : "");
                                    } 
                                    ?>>DMARC</option>
                                    <option value="DNS Cache Poisoning" <?php if (old('category')){
                                        echo (old('category')=="DNS Cache Poisoning" ? "selected" : "");
                                    }else{
                                        echo ($DNS->category=="DNS Cache Poisoning" ? "selected" : "");
                                    } 
                                    ?>>DNS Cache Poisoning</option>
                                    <option value="DNS Zone Transfer" <?php if (old('category')){
                                        echo (old('category')=="DNS Zone Transfer" ? "selected" : "");
                                    }else{
                                        echo ($DNS->category=="DNS Zone Transfer" ? "selected" : "");
                                    } 
                                    ?>>DNS Zone Transfer</option>
                                    <option value="DNSSEC" <?php if (old('category')){
                                        echo (old('category')=="DNSSEC" ? "selected" : "");
                                    }else{
                                        echo ($DNS->category=="DNSSEC" ? "selected" : "");
                                    } 
                                    ?>>DNSSEC</option>
                                    <option value="MX Record" <?php if (old('category')){
                                        echo (old('category')=="MX Record" ? "selected" : "");
                                    }else{
                                        echo ($DNS->category=="MX Record" ? "selected" : "");
                                    } 
                                    ?>>MX Record</option>
                                    <option value="S/MIME" <?php if (old('category')){
                                        echo (old('category')=="S/MIME" ? "selected" : "");
                                    }else{
                                        echo ($DNS->category=="S/MIME" ? "selected" : "");
                                    } 
                                    ?>>S/MIME</option>
                                    <option value="SPF" <?php if (old('category')){
                                        echo (old('category')=="SPF" ? "selected" : "");
                                    }else{
                                        echo ($DNS->category=="SPF" ? "selected" : "");
                                    } 
                                    ?>>SPF</option>
                                    <option value="SSL" <?php if (old('category')){
                                        echo (old('category')=="SSL" ? "selected" : "");
                                    }else{
                                        echo ($DNS->category=="SSL" ? "selected" : "");
                                    } 
                                    ?>>SSL</option>
                                    <option value="TXT Record" <?php if (old('category')){
                                        echo (old('category')=="TXT Record" ? "selected" : "");
                                    }else{
                                        echo ($DNS->category=="TXT Record" ? "selected" : "");
                                    } 
                                    ?>>TXT Record</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="date_issue" class="fw-bold">Date of Issue</label>
                                <div class="input-group date" id="datepicker">
                                    <input type="text" class="form-control" name="date_issue"  value="{{old('date_issue') ? old('date_issue') : Carbon\Carbon::parse($DNS->date_issue)->format('d/M/Y')}}" id="date_issue" required/>
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
                            <input type="text" name="url_link" value="{{old('url_link') ? old('url_link') : $DNS->url_link}}" id="url" placeholder="https://url.com" class="form-control">
                        </div>
                        <div class="mb-4">
                            <label for="description" class="fw-bold">Description</label>
                            <textarea name="description" id="description"  placeholder="Add a short description" class="form-control">{{old('description') ? old('description') : $DNS->description}}</textarea>
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

    <script>
    $(document).ready(function () {
        $('#date_issue').datetimepicker({
            format: 'DD/MMM/YYYY',
            locale: 'en'
        });
    });
    </script>
</x-app-layout>