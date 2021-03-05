@extends('base')

@section('title', 'Création d\'un match')

@section('content')
<form method="POST" action="{{route('matches.store')}}">
@csrf
    @if ($errors->any())
        <div class="alert alert-warning">
            Le Match n'a pas pu être ajoutée &#9785;
        </div>
    @endif
    <div class="form-group">
      <label for="team0">Équipe à domicile</label>
      <select class="form-control" id="team0" name="team0">
      <option value="0">Sélectionnez une équipe</option>
        @foreach($teams as $team)
        <option value="{{$team['id']}}" @if(old('team0')==$team['id']) selected @endif>{{$team['name']}}</option>
        @endforeach
      </select>
    </div>
    <div class="form-group">
      <label for="team1">Équipe à l'extérieur</label>
      <select class="form-control" id="team1" name="team1">
      <option value="0" selected>Sélectionnez une équipe</option>
        @foreach($teams as $team)
        <option value="{{$team['id']}}" @if (old('team1')==$team['id']) selected @endif>{{$team['name']}}</option>
        @endforeach
      </select>
    </div>
    <div class="form-group">
      <label for="date">Date</label>
      <input type="date" id="date" name="date"  aria-describedby="date_feedback" class="form-control @error('date') is-invalid @enderror" value="{{old('date')}}" required>
      @error('date') 
      <div id="date_feedback" class="invalid-feedback">
      {{$messages}}
      </div>
      @enderror
    </div>
    <div class="form-group">
      <label for="time">Heure</label>
      <input type="time" id="time" name="time" aria-describedby="time_feedback" class="form-control @error('time') is-invalid @enderror" required>
      @error('time') 
      <div id="time_feedback" class="invalid-feedback">
      {{$messages}}
      </div>
      @enderror
    </div>
    <div class="form-group">
      <label for="score0">Nombre de buts de l'équipe à domicile</label>
      <input type="number" class="form-control" id="score0" name="score0" min="0">
    </div>
    <div class="form-group">
      <label for="score1">Nombre de buts de l'équipe à l'extérieur</label>
      <input type="number" class="form-control" id="score1" name="score1" min="0">
    </div>
    <button type="submit" class="btn btn-primary">Soumettre</button>
</form>
@endsection
