<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;

/**
 * Class AddUser
 * @package App\Console\Commands
 */
class AddUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:add';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add a user (admin)';

    /**
     * Create a new command instance.
     *
     * @return void
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
        $email = $this->ask('What is your E-mail?');
        $name = $this->ask('What is your name?');
        $password = $this->secret('What is the password?');
        $password_confirmation = $this->secret('Confirm password again:');

        $data = compact('email', 'name', 'password', 'password_confirmation');

        $this->validate($data);

        $this->createUser($data);

        $this->info("Account create successfully! Welcome, {$name}");
    }

    /**
     * @param array $data
     */
    protected function validate(array $data)
    {
        $validator = Validator::make($data, [
            'email' => 'required|email|unique:users',
            'name' => 'required|min:2',
            'password' => 'required|min:6|confirmed'
        ]);

        if ($validator->fails()) {
            $this->error($validator->errors()->first());
            exit;
        }
    }

    /**
     * @param $data
     */
    protected function createUser($data)
    {
        User::create(array_merge($data, [
            'password' => bcrypt($data['password'])
        ]));
    }
}
