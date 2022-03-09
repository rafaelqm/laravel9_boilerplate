<?php
$permissions = auth()->user()->getPermissions()->pluck('slug')->toArray();
$opened_config_menu = Request::is('users*')
    || Request::is('roles*')
?>
@if(in_array('view.users', $permissions, true)
    || in_array('roles.view', $permissions, true))
<li class="nav-item {{ $opened_config_menu ? ' menu-open' : ''  }}">
    <a href="#" class="nav-link">
        <i class="nav-icon fas fa-cogs"></i>
        <p>
            Configurações
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview" style="{{ $opened_config_menu ? '' : 'display: none;'  }}">
        @permission('view.users')
        <li class="nav-item {{ Request::is('users*') ? 'active' : '' }}">
            <a class="nav-link {{ Request::is('users*') ? 'active' : '' }}" href="{{ route('users.index') }}">
                <i class="nav-icon fas fa-users"></i>
                <p>Usuários</p>
            </a>
        </li>
        @endpermission
        @permission('roles.view')
        <li class="nav-item {{ Request::is('roles*') ? 'active' : '' }}">
            <a class="nav-link {{ Request::is('roles*') ? 'active' : '' }}" href="{{ route('roles.index') }}">
                <i class="nav-icon fas fa-users-cog"></i>
                <p>Papéis</p>
            </a>
        </li>
        @endpermission
</li>
@endif

{{-------}}

{{--<li class="nav-item">--}}
{{--    <a href="/examples" class="nav-link {{ Request::is('examples*') ? 'active' : '' }}">--}}
{{--        <i class="fas fa-circle nav-icon"></i>--}}
{{--        <p>Form Components</p>--}}
{{--    </a>--}}
{{--</li>--}}
{{--<li class="nav-header">LABELS</li>--}}
{{--<li class="nav-item">--}}
{{--    <a href="#" class="nav-link">--}}
{{--        <i class="nav-icon far fa-circle text-danger"></i>--}}
{{--        <p class="text">Important</p>--}}
{{--    </a>--}}
{{--</li>--}}
{{--<li class="nav-item">--}}
{{--    <a href="#" class="nav-link">--}}
{{--        <i class="nav-icon far fa-circle text-warning"></i>--}}
{{--        <p>Warning</p>--}}
{{--    </a>--}}
{{--</li>--}}
{{--<li class="nav-item">--}}
{{--    <a href="#" class="nav-link">--}}
{{--        <i class="nav-icon far fa-circle text-info"></i>--}}
{{--        <p>Informational</p>--}}
{{--    </a>--}}
{{--</li>--}}
