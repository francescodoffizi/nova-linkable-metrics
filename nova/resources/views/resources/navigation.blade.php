@if (count(\Laravel\Nova\Nova::resourcesForNavigation(request())))
    <h3 class="flex items-center font-normal text-white mb-6 text-base no-underline">
        <svg class="sidebar-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
            <path fill="var(--sidebar-icon)" d="M3 1h4c1.1045695 0 2 .8954305 2 2v4c0 1.1045695-.8954305 2-2 2H3c-1.1045695 0-2-.8954305-2-2V3c0-1.1045695.8954305-2 2-2zm0 2v4h4V3H3zm10-2h4c1.1045695 0 2 .8954305 2 2v4c0 1.1045695-.8954305 2-2 2h-4c-1.1045695 0-2-.8954305-2-2V3c0-1.1045695.8954305-2 2-2zm0 2v4h4V3h-4zM3 11h4c1.1045695 0 2 .8954305 2 2v4c0 1.1045695-.8954305 2-2 2H3c-1.1045695 0-2-.8954305-2-2v-4c0-1.1045695.8954305-2 2-2zm0 2v4h4v-4H3zm10-2h4c1.1045695 0 2 .8954305 2 2v4c0 1.1045695-.8954305 2-2 2h-4c-1.1045695 0-2-.8954305-2-2v-4c0-1.1045695.8954305-2 2-2zm0 2v4h4v-4h-4z"
            />
        </svg>
        <span class="sidebar-label">{{ __('Resources') }}</span>
    </h3>

    @foreach($navigation as $group => $resources)
        <?php
        $rs = [];
        foreach ($resources as $r) {
            $rs[] = $r::uriKey();
        }
        $expanded = in_array(explode("/",url()->current())[count(explode("/",url()->current()))-1], $rs);
        ?>

        <collapse-group group="{{ __($group) }}" :last="@json($loop->last)" :expanded="@if($expanded) true @else false @endif">>
            @foreach ($resources as $key => $resource)
                <li class="leading-wide mb-4 text-sm" key="{{ $key }}">
                    <router-link :to="{
                        name: 'index',
                        params: {
                        resourceName: '{{ $resource::uriKey() }}'
                        }
                        }" class="text-white ml-6 no-underline dim block">
                        {{ $resource::label() }}
                        @if ($resource::hasBadge())
                            <span style="width: 15px;
                                        height: 15px;
                                        background: red;
                                        position: absolute;
                                        margin-left: 5px;
                                        border-radius: 100%;
                                        text-align: center;
                                        font-weight: bold;">!</span>
                        @endif
                    </router-link>
                </li>
            @endforeach
        </collapse-group>
    @endforeach
@endif
