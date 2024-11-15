<?php

namespace App\Core\User\Application\Command\CreateUser;

use App\Core\User\Domain\Exception\UserNotFoundException;
use App\Core\User\Domain\Repository\UserRepositoryInterface;
use App\Core\User\Domain\User;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class CreateUserHandler
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository
    ) {}

    public function __invoke(CreateUserCommand $command): void
    {
        try {
            $this->userRepository->getByEmail($command->email);
        }catch (UserNotFoundException $exception) {
            $this->userRepository->save(new User(
                $command->email,false
            ));

            $this->userRepository->flush();
        }
    }
}
