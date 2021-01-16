@extends('layouts.main')

@section('title', 'Dashboard')


@section('content')
    <div class="row content w-100 min-h-100 flex justify-content-center align-items-center">
        <div class="col-lg-8 storage-inf links-container rounded bg-gray-800 px-4 py-4 my-4 text-white flex align-items-center justify-content-centero">
            {{ $file_count }} images totaling {{ $storage }}
        </div>
        @if(old($url))
            <div class="col-lg-8">
                <div class="links-container rounded bg-gray-800 px-4 py-4 my-4 text-white flex align-items-center justify-content-center">
                    {{ old($url)["url"] }}
                </div>
            </div>
        @endif
        <div class="col-lg-8">
            <div class="image-container">
                @foreach ($images as $image)
                    <div class="image bg-gray-800 rounded w-100 py-2 px-2 text-white flex justify-content-between align-items-center my-2 hover:bg-gray-600 hover:shadow transition">
                        <div class="info flex align-items-center">
                            <div class="w-10 h-10 rounded-sm overflow-hidden shadow-inner text-center bg-purple table cursor-pointer flex align-items-center mb-0">
                                <img src="{{ $image->is_public ? $image->url : $image->private_url }}" class=" object-cover object-center w-full h-full visible group-hover:hidden" />
                            </div>
                            <div class="details flex flex-col justify-content-center ml-4">
                                <span>{{ $image->slug }}</span>
                                <div class="overflow-ellipsis overflow-hidden max-h-10">
                                    {{ $image->url }}
                                </div>
                            </div>
                        </div>

                        <div class="actions mx-2">
                            @if($image->is_public)
                                <a href="{{ route('image.update', ['id' => $image->id, 'public' => 0]) }}">
                                    <button class="uppercase px-2 py-2 h-75 text-sm bg-green-600 text-white shadow-sm hover:shadow-lg transition rounded">
                                        <svg height="16" width="16" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M3.707 2.293a1 1 0 00-1.414 1.414l14 14a1 1 0 001.414-1.414l-1.473-1.473A10.014 10.014 0 0019.542 10C18.268 5.943 14.478 3 10 3a9.958 9.958 0 00-4.512 1.074l-1.78-1.781zm4.261 4.26l1.514 1.515a2.003 2.003 0 012.45 2.45l1.514 1.514a4 4 0 00-5.478-5.478z" clip-rule="evenodd" />
                                            <path d="M12.454 16.697L9.75 13.992a4 4 0 01-3.742-3.741L2.335 6.578A9.98 9.98 0 00.458 10c1.274 4.057 5.065 7 9.542 7 .847 0 1.669-.105 2.454-.303z" />
                                        </svg>
                                    </button>
                                </a>
                            @else
                                <a href="{{ route('image.url', ['id' => $image->id]) }}">
                                    <button class="uppercase px-2 py-2 h-75 text-sm bg-purple-500 text-white shadow-sm hover:shadow-lg transition rounded">
                                        <svg height="16" width="16" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M12.586 4.586a2 2 0 112.828 2.828l-3 3a2 2 0 01-2.828 0 1 1 0 00-1.414 1.414 4 4 0 005.656 0l3-3a4 4 0 00-5.656-5.656l-1.5 1.5a1 1 0 101.414 1.414l1.5-1.5zm-5 5a2 2 0 012.828 0 1 1 0 101.414-1.414 4 4 0 00-5.656 0l-3 3a4 4 0 105.656 5.656l1.5-1.5a1 1 0 10-1.414-1.414l-1.5 1.5a2 2 0 11-2.828-2.828l3-3z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </a>
                                <a href="{{ route('image.update', ['id' => $image->id, 'public' => true]) }}">
                                    <button class="uppercase px-2 py-2 h-75 text-sm bg-blue-500 text-white shadow-sm hover:shadow-lg transition rounded">
                                        <svg height="16" width="16" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                            <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </a>
                            @endif
                            <a href="{{ route('image.delete', ['id' => $image->id]) }}">
                                <button class="uppercase px-2 py-2 h-75 text-sm bg-red-500 text-white shadow-sm hover:shadow-lg transition rounded">
                                    <svg width="16" height="16" preserveAspectRatio="xMidYMid meet" viewBox="0 0 32 32" style="transform: rotate(360deg);"><path d="M12 12h2v12h-2z" fill="currentColor"></path><path d="M18 12h2v12h-2z" fill="currentColor"></path><path d="M4 6v2h2v20a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8h2V6zm4 22V8h16v20z" fill="currentColor"></path><path d="M12 2h8v2h-8z" fill="currentColor"></path></svg>
                                </button>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            @if(!is_null($images->links()))
                <div class="links-container rounded bg-gray-800 px-4 py-4 mt-4 text-white">
                    {{ $images->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
