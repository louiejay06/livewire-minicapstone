<?php

namespace App\Http\Livewire\User;

use Livewire\Component;
use App\Models\User;

class Login extends Component
{

    public $email, $password;


    public function login(){
        $this->validate([
            'email' => 'required|string',
            'password' => 'required|string',

        ]);

        $user = User::where('email', $this->email)->first();

        if(!$user){
            session()->flash('errorMsg', 'Sorry your account does not exist.');
            $this->email = '';
            $this->password = '';

        }else{
            $login = auth()->attempt([
                'email'    =>   $this->email,
                'password'    =>   $this->password,
            ]);

            if(!$login){
                session()->flash('errorMsg', 'Invalid Credentials');
                $this->email = '';
                $this->password = '';

            }else{
                return redirect('/');
            }
        }
    }

    public function render()
    {
        return view('livewire.user.login');
    }
}
