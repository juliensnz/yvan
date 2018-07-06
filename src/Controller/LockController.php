<?php

namespace App\Controller;

use App\Generator\LockGenerator;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @package App\Controller
 * @Route("/lock")
 */
class LockController
{
    private $lockGenerator;
    private $allowedTypes = ['composer', 'yarn', 'all'];
    private $allowedRepository = ['akeneo/pim-community-dev', 'akeneo/pim-enterprise-dev'];

    public function __construct(LockGenerator $lockGenerator)
    {
        $this->lockGenerator = $lockGenerator;
    }

    /**
     * @Route("/lock")
     *
     * @return JsonResponse
     */
    public function lock(Request $request)
    {
        $userInput = explode(' ', $request->request->get('text'));

        $type = isset($userInput[0]) && '' !== $userInput[0] ? $userInput[0] : 'composer';

        if (!in_array($type, $this->allowedTypes)) {
            throw new \InvalidArgumentException('Type not allowed');
        }

        $repository = isset($userInput[1]) ? $userInput[1] : 'akeneo/pim-community-dev';

        if (!in_array($repository, $this->allowedRepository)) {
            throw new \InvalidArgumentException('Repository not allowed');
        }

        $response = $this->lockGenerator->generate($type, $repository);

        return new JsonResponse($response);
    }
}