<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
class application extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'application:install';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'This will install the application & set up DB';

  /**
   * Create a new command instance.
   *
   * @return void|mixed
   */
  public function __construct()
  {
      parent::__construct();
  }

  /**
   * Execute the console command.
   *
   * @return mixed
   */
  public function handle()
  {
      $this->line("You can use Ctrl+C to exit the installer any time.\n");
      $this->createDatabase();
      $this->migrate();
      $this->seed();
      $this->setUpKey();
  }

  /**
   * This method creates the database by taking inputs from the user.
   *
   * @return void
  */
  private function createDatabase(){
      if($this->testDbConnection()){
          return;
      }

      $this->line("You need to choose a database type.");

      install_database:

      $connection = null;
      $host = null;
      $port = null;
      $database = null;
      $username = null;
      $password = null;

      $available_connections = array_keys(config('database.connections'));
      $connection = $this->choice('Choose a connection type', $available_connections);

      if($connection == "sqlite"){
          $path = database_path('database.sqlite');
          touch($path);
          $this->info('Database file created at ' . $path);
      } else{
          $defaultPort = $connection == "mysql" ? 3306
                             : ($connection == "pgsql" ? 5432 : null);

          $host = $this->ask('Database host', 'localhost');
          $port = $this->ask('Database port', $defaultPort);
          $database = $this->ask('Database name');
          $username = $this->ask('Database username');
          $password = $this->secret('Database password');
      }

      $settings = compact('connection', 'host', 'port', 'database', 'username', 'password');
      $this->updateEnvironmentFile($settings);

      if(!$this->testDbConnection()){
          $this->error('Could not connect to database.');
          goto install_database;
      }
  }

  /**
   * This method is to test the DB connection.
   *
   * @return boolean
  */
  private function testDbConnection(){
      $this->line('Checking DB connection.');

      try{
          DB::connection(DB::getDefaultConnection())->reconnect();
      }catch(\Exception $e){
          return false;
      }

      $this->info('Database connection working.');
      return true;
  }

  /**
   * Updates the environment file with the given database settings.
   *
   * @param  string  $settings
   * @return void
   */
  private function updateEnvironmentFile($settings)
  {
      $env_path = base_path('.env');
      DB::purge(DB::getDefaultConnection());

      foreach($settings as $key => $value){
          $key = 'DB_' . strtoupper($key);
          $line = $value ? ($key . '=' . $value) : $key;
          putenv($line);
          file_put_contents($env_path, preg_replace(
              '/^' . $key . '.*/m',
              $line,
              file_get_contents($env_path)
          ));
      }

      config()->offsetSet("database", include(config_path('database.php')));

  }

  /**
   * Migrate the Database.
   *
   * @return void
  */
  private function migrate(){
      $this->line("\nStarting DB Migration...");
      $this->call('migrate');
  }

  /**
   * Seeds the Database.
   *
   * @return void
  */
  private function seed(){
      $this->line("\nStarting DB Seeding...");
      $this->call('db:seed');
  }

  /**
   * Sets up the application key.
   *
   * @return void
  */
  private function setUpKey(){
      $this->call('key:generate');
      $this->info("\nApplication installation completed!");
  }
}
