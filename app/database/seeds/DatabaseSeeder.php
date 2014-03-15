<?php

class DatabaseSeeder extends Seeder {

    public function run()
    {
        Eloquent::unguard();

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

}