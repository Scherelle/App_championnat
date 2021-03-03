<?php

namespace App\Repositories;

class Ranking { 
    function goalDifference(int $goalFor, int $goalAgainst): int {
        return $goalFor - $goalAgainst;
    }
    
    function points(int $wonMatchCount, int $drawMatchCount) : int { // match gagné et match nul 
        return 3 * $wonMatchCount + 1 * $drawMatchCount;
    }

    function teamWinsMatch(int $teamId, array $match) : bool {
        return ( $match['team0'] == $teamId && $match['score0'] > $match['score1']  ) ||
        ( $match['team1'] == $teamId && $match['score1'] > $match['score0'] ) ? true : false ;
    }

    function teamLosesMatch (int $teamId, array $match) : bool {
        return ( $match['team0'] == $teamId && $match['score0'] < $match['score1']  ) ||
        ( $match['team1'] == $teamId && $match['score1'] < $match['score0'] ) ? true : false ;
    }

    function teamMakesADraw(int $teamId, array $match) : bool {
        return ( $match['team0'] == $teamId && $match['score0'] == $match['score1']  ) ||
        ( $match['team1'] == $teamId && $match['score1'] == $match['score0'] ) ? true : false ;
    }

    function goalForCountDuringAMatch(int $teamId, array $match) : int {
        return  $match['team0'] == $teamId ? $match['score0'] : ( $match['team1'] == $teamId ? $match['score1'] : 0 );
    }

    function goalAgainstCountDuringAMatch (int $teamId, array $match) : int {
        return ($match['team0'] == $teamId ? $match['score1'] : ($match['team1'] == $teamId ? $match['score0'] : 0 ) );
    }

    function goalForCount(int $teamId, array $matches) : int {
        $sum = 0;
        foreach ($matches as $match) 
            $sum += $this -> goalForCountDuringAMatch($teamId, $match);
        return $sum;
    }

    function goalAgainstCount(int $teamId, array $matches) : int {
        $sum = 0;
        foreach ($matches as $match) {
            $sum += $this -> goalAgainstCountDuringAMatch($teamId, $match);
        }
        return $sum;
    }

    function wonMatchCount(int $teamId, array $matches) : int {
        $count = 0;
        foreach ($matches as $match) {
            if( $this -> teamWinsMatch( $teamId, $match)){
                $count++;
            }
        }
        return $count;
    }

    function lostMatchCount(int $teamId, array $matches) : int {
        $count = 0;
        foreach ($matches as $match) {
            if( $this -> teamLosesMatch( $teamId, $match)){
                $count++;
            }
        }
        return $count;
    }

    function drawMatchCount( int $teamId, array $matches) : int {
        $count = 0;
        foreach ($matches as $match) {
            if( $this -> teamMakesADraw( $teamId, $match)){
                $count++;
            }
        }
        return $count;
    }



    function rankingRow(int $teamId, array $matches) : array {

        $wonMatchCount = $this -> wonMatchCount($teamId, $matches);
        $lostMatchCount = $this -> lostMatchCount($teamId, $matches);
        $drawMatchCount = $this -> drawMatchCount($teamId, $matches);
        $matchPlayedCount = $wonMatchCount +  $drawMatchCount + $lostMatchCount;
        $goalForCount = $this -> goalForCount($teamId, $matches);
        $goalAgainstCount = $this -> goalAgainstCount($teamId, $matches);
        $goalDifference = $this -> goalDifference($goalForCount, $goalAgainstCount);
        $points = $this -> points($wonMatchCount, $drawMatchCount);

        return [
            'team_id'            => $teamId,
            'match_played_count' => $matchPlayedCount,
            'won_match_count'    => $wonMatchCount,
            'lost_match_count'   => $lostMatchCount,
            'draw_match_count'   => $drawMatchCount,
            'goal_for_count'     => $goalForCount,
            'goal_against_count' => $goalAgainstCount,
            'goal_difference'    => $goalDifference,
            'points'             => $points
        ];
    }

    function unsortedRanking(array $teams, array $matches) : array {
        $res = [];
        foreach ($teams as $team) {
            $res[] = $this -> rankingRow($team['id'], $matches);
        }
        return $res;
    }

    static function compareRankingRow(array $row1, array $row2): int   {
        return ( ($row1['points'] > $row2['points']) || 
        ( $row1['points'] == $row2['points'] && $row1['goal_difference'] > $row2['goal_difference']) ||
        ( $row1['points'] == $row2['points'] && $row1['goal_difference'] == $row2['goal_difference'] && $row1['goal_for_count'] > $row2['goal_for_count']))
         ? -1 : ( ( ($row1['points'] < $row2['points']) || 
                ( $row1['points'] == $row2['points'] && $row1['goal_difference'] < $row2['goal_difference']) ||
                ( $row1['points'] == $row2['points'] && $row1['goal_difference'] == $row2['goal_difference'] && $row1['goal_for_count'] < $row2['goal_for_count']) ) ? 1 : 0) ; 
    }

    function sortedRanking(array $teams, array $matches): array {
        $result = $this -> unsortedRanking($teams, $matches);
        usort($result, ['App\Repositories\Ranking', 'compareRankingRow']);
        for ($rank = 1; $rank <= count($teams); $rank++) {
            $result[$rank - 1]['rank'] = $rank;
        }
        return $result;
    }

    

    
}


