<?php

namespace App\Repositories;

use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use app\Providers\EventServiceProvider;
//use App\Http\Controllers\Controller;

use App\Repositories\Data;
use App\Repositories\Ranking;


class Repository
{
function createDatabase(): void 
{
    DB::unprepared(file_get_contents('database/build.sql'));
}

function insertTeam(array $team): int
{
    //if($valideData!=$team)
       // throw new Exception("impossible d'ajouter cette équipe");
      return  DB::table('teams')->insertGetId($team) ;   
}

function insertMatch(array $match): int
{
    return  DB::table('matches')->insertGetId($match) ;
}

function teams(): array
{
     $teamTable = DB::table('teams')->orderBy('id')
                                    ->get()
                                    ->toArray();
     return $teamTable  ;
}

function matches(): array
{
    $this->teams() ;
    $matchesTable = DB::table('matches')->orderBy('id')
                                        ->get()
                                        ->toArray();
    return $matchesTable ;
}

function fillDatabase(): void 
{
    $data = new Data () ;
    foreach ($data->teams() as $team) 
    {
        $this->insertTeam($team) ;

    }

    foreach ($data->matches() as $match) 
    {
        $this->insertMatch($match) ;

    }

}

function team(int $teamId) : array
{
    
         $teams = DB::table('teams')->where('id', $teamId)->get()->toArray();
            if(count($teams)==0)
                throw new Exception('Équipe inconnue') ;  # ou l'appel d'une fonction ou méthode qui peut lever une exception
        return $teams[0];
          
}
function updateRanking(): void 
{
    $rank= new Ranking ();
    DB::table('ranking')->delete();
    $teams=$this->teams();
    $matches=$this->matches();
    $rows = $rank->sortedRanking($teams , $matches);
    DB::table('ranking')->insert($rows);
  
}
function sortedRanking():array
{
    return $rows = DB::table('ranking')->join('teams', 'ranking.team_id', '=', 'teams.id')->orderBy('rank')->get(['ranking.*', 'teams.name'])->toArray();
}
function teamMatches($teamId): array 
{
    return DB::table('matches')->join('teams as team0', 'matches.team0', '=', 'team0.id')
                                ->join('teams as team1', 'matches.team1', '=', 'team1.id')
                                ->where('matches.team0', $teamId)
                                ->orWhere('matches.team1', $teamId)
                                ->orderBy('date')
                                ->get(['matches.*', 'team0.name as name0', 'team1.name as name1'])
                                ->toArray();

}
function rankingRow($teamId):array
{
    $rows = DB::table('ranking')->join('teams', 'ranking.team_id', '=', 'teams.id')
                                            ->where('ranking.team_id', $teamId)
                                            ->get(['ranking.*', 'teams.name'])
                                            ->toArray();
    if(count($rows)==0)
        throw new Exception("Équipe inconnue") ;  
    return $rows[0];
       
}

function addUser(string $email, string $password): int
{
    $users = DB::table('users')->get()->toArray();
    $user = [];
    foreach($users as $user) {
        if(strcasecmp($email,$user['email'])==0)
            throw new Exception ('Un utilisateur avec cet email existe déjà') ;
    }
    $user = ['email'=>$email , 'password_hash'=>Hash::make($password)] ;
    return DB::table('users')->insertGetId($user);
}

function getUser(string $email, string $password): array
{
    $array =[];
    $array = DB::table('users')
                ->where('email','=', $email) 
                ->get()
                ->toArray();
    if(count($array)==0)
        throw new Exception('Utilisateur inconnu');
    if(!Hash::check($password, $array[0]['password_hash']))
        throw new Exception('Utilisateur inconnu');     
    return ['id'=>$array[0]['id'], 'email'=>$array[0]['email']] ;
}

function changePassword(string $email, string $oldPassword, string $newPassword): void 
{
    $user = $this->getUser($email, $oldPassword) ;
    $password_hash = Hash::make($newPassword) ;
    DB::table('users')->where('id', '=', $user['id'])
                        ->update(['password_hash'=>$password_hash]);
                        

}
function deleteMatch(int $match) : array
{
    $mathes = DB::table('matches')
        ->where('id', '=', $match)
        ->delete();
    return $mathes ;
}
}