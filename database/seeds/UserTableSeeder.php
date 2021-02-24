<?php
 
class UserTableSeeder extends Seeder
{
 
public function run()
{
DB::table('users')-&gt;delete();
&nbsp;&nbsp;&nbsp; User::create(array(
'password' => Hash::make('logicue'),
'email' => 'logicue.com',
));
}
}