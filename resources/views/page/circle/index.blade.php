<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('サークル一覧') }}
        </h2>
    </x-slot>

    <div>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            <div class="overflow-x-auto relative">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
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
                            <th scope="col" class="py-3 px-6">
                                操作
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($circles as $circle)
                            <tr class="bg-white border-b">
                                <th scope="row" class="py-4 px-6">
                                    {{ $circle['id'] }}
                                </th>
                                <td class="py-4 px-6">
                                    {{ $circle['circle_ms_id'] }}
                                </td>
                                <td class="py-4 px-6">
                                    {{ $circle['name'] }}
                                </td>
                                <td class="py-4 px-6">
                                    {{ $circle['author'] }}
                                </td>
                                <td class="py-4 px-6">
                                    @foreach($circle['links'] as $link)
                                        <a href="{{$link['url']}}">{{ $link['type'] }}</a>
                                    @endforeach
                                </td>
                                <td class="py-4 px-6">
                                    <a type="button" class="btn btn-outline-primary btn-sm" href="{{ route('admin.circle.show', ['id' => $circle['id']]) }}" target="_blank"><i class="fa-solid fa-pen-to-square"></i></a>
                                    <button type="button" class="btn btn-outline-danger btn-sm"><i class="fa-solid fa-trash"></i></button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
