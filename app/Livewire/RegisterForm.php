<?php

namespace App\Livewire;

use Livewire\Component;

class RegisterForm extends Component
{
    public bool|null $isPopUp = false;

    public function mount(?bool $isPopUp = false)
    {
        $this->isPopUp = $isPopUp;
    }

    public function render()
    {
        return view('livewire.register-form');
    }
}
