<?php

namespace FriendsOfHyva\EmailSuggestions\Magewire;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magewirephp\Magewire\Component;

class EmailSuggestions extends Component
{
    private ScopeConfigInterface $scopeConfig;

    // public string $name = ''; not allowed! reserved word!
    public string $fullname = '';
    public string $email = '';
    public string $message = '';
    public string $domains = '';

    /**
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig,
    ) {
        $this->scopeConfig = $scopeConfig;
    }

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

    public function boot(): void
    {
        $domains = $this->scopeConfig->getValue('friendsofhyva/emailchecker/custom_domains');

        if (!empty($domains)) {
            $this->domains = json_encode(array_map('trim', explode(',', $domains)));
        }
    }
}
