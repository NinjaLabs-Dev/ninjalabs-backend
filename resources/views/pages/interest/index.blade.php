@extends('layouts.main')

@section('title', 'Dashboard')


@section('content')
    <div class="row content w-100 min-h-100 flex justify-content-center align-items-center">
        <div class="col-lg-8 storage-inf links-container rounded bg-gray-800 px-4 py-4 my-4 text-white flex align-items-center">
            {{ $submission_count }} submissions
        </div>
        <div class="col-lg-8">
            <div class="image-container">
                @foreach ($interests as $submission)
                    <div class="image bg-gray-800 rounded w-100 py-2 px-2 text-white flex justify-content-between align-items-center my-2 hover:bg-gray-600 hover:shadow transition">
                        <div class="info flex align-items-center">
                            <div class="details flex flex-col justify-content-center ml-4">
                                <span>{{ $submission->name }}</span>
                                <div class="overflow-ellipsis overflow-hidden max-h-10">
                                    {{ $submission->email }}
                                </div>
                            </div>
                        </div>

                        <div class="actions mx-2">
                            <a href="{{ route('interest.delete', ['id' => $submission->id]) }}">
                                <button class="uppercase px-2 py-2 h-75 text-sm bg-red-500 text-white shadow-sm hover:shadow-lg transition rounded">
                                    <svg width="16" height="16" preserveAspectRatio="xMidYMid meet" viewBox="0 0 32 32" style="transform: rotate(360deg);"><path d="M12 12h2v12h-2z" fill="currentColor"></path><path d="M18 12h2v12h-2z" fill="currentColor"></path><path d="M4 6v2h2v20a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8h2V6zm4 22V8h16v20z" fill="currentColor"></path><path d="M12 2h8v2h-8z" fill="currentColor"></path></svg>
                                </button>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            @if(!is_null($interests->links()))
                <div class="links-container rounded bg-gray-800 px-4 py-4 mt-4 text-white">
                    {{ $interests->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
