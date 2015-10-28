@extends('master')

@section('content')
    <div class="row">
        <div class="col-md-4 lowertop">
            <h1>ssst.... </br>hier speelt den <img src="img/duvel.png" alt="duvel" class="logo"></h1>
            <h2>over de wedstrijd</h2>
            <p>
                wil jij een gratis bak Duvel winnen?</br>
                een prachtig Duvel designer glass misschien?</br>
                dit is je kans!</br>
                upload je beste foto met Duvel erop nu!</br>
                nodig al je vrienden uit om je foto te liken</br>
                elke week kan er iemand winnen!!</br>
                doe zo snel mogelijk mee, </br>
                dan maak je meer kans!!
            </p>
            <div class="col-md-offset-3 col-md-6 playNow center">
                <a href="{{ route('competition') }}" >play now!</a>
            </div>
        </div>
        <div class="col-md-6"><img src="img/duvel-bottle-plus-glass.png" alt="a duvel bottle and it's glass"></div>
    </div>
    @if($winners && $winners->first())
        <div class="row">
            <h2>the winners</h2>
                @foreach($winners as $winner)
                    <div class="col-md-3">
                        <img src="{{$winner->competitor->picture_url}}" alt="test">
                    </div>
                @endforeach
        </div>
    @endif
@stop