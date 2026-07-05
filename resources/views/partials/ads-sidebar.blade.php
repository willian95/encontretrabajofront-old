@if(isset($ads) && $ads->count())
    @foreach([8, 9, 10, 11] as $adId)
        @php
            $ad = $ads->get($adId);
        @endphp

        @if($ad)
            <div style="margin-bottom: 1rem;">
                <a href="{{ $ad->link }}" target="_blank">
                    @if($ad->type == 'video')
                        <video style="width:100% !important" controls>
                            <source src="{{ $ad->image }}" type="video/mp4">
                        </video>
                    @else
                        <img style="width:100% !important" src="{{ $ad->image }}" alt="">
                    @endif
                </a>
            </div>
        @endif
    @endforeach
@endif
