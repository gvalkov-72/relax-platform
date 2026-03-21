<aside class="main-sidebar {{ config('adminlte.classes_sidebar', 'sidebar-dark-primary elevation-4') }}">
    {{-- Brand logo --}}
    <a href="{{ route('admin.dashboard') }}" class="brand-link">
        <img src="{{ asset(config('adminlte.logo_img')) }}"
             alt="{{ config('adminlte.logo_img_alt') }}"
             class="{{ config('adminlte.logo_img_class') }}">
        <span class="brand-text font-weight-light">{!! config('adminlte.logo') !!}</span>
    </a>

    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
                @foreach($adminlteMenu as $item)
                    @if(isset($item['header']))
                        {{-- Header --}}
                        <li class="nav-header">{{ $item['header'] }}</li>
                    @elseif(isset($item['submenu']))
                        {{-- Submenu (treeview) --}}
                        @can($item['can'] ?? null)
                        <li class="nav-item has-treeview {{ request()->is(($item['active'][0] ?? '')) ? 'menu-open' : '' }}">
                            <a href="#" class="nav-link">
                                <i class="nav-icon {{ $item['icon'] ?? 'fas fa-circle' }}"></i>
                                <p>
                                    {{ $item['text'] }}
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                @foreach($item['submenu'] as $sub)
                                    <li class="nav-item">
                                        <a href="{{ $sub['href'] }}" class="nav-link {{ request()->is(($sub['active'][0] ?? '')) ? 'active' : '' }}">
                                            <i class="nav-icon {{ $sub['icon'] ?? 'far fa-circle' }}"></i>
                                            <p>{{ $sub['text'] }}</p>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                        @endcan
                    @else
                        {{-- Regular link --}}
                        @can($item['can'] ?? null)
                        <li class="nav-item">
                            <a href="{{ $item['href'] }}" class="nav-link {{ request()->is(($item['active'][0] ?? '')) ? 'active' : '' }}">
                                <i class="nav-icon {{ $item['icon'] ?? 'fas fa-circle' }}"></i>
                                <p>{{ $item['text'] }}</p>
                            </a>
                        </li>
                        @endcan
                    @endif
                @endforeach
            </ul>
        </nav>
    </div>
</aside>