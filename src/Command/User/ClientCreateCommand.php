<?php


namespace App\Command\User;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use FOS\OAuthServerBundle\Model\ClientManagerInterface;

class ClientCreateCommand extends Command
{
    protected static $defaultName = 'oauth:client:create';

    private $clientManager;

    public function __construct(ClientManagerInterface $clientManager)
    {
        $this->clientManager = $clientManager;

        parent::__construct();
    }

    protected function configure ()
    {
        $this
            ->setName('oauth:client:create')
            ->setDescription('Creates a new oauth client')
            ->addOption('redirect-uri', null, InputOption::VALUE_REQUIRED | InputOption::VALUE_IS_ARRAY, 'Sets the redirect uri. Use multiple times to set multiple uris.', null)
            ->addOption('grant-type', null, InputOption::VALUE_REQUIRED | InputOption::VALUE_IS_ARRAY, 'Set allowed grant type. Use multiple times to set multiple grant types', null)
        ;
    }
    protected function execute (InputInterface $input, OutputInterface $output)
    {
        $client = $this->clientManager->createClient();
        $client->setRedirectUris($input->getOption('redirect-uri'));
        $client->setAllowedGrantTypes($input->getOption('grant-type'));
        $this->clientManager->updateClient($client);
        $output->writeln("Added a new client with  public id <info>".$client->getPublicId()."</info> and secret <info>".$client->getSecret()."</info>");
    }
}