@extends('base')

@section('title', 'Authentification')

@section('content')
<form method="POST" action="{{route('password.change')}}" >
@csrf
    @if ($errors->any())
        <div class="alert alert-warning">
          Vous n'avez pas pu être authentifié &#9785;
        </div>
    @endif
    <div class="form-group">
      <label for="old_password">Ancien mot de passe</label>
      <input type="password" id="old_password" name="email" value=""
             aria-describedby="old_password_feedback" class="form-control @error('old_password') is-invalid @enderror"> 
      @error('email')
      <div id="old_password_feedback" class="invalid-feedback">
        {{ $message }}
      </div>
      @enderror
    </div>
    <div class="form-group">
      <label for="new_password">Nouveau mot de passe</label>
      <input type="password" id="new_password" name="new_password" value=""
             aria-describedby="new_password_feedback" class="form-control @error('new_password') is-invalid @enderror">  
      @error('new_password')
      <div id="new_password_feedback" class="invalid-feedback">
        {{ $message }}
      </div>
      @enderror
      <div class="form-group">
      <label for="new_password">Nouveau mot de passe</label>
      <input type="password" id="new_password" name="new_password" value=""
             aria-describedby="new_password_feedback" class="form-control @error('new_password') is-invalid @enderror">  
      @error('new_password')
      <div id="new_password_feedback" class="invalid-feedback">
        {{ $message }}
      </div>
      @enderror
    </div>
    <button type="submit" class="btn btn-primary">Confirmer</button>
</form>
@endsection