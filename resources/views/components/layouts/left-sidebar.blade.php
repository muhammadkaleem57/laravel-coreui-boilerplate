<div class="c-sidebar c-sidebar-dark c-sidebar-fixed c-sidebar-lg-show" id="sidebar">
    <div class="c-sidebar-brand d-lg-down-none">
        <h3 class="pt-2"><strong>{{APP_NAME}}</strong></h3>
    </div>
    <ul class="c-sidebar-nav">

        <li class="c-sidebar-nav-item">
            <x-jet.jet-sidebar-link href="{{route('dashboard')}}">
                <i class="c-sidebar-nav-icon icon-speedometer"></i> Dashboard
            </x-jet.jet-sidebar-link>
        </li>

    </ul>
    <button class="c-sidebar-minimizer c-class-toggler" type="button" data-target="_parent" data-class="c-sidebar-minimized"></button>
</div>
