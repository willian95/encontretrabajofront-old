@if(isset($ads) && $ads->count())
    @foreach([8, 9, 10, 11] as $adId)
        @php
            $ad = $ads->get($adId);
        @endphp

        @if($ad)
            <div class="ads-sidebar__card card">
                <a href="{{ $ad->link }}" target="_blank">
                    <div class="ads-sidebar__header">
                        <p>Aviso publicitario</p>
                    </div>
                    <div class="ads-sidebar__content">
                        @if($ad->type == 'video')
                            <video controls>
                                <source src="{{ $ad->image }}" type="video/mp4">
                            </video>
                        @else
                            <img src="{{ $ad->image }}" alt="Aviso publicitario">
                        @endif
                    </div>
                </a>
            </div>
        @endif
    @endforeach
@endif
