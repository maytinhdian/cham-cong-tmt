<?php

namespace App\Http\Livewire\Auth;

use Illuminate\Validation\ValidationException;
use Livewire\Component;

class Login extends Component
{
    public $login='';

    public $password='';

    protected $rules= [
        'login' => 'required|string',
        'password' => 'required'

    ];

    /**
     * Render the login form that accepts email or employee code.
     */
    public function render()
    {
        return view('livewire.auth.login');
    }

    /**
     * Fill demo credentials for the template admin account.
     */
    public function mount() {

        $this->fill(['login' => 'admin@material.com', 'password' => 'secret']);
       
    }

    /**
     * Authenticate with either email address or employee-code username.
     */
    public function store()
    {
        $attributes = $this->validate();
        $loginField = filter_var($attributes['login'], FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        if (! auth()->attempt([
            $loginField => $attributes['login'],
            'password' => $attributes['password'],
        ])) {
            throw ValidationException::withMessages([
                'login' => 'Thông tin đăng nhập chưa đúng.'
            ]);
        }

        session()->regenerate();

        return redirect()->route('analytics');

    }
}
