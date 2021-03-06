@extends('layout')

@section('title', __('admin/events.classes.fleets.create.title', ['event.name' => $event->name, 'event_class.name' => $eventClass->name]))

@section('content')
    <div class="breadcrumb">
        <ul>
            <li><a href="{{ route('home') }}">{{ config('app.name') }}</a></li>
            <li><a href="{{ route('admin.home') }}">@lang('admin/home.breadcrumb')</a></li>
            <li><a href="{{ route('admin.events.index') }}">@lang('admin/events.index.breadcrumb')</a></li>
            <li><a href="{{ route('admin.events.show', $event) }}">{{ $event->name }}</a></li>
            <li><a href="#">@lang('admin/events.classes.index.breadcrumb')</a></li>
            <li><a href="#">{{ $eventClass->name }}</a></li>
            <li><a href="#">@lang('admin/events.classes.fleets.index.breadcrumb')</a></li>
            <li class="is-active"><a href="{{ route('admin.events.classes.fleets.create', [$event, $eventClass]) }}">@lang('admin/events.classes.fleets.create.breadcrumb')</a></li>
        </ul>
    </div>

    <h1 class="title">@lang('admin/events.classes.fleets.create.header')</h1>

    <form method="POST" action="{{ route('admin.events.classes.fleets.store', [$event, $eventClass]) }}">
        @csrf

        <div class="field">
            <label class="label" for="name">@lang('admin/events.classes.fleets.create.name')</label>

            <div class="control">
                <input class="input @error('name') is-danger @enderror" type="text" id="name"
                    name="name" value="{{ old('name') }}" required>
            </div>

            @error('name')
                <p class="help is-danger">{{ $errors->first('name') }}</p>
            @enderror
        </div>

        <div class="field">
            <div class="control">
                <button class="button is-link" type="submit">@lang('admin/events.classes.fleets.create.create_button')</button>
            </div>
        </div>
    </form>
@endsection
