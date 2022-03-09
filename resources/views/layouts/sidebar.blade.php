<aside class="main-sidebar sidebar-light-lime elevation-2" style="z-index: 999;">

    <a href="{{ route('home') }}" class="brand-link">
        <img src="{{ asset('images/logo.png') }}"
             alt="{{ config('app.name') }} Logo"
             class="brand-image">
        <span class="brand-text font-weight-light">{{ config('app.name') }}</span>
    </a>

    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                @include('layouts.menu')
            </ul>
        </nav>
    </div>

</aside>
