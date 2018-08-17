<?php

namespace App\Command;

use App\Generator\LockGenerator;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class LockCommand extends Command
{
    const ALLOWED_TYPES = ['composer', 'yarn', 'all'];
    const ALLOWED_REPOSITORIES = ['pim-community-dev', 'pim-enterprise-dev'];

    public function __construct(LockGenerator $lockGenerator)
    {
        $this->lockGenerator = $lockGenerator;

        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setName('app:generate-lock')
            ->setDescription('Generate lock files')
            ->addArgument('type', InputArgument::REQUIRED, 'Type of the lock to generate (composer, yarn or all for both)')
            ->addArgument('repository', InputArgument::REQUIRED, 'Repository to generate (pim-community-dev, pim-enterprise-dev)')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $type = $input->getArgument('type');
        $repository = $input->getArgument('repository');
        if (!in_array($type, self::ALLOWED_TYPES)) {
            throw new \InvalidArgumentException(sprintf('Type "%s" not allowed (allowed types: %s)', $type, implode(', ', self::ALLOWED_TYPES)));
        }

        if (!in_array($repository, self::ALLOWED_REPOSITORIES)) {
            throw new \InvalidArgumentException(sprintf('Repository "%s" not allowed (allowed repositories: %s)', $repository, implode(', ', self::ALLOWED_REPOSITORIES)));
        }

        // $this->lockGenerator->generate($output, $type, 'pim-enterprise-standard');
        $this->lockGenerator->generate($output, $type, $repository);
    }
}
