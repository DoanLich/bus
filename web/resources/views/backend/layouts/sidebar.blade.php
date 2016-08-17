<div class="side-menu sidebar-inverse">
    <nav class="navbar navbar-default" role="navigation">
        <div class="side-menu-container">
            <div class="navbar-header">
                <a class="navbar-brand" href="{{ route('admin.home') }}">
                    <div class="icon fa fa-paper-plane"></div>
                    <div class="title">{{ config('app.name') }}</div>
                </a>
                <button type="button" class="navbar-expand-toggle pull-right visible-xs">
                    <i class="fa fa-times icon"></i>
                </button>
            </div>
            <ul class="nav navbar-nav">
                @if(session()->has('admin_menus'))
                    @foreach(session('admin_menus') as $menu)
                        @if($menu->route != null)
                        <li {!! $menu->isActive() || (isset($active_menu) && $active_menu == $menu->index) ? 'class="active"' : '' !!}>
                            <a href="{{ route($menu->route) }}">
                                <span class="icon fa fa-{{ $menu->icon != null ? $menu->icon : 'circle-o' }}"></span><span class="title">{{ $menu->getName() }}</span>
                            </a>
                        </li>
                        @else
                            @if(count($menu->getChildMenu()) > 0)
                            <li class="panel panel-default dropdown {!! $menu->isActive() || (isset($active_menu) && $active_menu == $menu->index) ? 'active' : '' !!}">
                                <a data-toggle="collapse" href="#dropdown-{{ $menu->index }}">
                                    <span class="icon fa fa-{{ $menu->icon }}"></span><span class="title">{{ $menu->getName() }}</span>
                                </a>
                                <!-- Dropdown level 1 -->
                                <div id="dropdown-{{ $menu->index }}" class="panel-collapse collapse {!! $menu->isActive() || (isset($active_menu) && $active_menu == $menu->index) ? 'in' : '' !!}">
                                    <div class="panel-body">
                                        <ul class="nav navbar-nav">
                                            @foreach($menu->getChildMenu() as $child)
                                                <li {!! $child->isActive() ? 'class="current"' : '' !!}><a href="{{ route($child->route) }}"><span class="icon fa fa-{{ $child->icon }}"></span> {{ $child->getName() }}</a></li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </li>
                            @endif
                        @endif
                    @endforeach
                @endif
                @if(Auth::guard('admins')->user()->hasSystemRole())
                    <li {!! Route::is('admin.logs.index') ? 'class="active"' : '' !!}>
                        <a href="{{ route('admin.logs.index') }}">
                            <span class="icon fa fa-history"></span><span class="title">{{ trans('backend/logs.index') }}</span>
                        </a>
                    </li>
                @endif
            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </nav>
</div>