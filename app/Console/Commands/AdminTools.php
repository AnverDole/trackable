<?php

namespace App\Console\Commands;

use App\Models\User;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminTools extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:tools';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Super admin account managment tool.';

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
     * @return int
     */
    public function handle()
    {


        $this->output->writeln("\n===============================================");
        $this->output->writeln("Admin toolkit");
        $this->output->writeln("===============================================");

        while (true) {
            $this->output->writeln("\nMain menu");
            $this->output->writeln("1) Create a super admin");
            $this->output->writeln("2) View all super admins");
            $choise = $this->output->ask("Choose one [1, 2]: ");

            if (!in_array($choise, ["1", "2"])) {
                $this->output->writeln("Invalid choise!");
                continue;
            }

            switch ($choise) {
                case "1":
                    $this->createSuperAdmin();
                    break 1;
                case "2":
                    $this->viewAllSuperAdmins();
                    break 1;
            }
        }

        return 0;
    }

    private function createSuperAdmin()
    {
        while (true) {
            $this->output->writeln("\nCreate Super Admin\n");
            $firstname = $this->output->ask("First name: ");
            $lastname = $this->output->ask("Last name: ");
            $email = $this->output->ask("Email: ");
            $password = $this->output->ask("Password (empty -> default): ");

            $validator = Validator::make([
                "firstname" => $firstname,
                "lastname" => $lastname,
                "email" => $email,
                "password" => $password,
            ], [
                "firstname" => "required|string",
                "lastname" => "required|string",
                "email" => "required|email|unique:users,email",
                "password" => "required|min:8",
            ]);

            if ($validator->fails()) {
                if ($validator->errors()->count() > 0) {
                    $this->output->writeln("There were errors on your input.");
                }
                foreach ($validator->errors()->toArray() as $key => $error) {
                    $this->output->writeln("{$key} ==> {$error[0]}");
                }
                continue;
            }

            $data = (object)$validator->validated();

            try {
                $user = new User();
                $user->firstname = $data->firstname;
                $user->lastname = $data->lastname;
                $user->email = $data->email;
                $user->role = User::$USER_ROLE_SUPER_ADMIN;

                $password = $data->password;
                $user->password = Hash::make($password);
                $user->save();

                $this->output->writeln("Admin inserted.");
                $this->output->writeln("Email: {$user->email}");
                $this->output->writeln("Name: {$user->firstname} {$user->lastname}");
                $this->output->writeln("Password: {$password}");
                $this->output->writeln("");
            } catch (Exception $e) {
                $this->output->writeln("Something is wrong! please try again.");
            }

            break;
        }
    }
    private function viewAllSuperAdmins()
    {
        $this->output->writeln("\nAll Super Admins\n");

        while (true) {
            $superAdmins = User::FilterRole(User::$USER_ROLE_SUPER_ADMIN)->get();
            foreach ($superAdmins as $admin) {
                $this->output->writeln("ID:    {$admin->id}");
                $this->output->writeln("Name:  {$admin->firstname} {$admin->firstname}");
                $this->output->writeln("Email: {$admin->email} \n");
            }
        }
    }
}
