<?php

namespace App\Http\Livewire\User;

use Livewire\Component;
use App\Models\User;

class Register extends Component
{
    public $name, $email, $password, $password_confirmation;

    public function register(){
        $this->validate([

            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|string|min:8',

        ]);
        $user = new User();

        $user->name = $this->name;
        $user->email = $this->email;
        $user->password = bcrypt($this->password);
        $user->save();

        return redirect('/login')->with('message', 'Your account has been created successfully!');

    }

    public function render()
    {
        return view('livewire.user.register');
    }
}
