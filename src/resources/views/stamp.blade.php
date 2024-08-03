@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/stamp.css') }}">
@endsection

@section('content')
    <div class="header__wrap">
        <p class="header__text">
            {{ Auth::user()->name }}さんお疲れ様です！
        </p>
    </div>

    <form class="form__wrap" action="{{ route('work') }}" method="post">
        @csrf
        <div class="form__item">
            @if($status == 0 || $status == 3)
                <button class="form__item-button" type="submit" name="start_work">勤務開始</button>
            @else
                <button class="form__item-button" type="submit" name="start_work" disabled>勤務開始</button>
            @endif
        </div>
        <div class="form__item">
            @if($status == 1)
                <button class="form__item-button" type="submit" name="end_work">勤務終了</button>
            @else
                <button class="form__item-button" type="submit" name="end_work" disabled>勤務終了</button>
            @endif
        </div>
        <div class="form__item">
            @if($status == 1)
                <button class="form__item-button" type="submit" name="start_rest">休憩開始</button>
            @else
                <button class="form__item-button" type="submit" name="start_rest" disabled>休憩開始</button>
            @endif
        </div>
        <div class="form__item">
            @if($status == 2)
                <button class="form__item-button" type="submit" name="end_rest">休憩終了</button>
            @else
                <button class="form__item-button" type="submit" name="end_rest" disabled>休憩終了</button>
            @endif
        </div>
    </form>
@endsection