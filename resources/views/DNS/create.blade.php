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
                    <form action="{{ route('DNS.store') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label for="title" class="fw-bold">Title</label>
                            <input type="text" name="title"  value="{{ old('title') }}" placeholder="Title" id="title" class="form-control" required>
                        </div>
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="category" class="fw-bold">Category</label>
                                <select name="category" id="category" class="form-control" required>
                                    <option value="">Select Category</option>
                                    <option value="A Record" {{ old('category')=="A Record" ? "selected" : "" }}>A Record</option>
                                    <option value="AAAA Record" {{ old('category')=="AAAA Record" ? "selected" : "" }}>AAAA Record</option>
                                    <option value="BLACKLISTING" {{ old('category')=="BLACKLISTING" ? "selected" : "" }}>BLACKLISTING</option>
                                    <option value="CNAME Record" {{ old('category')=="CNAME Record" ? "selected" : "" }}>CNAME Record</option>
                                    <option value="DKIM" {{ old('category')=="DKIM" ? "selected" : "" }}>DKIM</option>
                                    <option value="DMARC" {{ old('category')=="DMARC" ? "selected" : "" }}>DMARC</option>
                                    <option value="DNS Cache Poisoning" {{ old('category')=="DNS Cache Poisoning" ? "selected" : "" }}>DNS Cache Poisoning</option>
                                    <option value="DNS Zone Transfer" {{ old('category')=="DNS Zone Transfer" ? "selected" : "" }}>DNS Zone Transfer</option>
                                    <option value="DNSSEC" {{ old('category')=="DNSSEC" ? "selected" : "" }}>DNSSEC</option>
                                    <option value="MX Record" {{ old('category')=="MX Record" ? "selected" : "" }}>MX Record</option>
                                    <option value="S/MIME" {{ old('category')=="S/MIME" ? "selected" : "" }}>S/MIME</option>
                                    <option value="SPF" {{ old('category')=="SPF" ? "selected" : "" }}>SPF</option>
                                    <option value="SSL" {{ old('category')=="SSL" ? "selected" : "" }}>SSL</option>
                                    <option value="TXT Record" {{ old('category')=="TXT Record" ? "selected" : "" }}>TXT Record</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="date_issue" class="fw-bold">Date of Issue</label>
                                <div class="input-group date" id="datepicker">
                                    <input type="text" class="form-control" name="date_issue"  value="{{ old('date_issue') }}" id="date_issue" required/>
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
                            <input type="text" name="url_link" value="{{ old('url_link') }}" id="url" placeholder="https://url.com" class="form-control" >
                        </div>
                        <div class="mb-4">
                            <label for="description" class="fw-bold">Description</label>
                            <textarea name="description" id="description" placeholder="Add a short description" class="form-control" >{{ old('description') }}</textarea>
                            <!--<textarea name="description" id="description" rows="3" class="form-control" required></textarea>-->
                        </div>
                        <div class="d-flex justify-content-center">
                            <button type="submit" class="btn btn-primary w-25 ">Save</button></div>
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