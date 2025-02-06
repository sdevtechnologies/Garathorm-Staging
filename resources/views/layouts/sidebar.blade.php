<aside id="sidebar" class="mt-5">
    <div class="h-100">
        <!--<div class="sidebar-logo">
            <a href="#" class="nav-icon" pe-md-0>
                <img src="/images/PEZA_NEW_LOGO.png" alt=""/>eLOA
            </a>
        </div>-->
        <ul class="sidebar-nav py-3">
            <li class="sidebar-item">
                <a href="#" class="sidebar-link {{$selectedMenu=='Profile' ? 'active' : 'collapsed'}}" data-bs-target="#Users" data-bs-toggle="collapse" aria-expanded="false">
                    
                    {{Auth::user()->name}}
                </a>
                <ul id="Users" class="sidebar-dropdown list-unstyled collapse {{ $selectedMenu=='Profile' ? 'show' : ''}}" data-bs-parent="#sidebar">
                    <li class="sidebar-item">
                        <a href="{{route('profile.edit')}}" class="sidebar-link {{$selectedMenu=='Profile' ? 'active' : ''}}">
                            <i class="fa-solid fa-address-card pe-2"></i>
                            Profile
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                        <a href="{{route('profile.edit')}}"onclick="event.preventDefault();
                        this.closest('form').submit();" class="sidebar-link">
                            <i class="fa-solid fa-arrow-right-from-bracket pe-2"></i>
                            Log Out
                        </a>
                        </form>
                    </li>
                </ul>
            </li>
            
            <li class="sidebar-item">
                <a href="#" class="sidebar-link {{$selectedMenu=='Laws' || $selectedMenu=='Industry' || $selectedMenu=='Incident' || $selectedMenu=='Announcement' ? 'active' : 'collapsed'}}" data-bs-target="#Resources" data-bs-toggle="collapse" aria-expanded="false">
                    
                    Resources
                </a>
                <ul id="Resources" class="sidebar-dropdown list-unstyled collapse {{$selectedMenu=='Laws' || $selectedMenu=='Industry' || $selectedMenu=='Incident' || $selectedMenu=='Announcement'? 'show' : ''}}" data-bs-parent="#sidebar">
                    <li class="sidebar-item">
                        <a href="{{route('incident.index')}}" class="sidebar-link {{$selectedMenu=='Incident' ? 'active' : ''}}">
                            <i class="fa-solid fa-bullhorn pe-2"></i>
                            Incidents and Announcements
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="{{route('laws.index')}}" class="sidebar-link {{$selectedMenu=='Laws' ? 'active' : ''}}">
                            <i class="fa-solid fa-scale-balanced pe-2"></i>
                            Laws and Frameworks
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="{{route('industry.index')}}" class="sidebar-link {{$selectedMenu=='Industry' ? 'active' : ''}}">
                            <i class="fa-solid fa-city pe-2"></i>
                            Industry References and Best Practices
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="{{route('announcement.index')}}" class="sidebar-link {{$selectedMenu=='Announcement' ? 'active' : ''}}">
                            <i class="fa-solid fa-shield pe-2"></i>
                            Defense Leaks Knowledgebase
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="{{route('knowledgebases.index')}}" class="sidebar-link {{$selectedMenu=='Knowledgebase' ? 'active' : ''}}">
                            <i class="fa-solid fa-shield pe-2"></i>
                            Knowledgebase
                        </a>
                    </li>
                </ul>
            </li>
            @if(Auth::user()->hasRole('admin'))
            <li class="sidebar-item">
                <a href="#" class="sidebar-link {{$selectedMenu=='DNS' || $selectedMenu=='VAPT' ? 'active' : 'collapsed'}}" data-bs-target="#Tools" data-bs-toggle="collapse" aria-expanded="false">
                   
                    Tools and Scripts
                </a>
                <ul id="Tools" class="sidebar-dropdown list-unstyled collapse {{$selectedMenu=='DNS' || $selectedMenu=='VAPT' ? 'show' : ''}}" data-bs-parent="#sidebar">
                    <li class="sidebar-item">
                        <a href="{{route('DNS.index')}}" class="sidebar-link {{$selectedMenu=='DNS' ? 'active' : ''}}">
                            <i class="fa-solid fa-gear pe-2"></i>
                            DNS
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="{{route('VAPT.index')}}" class="sidebar-link {{$selectedMenu=='VAPT' ? 'active' : ''}}">
                            <i class="fa-solid fa-gears pe-2"></i>
                            VAPT
                        </a>
                    </li>
                </ul>
            </li>
            
                <li class="sidebar-header">
                    Administration
                </li>
                <li class="sidebar-item">
                    <a href="{{route('user.index')}}" class="sidebar-link {{$selectedMenu=='User' ? 'active' : ''}}">
                        <i class="fas fa-user pe-2"></i>
                        Users
                    </a>
                </li>
                <li class="sidebar-header">
                    Lookup Management
                </li>
                <li class="sidebar-item">
                    <a href="{{route('lawcategory.index')}}" class="sidebar-link {{$selectedMenu=='LawCat' ? 'active' : ''}}">
                        <i class="fa-solid fa-layer-group pe-2"></i>
                        Laws and Frameworks Category
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="{{route('indcategory.index')}}" class="sidebar-link {{$selectedMenu=='IndCat' ? 'active' : ''}}">
                        <i class="fa-solid fa-layer-group pe-2"></i>
                        Industry References and Best Practices Category
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="{{route('inccategory.index')}}" class="sidebar-link {{$selectedMenu=='IncCat' ? 'active' : ''}}">
                        <i class="fa-solid fa-layer-group pe-2"></i>
                        Incidents and Announcements Category
                    </a>
                </li>

                <li class="sidebar-item">
                    <a href="{{route('announcementcategory.index')}}" class="sidebar-link {{$selectedMenu=='AnnouncementCategory' ? 'active' : ''}}">
                        <i class="fa-solid fa-layer-group pe-2"></i>
                        Defense leak Knowledgebase
                    </a>
                </li>

                <li class="sidebar-item">
                    <a href="{{route('publisher.index')}}" class="sidebar-link {{$selectedMenu=='Publisher' ? 'active' : ''}}">
                        <i class="fa-solid fa-layer-group pe-2"></i>
                        Publisher
                    </a>
                </li>
                
            @endif
        </ul>
    </div>
</aside>