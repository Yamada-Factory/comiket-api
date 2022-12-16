<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $response['circle']['name'] }}
        </h2>
    </x-slot>

    <div>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            <div class="overflow-x-auto relative">
                <div class="max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow-md dark:bg-gray-800 dark:border-gray-700">
                    <form>
                        <div class="mb-3">
                            <label for="circle_name" class="form-label">サークル</label>
                            <input type="text" class="form-control" id="circle_name" name="circle['name']" placeholder="" value="{{ $response['circle']['name'] }}">
                        </div>
                        <div class="mb-3">
                            <label for="circle_author" class="form-label">作家</label>
                            <input type="text" class="form-control" id="circle_author" placeholder="" value="{{ $response['circle']['author'] }}">
                        </div>

                        @foreach($response['circle']['links'] as $link)
                            <div class="input-group mb-3">
                                @if($link['type'] === 'twitter')
                                    <span class="input-group-text" id="link-type-{{ $link['type'] }}">
                                        <a href="{{ $link['url'] }}" target="_blank">
                                            <i class="fa-brands fa-twitter"></i>
                                        </a>
                                    </span>
                                @elseif($link['type'] === 'pixiv')
                                    <span class="input-group-text" id="link-type-{{ $link['type'] }}">
                                        <a href="{{ $link['url'] }}" target="_blank">
                                            <img src="https://cloud.githubusercontent.com/assets/10008301/5237429/1e89a588-78c6-11e4-92d4-aa57cb66957a.jpg">
                                        </a>
                                    </span>
                                {{-- @elseif($link['type'] === 'website')
                                    <span class="input-group-text" id="basic-addon1"><i class="fa-duotone fa-house-blank"></i><i class="fa-thin fa-house"></i></span> --}}
                                @else
                                    <span class="input-group-text" id="link-type-{{ $link['type'] }}">
                                        <a href="{{ $link['url'] }}" target="_blank">
                                            {{ $link['type'] }}
                                        </a>
                                    </span>
                                @endif

                                <input type="text" class="form-control" placeholder="URL" value="{{ $link['url'] }}">
                            </div>
                        @endforeach

                        <div class="accordion accordion-flush" id="accordionFlushExample">
                            @foreach($response['event'] as $event)
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="accordion-item-event-label-{{ $event['info']['id'] }}">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#accordion-item-event-content-{{ $event['info']['id'] }}" aria-expanded="false" aria-controls="accordion-item-event-content-{{ $event['info']['id'] }}">
                                            {{ $event['info']['name'] }}
                                        </button>
                                    </h2>
                                    <div id="accordion-item-event-content-{{ $event['info']['id'] }}" class="accordion-collapse collapse" aria-labelledby="accordion-item-event-label-{{ $event['info']['id'] }}" data-bs-parent="#accordionFlushExample">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text">Day</span>
                                                    <input type="text" class="form-control" placeholder="例: 土曜日" name="event['participation']['day']" value="{{ $event['participation']['day'] }}">
                                                </div>
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text">ホール</span>
                                                    <input type="text" class="form-control" placeholder="例: 東" name="event['participation']['hall']" value="{{ $event['participation']['hall'] }}">
                                                </div>
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text">ブロック</span>
                                                    <input type="text" class="form-control" placeholder="例: A" name="event['participation']['block']" value="{{ $event['participation']['block'] }}">
                                                </div>
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text">スペース</span>
                                                    <input type="text" class="form-control" placeholder="例: 1ab" name="event['participation']['space']" value="{{ $event['participation']['space'] }}">
                                                </div>
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text">ジャンル</span>
                                                    <input type="text" class="form-control" placeholder="例: 男性向" name="event['participation']['genre']" value="{{ $event['participation']['genre'] }}">
                                                </div>
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text">説明</span>
                                                    <textarea type="text" class="form-control" placeholder="説明" name="event['participation']['block']" value="{{ $event['participation']['description'] }}">{{ $event['participation']['description'] }}</textarea>
                                                </div>

                                                <div class="d-flex justify-content-start align-content-center flex-wrap">
                                                    <style>
                                                        .circle-media {
                                                            min-width: 200px;
                                                            max-width: 200px;
                                                            margin: 5px 5px 5px 5px;
                                                        }
                                                    </style>
                                                        {{-- $images = array_filter($event['participation']['images'], fn($image) => is_string($image) && !str_starts_with($image, 'http')); --}}
                                                    @php

                                                        $images = [];
                                                        foreach($event['participation']['images'] as $image) {
                                                            if (is_string($image) && !str_starts_with($image, 'http')) {
                                                                $images[] = $image;

                                                                continue;
                                                            } elseif (is_array($image)) {
                                                                if (array_key_exists('サムネイル画像', $image)) {
                                                                    $images[] = $image['サムネイル画像'];
                                                                }
                                                                if (array_key_exists('既定表示画像', $image)) {
                                                                    $images[] = $image['既定表示画像'];
                                                                }
                                                            }
                                                        }
                                                    @endphp
                                                    @foreach($images as $index => $image)
                                                        @php $image = 'https://s3-yamada-01.misosiru.men/comiket-app-dev' . $image; @endphp
                                                        @if(str_contains($image, '/Image/Movie/'))
                                                                <video src="{{ $image }}" class="rounded flex-fill circle-media" autoplay loop controls muted>
                                                            @else
                                                                <img src="{{ $image }}" class="rounded flex-fill circle-media" alt="">
                                                            @endif
                                                    @endforeach
                                                    {{-- @foreach($event['participation']['images'] as $image)
                                                        @if(is_string($image))
                                                            @if(!str_starts_with($image, 'http'))
                                                                @php $image = 'http://0.0.0.0:8007' . $image @endphp
                                                            @endif
                                                            @if(str_contains($image, '/Image/Movie/'))
                                                                <video src="{{ $image }}" class="rounded float-start circle-media" autoplay loop>
                                                            @else
                                                                <img src="{{ $image }}" class="rounded float-start circle-media" alt="">
                                                            @endif
                                                        @endif
                                                    @endforeach --}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        {{-- <input type="submit"> --}}
                    </form>
                    {{-- <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="py-3 px-6">
                                    ID
                                </th>
                                <th scope="col" class="py-3 px-6">
                                    Cricle.ms ID
                                </th>
                                <th scope="col" class="py-3 px-6">
                                    サークル名
                                </th>
                                <th scope="col" class="py-3 px-6">
                                    作家名
                                </th>
                                <th scope="col" class="py-3 px-6">
                                    SNS
                                </th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table> --}}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
