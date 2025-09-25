<?php

namespace FriendsOfHyva\EmailSuggestions\Magewire;

use Magewirephp\Magewire\Component;

class EmailSuggestions extends Component
{
    // public string $name = ''; not allowed! reserved word!
    public string $fullname = '';
    public string $email = '';
    public string $message = '';

    public string $domains = '["multisafepay.com", "hyva.io"]';

    public function sendMessage()
    {
        $fullname = trim($this->fullname);
        $email = trim($this->email);
        $message = trim($this->message);

        if(strlen($fullname) < 3) {
            $this->dispatchErrorMessage(__('Fullname must be at least 3 characters long.'));
            return false;
        }
        if(strlen($message) < 3) {
            $this->dispatchErrorMessage(__('Message must be at least 3 characters long.'));
            return false;
        }
        if(strlen($email) < 3) {
            $this->dispatchErrorMessage(__('Email must be at least 3 characters long.'));
            return false;
        }
        if(false === filter_var($email,FILTER_VALIDATE_EMAIL)) {
            $this->dispatchErrorMessage(__('Invalid email format.'));
            return false;
        }

        return true;
    }
}
