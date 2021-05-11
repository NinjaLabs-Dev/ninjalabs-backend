@extends('layouts.main')

@section('title', 'Backup Control')


@section('content')
    <div class="container-fluid">
        <div class="row my-4">
            <div class="col-lg-12 px-12">
                <twitch-users-table></twitch-users-table>
            </div>
        </div>
    </div>
@endsection
