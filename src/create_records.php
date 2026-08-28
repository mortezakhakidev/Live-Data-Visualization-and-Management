<?php
// init required repositories

// @https://github.com/fzaninotto/Faker
// @https://github.com/ThingEngineer/PHP-MySQLi-Database-Class

require 'vendor/autoload.php';
require 'db.php';

$faker = Faker\Factory::create('en_US');

for ($i=0; $i <= 100; $i++) {

	$data = Array (
		'first_name' 	=> $faker->firstName,
		'last_name' 	=> $faker->lastName,
		'city' 			=> $faker->city,
		'date' 			=> $faker->dateTimeBetween('-100 years', 'now', null)->format('Y-m-d'),
		'nummeric_one'	=> $faker->numberBetween(1000, 9999),
		'nummeric_two'	=> $faker->numberBetween(100000, 999999)
	);
	$id = $db->insert ('data', $data);
} 



