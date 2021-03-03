@extends('base')
<!doctype html>
<html>
    <head>
    @section('title')
    Matchs de l'équipe
    @endsection
    </heead>
    <body>
    @section('content')
    <a class="btn btn-primary" href="{{ route('teams.follow', ['teamId'=>$row['team_id']]) }}">Suivre</a><br><br>
    <table class="table table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th>N°</th><th>Équipe</th><th>MJ</th><th>G</th><th>N</th><th>P</th><th>BP</th><th>BC</th><th>DB</th><th>PTS</th></tr>
                </thead>
                <tbody>
                        <tr>
                        <td>{{$row['rank']}}</td>
                        <td>{{$row['name']}}</td>
                        <td>{{$row['match_played_count']}}</td>
                        <td>{{$row['won_match_count']}}</td>
                        <td>{{$row['draw_match_count']}}</td>
                        <td>{{$row['lost_match_count']}}</td>
                        <td>{{$row['goal_for_count']}}</td>
                        <td>{{$row['goal_against_count']}}</td>
                        <td>{{$row['goal_difference']}}</td>
                        <td>{{$row['points']}}</td>
                        </tr>
                </tbody>
            </table>
        <table class="table table-striped">
            @foreach($matches as $match) 
                <tr><td>{{$match['date']}}</td>
                <td><a href="{{route('teams.show', ['teamId'=>$match['team0']])}}">{{$match['name0']}}</a></td>
                <td>{{$match['score0']}} - {{$match['score1']}}</td>
                <td><a href="{{route('teams.show', ['teamId'=>$match['team1']])}}">{{$match['name1']}}</a></td></tr>  
            @endforeach
        </table>
    @endsection
    </body>
</html>