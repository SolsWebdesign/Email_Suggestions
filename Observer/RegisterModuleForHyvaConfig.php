<?php
declare(strict_types=1);
namespace FriendsOfHyva\EmailSuggestions\Observer;
use Magento\Framework\Component\ComponentRegistrar;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

class RegisterModuleForHyvaConfig implements ObserverInterface
{
    public function __construct(
        private ComponentRegistrar $componentRegistrar)
    {}

    public function execute(Observer $event)
    {
        $path = $this->componentRegistrar->getPath(ComponentRegistrar::MODULE, 'FriendsOfHyva_EmailSuggestions');
        $path = substr($path, strlen(BP) + 1); // making the path relative

        $config = $event->getData('config');
        $extensions = $config->hasData('extensions') ? $config->getData('extensions') : [];
        $extensions[] = ['src' => $path];
        $config->setData('extensions', $extensions);
    }
}
