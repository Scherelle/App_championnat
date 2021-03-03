<?php

use Illuminate\Database\Seeder;
use App\Repositories\Repository;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        touch('database/database.sqlite');
        $repository = new Repository();
        $repository->createDatabase();
        $repository->fillDatabase();
        $repository->updateRanking();
        $repository->addUser('user@example.com', 'secret');
        $repository->addUser('celiacci86@google.com', 'celiacci');
        $repository->addUser('gloireemy@yahoo.fr', 'gloire');
    }
  

}

