<?php

namespace App\Controller;

use App\Generator\LockGenerator;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @package App\Controller
 * @Route("/lock/{repository}/{type}")
 */
class LockController
{
    private $lockGenerator;
    private $allowedTypes = ['composer', 'yarn', 'all'];
    private $allowedRepository = ['pim-community-dev', 'pim-enterprise-dev'];

    public function __construct(LockGenerator $lockGenerator)
    {
        $this->lockGenerator = $lockGenerator;
    }

    /**
     * @return JsonResponse
     */
    public function lock(Request $request, $repository, $type)
    {
        if (!in_array($type, $this->allowedTypes)) {
            throw new \InvalidArgumentException('Type not allowed');
        }

        if (!in_array($repository, $this->allowedRepository)) {
            throw new \InvalidArgumentException('Repository not allowed');
        }

        $response = $this->lockGenerator->generate($type, $repository);

        return new JsonResponse($response);
    }
}
