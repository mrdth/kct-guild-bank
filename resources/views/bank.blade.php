@extends('layouts.app')

@section('content')
@foreach($characters as $character)
    <div class="flex flex-col">
        <div class="flex justify-between">
            <div>{{ $character->name }}</div>
            <div>
                @foreach($character->formatCurrency() as $name => $count)
                    <span class="currency {{ $name }}">{{ $count }}</span>
                @endforeach
            </div>
        </div>
        <div class="flex-justify-start pt-4">
            @foreach($character->inventory as $item)
                <span class="inline-block pr-4 mb-4">
                    <a href="https://tbc.wowhead.com/?item={{ $item->id }}" @if($item->suffix)rel="rand={{ $item->suffix }}"@endif>&nbsp;{{ $item->pivot->quantity }}</a>
                </span>
            @endforeach
        </div>
    </div>

@endforeach
@endsection
