<?php

class DatabaseSeeder extends Seeder {

    private $tables = [
        'assigned_roles',
        'authors',
        'categories',
        'comments',
        'contacts',
        'countries',
        'events',
        'failed_jobs',
        'favorites',
        'followers',
        'locations',
        'migrations',
        'password_reminders',
        'roles',
        'permission_role',
        'permissions',
        'photos',
        'posts',
        'subscriptions',
        'users'
    ];
    public function run()
    {
        Eloquent::unguard();
        $this->cleanDatabase();

        // Add calls to Seeders here
        $this->call('UsersTableSeeder');
        $this->call('RolesTableSeeder');
        $this->call('PermissionsTableSeeder');
        $this->call('CountriesTableSeeder');
        $this->call('LocationsTableSeeder');
        $this->call('CategoriesTableSeeder');
        $this->call('PostsTableSeeder');
		$this->call('EventsTableSeeder');
        $this->call('CommentsTableSeeder');
        $this->call('FollowersTableSeeder');
		$this->call('FavoritesTableSeeder');
		$this->call('SubscriptionsTableSeeder');
		$this->call('PhotosTableSeeder');
		$this->call('AuthorsTableSeeder');
        $this->call('ContactsTableSeeder');
	}

    private function cleanDatabase()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        foreach ($this->tables as $table) {
            DB::table($table)->truncate();
        }
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

    }

}