@extends('base')

    @section('title')
    Classement
    @endsection
      
        @section('content')
            <table class="table table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th>N°</th><th>Équipe</th><th>MJ</th><th>G</th><th>N</th><th>P</th><th>BP</th><th>BC</th><th>DB</th><th>PTS</th></tr>
                </thead>
                <tbody>
                @foreach ($ranking as $rank)
                    <tr class="@if (Cookie::get('followed_team')==$rank['team_id']) table-primary @endif" ><td>{{ $rank['rank']}}</td>
                    <td><a href="{{route('teams.show' , ['teamId'=>$rank['team_id']])}}">{{ $rank['name']}}</a></td>
                    <td>{{$rank['match_played_count']}}</td>
                    <td>{{$rank['won_match_count']}}</td>
                    <td>{{$rank['draw_match_count']}}</td>
                    <td>{{$rank['lost_match_count']}}</td>
                    <td>{{$rank['goal_for_count']}}</td>
                    <td>{{$rank['goal_against_count']}}</td>
                    <td>{{$rank['goal_difference']}}</td>
                    <td>{{$rank['points']}}</td></tr>
                @endforeach
                </tbody>
            </table>
        @endsection
       
