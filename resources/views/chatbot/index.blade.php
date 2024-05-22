@extends('layouts.app')

@section('title', 'ChatBot')

@section('content')
    <h1>ChatBot Laravel</h1>

    <form action="{{ route('chatbot.ask') }}" method="POST">
        @csrf
        <div>
            <label for="question">Votre question</label>
            <input type="text" id="question" name="question" placeholder="Posez votre question ici">
        </div>
        <div>
            <button type="submit">Poser la question</button>
        </div>
    </form>

    @if (isset($answer))
        <h2>Réponse :</h2>
        <p>{{ $answer }}</p>
    @else
        <h2>En attente de votre question...</h2>
    @endif
@endsection
