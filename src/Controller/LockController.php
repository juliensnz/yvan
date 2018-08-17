<?php

namespace App\Controller;

use App\Helper\ProcessRunner;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @package App\Controller
 * @Route("/lock/{repository}/{type}")
 */
class LockController
{
    private $processRunner;
    private $rootdir;

    const DEFAULT_TYPE = 'all';
    const ALLOWED_TYPES = ['composer', 'yarn', 'all'];
    const DEFAULT_REPOSITORY = 'pim-enterprise-dev';
    const ALLOWED_REPOSITORIES = ['pim-community-dev', 'pim-enterprise-dev'];

    public function __construct(ProcessRunner $processRunner, string $rootdir)
    {
        $this->processRunner = $processRunner;
        $this->rootdir = $rootdir;
    }

    /**
     * @return JsonResponse
     */
    public function lock(Request $request)
    {
        $userInput = $request->request->get('text');

        $parameters = explode(' ', $userInput);
        $type = isset($parameters[0]) && !empty($parameters[0]) ? $parameters[0] : self::DEFAULT_TYPE;
        $repository = $parameters[1] ?? self::DEFAULT_REPOSITORY;

        if (!in_array($type, self::ALLOWED_TYPES)) {
            throw new \InvalidArgumentException(sprintf('Type "%s" not allowed (allowed types: %s)', $type, implode(', ', self::ALLOWED_TYPES)));
        }

        if (!in_array($repository, self::ALLOWED_REPOSITORIES)) {
            throw new \InvalidArgumentException(sprintf('Repository "%s" not allowed (allowed repositories: %s)', $repository, implode(', ', self::ALLOWED_REPOSITORIES)));
        }

        echo $this->processRunner->runAsyncCommand(sprintf('%s/../bin/console --env=prod app:generate-lock %s %s', $this->rootdir, $type, $repository));

        return new JsonResponse();
    }
}
