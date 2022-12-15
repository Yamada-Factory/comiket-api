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
                        <div class="relative z-0 mb-6 w-full group">
                            <label for="circle_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">サークル名</label>
                            <input type="text" name="circle_name" id="circle_name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder=" " required value="{{ $response['circle']['name'] }}" />
                        </div>

                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
                    </form>
                    <div class="mt-5 md:mt-0 md:col-span-2">
                        <form>
                            <div class="px-4 py-5 bg-white sm:p-6 shadow sm:rounded-tl-md sm:rounded-tr-md">
                                <div class="grid grid-cols-6 gap-6">
                                    <x-jet-button class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 ">
                                        Submit
                                    </x-jet-button>
                                </div>
                            </div>
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
