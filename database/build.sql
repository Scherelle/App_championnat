DROP TABLE IF EXISTS users;
DROP TABLE IF EXISTS ranking;
DROP TABLE IF EXISTS matches;
DROP TABLE IF EXISTS teams;

CREATE TABLE teams(
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name VARCHAR(50) NOT NULL
  );

  CREATE TABLE matches(
      id INTEGER PRIMARY KEY AUTOINCREMENT,
      team0 INTEGER ,
      team1 INTEGER,
      score0 INTEGER,
      score1 INTEGER,
      date DATETIME,
      FOREIGN KEY (team0) REFERENCES teams(id),
      FOREIGN KEY (team1) REFERENCES teams(id),
      UNIQUE (team0, team1)
  );


CREATE TABLE ranking (
    team_id  INTEGER PRIMARY KEY, 
    rank INTEGER, 
    match_played_count INTEGER,
    won_match_count INTEGER , 
    lost_match_count INTEGER ,  
    draw_match_count  INTEGER , 
    goal_for_count  INTEGER ,   
    goal_against_count INTEGER , 
    goal_difference  INTEGER , 
    points  INTEGER , 
    FOREIGN KEY (team_id) REFERENCES teams(id),
    UNIQUE(rank)          
);

CREATE TABLE users (
    id  INTEGER PRIMARY KEY AUTOINCREMENT, 
    email VARCHAR(128) NOT NULL, 
    password_hash VARCHAR(128) NOT NULL,
    UNIQUE(email)
) ;
