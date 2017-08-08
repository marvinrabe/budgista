<?php


namespace AppBundle\Handler;

use AppBundle\Command\UpdateAccountSettingsCommand;
use AppBundle\Domain\Repository\AccountRepository;

class UpdateAccountSettingsHandler
{

    protected $accountRepository;

    public function __construct(AccountRepository $accountRepository)
    {
        $this->accountRepository = $accountRepository;
    }

    /**
     * @param UpdateAccountSettingsCommand $command
     */
    public function handle(UpdateAccountSettingsCommand $command)
    {
        $account = $this->accountRepository->find($command->id);

        if ($account === null) {
            throw new \InvalidArgumentException('Account not found.');
        }

        if ($this->accountRepository->exists($command->name) && $account->getName() != $command->name) {
            throw new \InvalidArgumentException('Account with name "' . $command->name . '" already exists.');
        }

        $account->setName($command->name);
    }

}
