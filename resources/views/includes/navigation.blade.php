@php($route = \Illuminate\Support\Facades\Route::currentRouteName())
<ul class="x-navigation" style="background-color: #222d32 !important;">
    <li class="xn-logo">
        <a href="#" style="color: white; font-size: 30px; padding-top: 50px;padding-left: 15px"></a>
        <a href="#" class="x-navigation-control" ></a>
    </li>
    <li class="xn-profile">
        <a href="#" class="profile-mini">
            <img src="{{asset('assets/images/users/koachie.jpeg')}}" alt="John Doe"/>
        </a>
        <div class="profile">
            <div class="profile-image">
                <img src="{{asset('assets/images/users/koachie.jpeg')}}" alt="John Doe"/>
            </div>
            <div class="profile-data">
                <div class="profile-data-name">{{auth()->user()->first_name}}</div>
                <div class="profile-data-title">{{auth()->user()->email}}</div>
            </div>
        </div>
    </li>
    <li class="xn-title">NAVIGATION</li>
    <li {!! $route == 'app.dashboard' ? 'class="active"' : '' !!}>
        <a href="{{route('app.dashboard')}}"><span class="fa fa-desktop"></span> <span class="xn-text">Dashboard</span></a>
    </li>

    @if($_user->must_change_password)
            @can('view-system-settings')
                <li class="xn-openable {{ preg_match('/settings/', $route) ? 'active' : '' }}">
                    <a href="javascript:;"><i class="fa fa-cogs"></i>
                        <span class="xn-text">System Configuration</span>
                    </a>
                    <ul>

                        {{--<li class="{{ preg_match('/settings.uom/', $route) ? 'active' : '' }}"><a href="{{route ('settings.uom.index')}}"><i class="fa fa-hand-o-right"></i> Unit Of Measure</a></li>--}}
                        @if($_role==='ADM_MAIN')
                        @else
                            <li class="{{ preg_match('/settings.regions/', $route) ? 'active' : '' }}"><a href="{{ route('settings.regions.index') }}"><i class="fa fa-hand-o-right"></i>Regions</a></li>
                            {{--<li class="{{ preg_match('/settings.category/', $route) ? 'active' : '' }}"><a href="{{route ('settings.category.index')}}"><i class="fa fa-hand-o-right"></i> Category</a></li>--}}
                            {{--<li class="{{ preg_match('/settings.subcategory/', $route) ? 'active' : '' }}"><a href="{{route ('settings.subcategory.index')}}"><i class="fa fa-hand-o-right"></i> Subcategory</a></li>--}}
                            {{--<li class="{{ preg_match('/settings.permission/', $route) ? 'active' : '' }}"><a href="{{route ('settings.permission.create')}}"><i class="fa fa-hand-o-right"></i> Permission</a></li>--}}
                            <li class="{{ preg_match('/settings.management.role/', $route) ? 'active' : '' }}"><a href="{{route ('settings.management.role.index')}}"><i class="fa fa-hand-o-right"></i> Role</a></li>
                            <li class="{{ preg_match('/settings.management.user/', $route) ? 'active' : '' }}"><a href="{{ route('settings.management.user.index') }}"><i class="fa fa-hand-o-right"></i>Users</a></li>

                        @endif

                    </ul>
                </li>
            @endcan
    {{--hi--}}
        @can('view-user-profile')
            <li {!! $route == 'profile.edit'? 'class="active"' : '' !!}>
                <a href="{{route('profile.edit',['id'=>$_user->id])}}"><span class="fa fa-user"></span> <span class="xn-text">Profile</span></a>
            </li>

        @endcan
                @can('view-file')
                    {{--<li class="{{ preg_match('/file.docs/', $route) ? 'active' : '' }}">--}}
                        {{--<a href="{{route('file.docs.index')}}"><span class="fa fa-file"></span> <span class="xn-text">File</span></a>--}}
                    {{--</li>--}}
                @endcan
                {{--@can('view-file-report')--}}
                    {{--<li class="{{ preg_match('/report.file.index/', $route) ? 'active' : '' }}">--}}
                        {{--<a href="{{route('report.file.index')}}"><span class="fa fa-book"></span> <span class="xn-text">Report</span></a>--}}
                    {{--</li>--}}
                {{--@endcan--}}
                {{--@can('view-file-report')--}}
                    {{--<li class="xn-openable {{ preg_match('/report/', $route) ? 'active' : '' }}">--}}
                        {{--<a href="javascript:;"><i class="fa fa-book"></i>--}}
                            {{--<span class="xn-text">Report</span>--}}
                        {{--</a>--}}
                        {{--<ul>--}}
                            {{--<li class="{{ preg_match('/report.file.index/', $route) ? 'active' : '' }}"><a href="{{ route('report.file.index') }}"><i class="fa fa-hand-o-right"></i>File Report</a></li>--}}
                            {{--@if($_role==='USR_U')--}}
                            {{--@else--}}
                                {{--<li class="{{ preg_match('/report.audit.trail.index/', $route) ? 'active' : '' }}"><a href="{{route ('report.audit.trail.index')}}"><i class="fa fa-hand-o-right"></i> Audit Trail</a></li>--}}
                            {{--@endif--}}
                        {{--</ul>--}}
                    {{--</li>--}}
                {{--@endcan--}}
        @can('view-lab-patient')
            {{--<li class="xn-openable {{ preg_match('/patient/', $route) ? 'active' : '' }}">--}}
                {{--<a href="javascript:;"><i class="fa fa-compass"></i>--}}
                    {{--<span class="xn-text">Patient</span>--}}
                {{--</a>--}}
                {{--<ul>--}}
                    {{--<li class="{{ preg_match('/patient.viral/', $route) ? 'active' : '' }}"><a href="{{ route('patient.viral.index') }}"><i class="fa fa-hand-o-right"></i>Viral Load</a></li>--}}
                    {{--<li class="{{ preg_match('/patient.eid/', $route) ? 'active' : '' }}"><a href="{{route ('patient.eid.index')}}"><i class="fa fa-hand-o-right"></i> EID</a></li>--}}
                {{--</ul>--}}
            {{--</li>--}}
        @endcan
        @can('view-system-inventory')
                {{--<li class="{{ preg_match('/inventory/', $route) ? 'active' : '' }}" >--}}
                    {{--<a href="{{route('inventory.index')}}"><span class="fa fa-institution"></span> <span class="xn-text">Inventory</span></a>--}}
                {{--</li>--}}
            @endcan
        @can('view-system-report')
            {{--<li class="xn-openable {{ preg_match('/report/', $route) ? 'active' : '' }}">--}}
                {{--<a href="javascript:;"><i class="fa fa-file-archive-o"></i>--}}
                    {{--<span class="xn-text">Report</span>--}}
                {{--</a>--}}
                {{--<ul>--}}
                    {{--<li class="{{ preg_match('/report.viral/', $route) ? 'active' : '' }}"><a href="{{ route('report.viral.load') }}"><i class="fa fa-hand-o-right"></i>ViralLoad</a></li>--}}
                    {{--<li class="{{ preg_match('/report.eid/', $route) ? 'active' : '' }}"><a href="{{route ('report.eid')}}"><i class="fa fa-hand-o-right"></i> EID</a></li>--}}
                    {{--<li class="{{ preg_match('/report.invent/', $route) ? 'active' : '' }}"><a href="{{route ('report.invent')}}"><i class="fa fa-hand-o-right"></i> Iventory</a></li>--}}
                {{--</ul>--}}
            {{--</li>--}}
        @endcan
        {{--@can('view-activity-monitor')--}}
                {{--<li {!! $route == 'audit.trail.index' ? 'class="active"' : '' !!}>--}}
                    {{--<a href="{{route('audit.trail.index')}}"><span class="fa fa-eye"></span> <span class="xn-text">Audit Trail</span></a>--}}
                {{--</li>--}}
            {{--@endcan--}}
    @endif
</ul>