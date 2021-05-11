@extends('layouts.main')

@section('title', 'Backup Control')


@section('content')
    <div class="container-fluid">
        <div class="row my-4">
            <div class="col-lg-12 px-12">
                <backups-table :backups="{{ $backups }}"></backups-table>
            </div>
        </div>
    </div>
@endsection
