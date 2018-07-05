<?php
//
//namespace App\Tests\Controller;
//
//use App\Controller\LockController;
//use App\Generator\LockGenerator;
//use PHPUnit\Framework\TestCase;
//use Symfony\Component\HttpFoundation\Request;
//use Symfony\Component\HttpFoundation\Response;
//use Symfony\Component\HttpFoundation\JsonResponse;
//
//class LockControllerTest extends TestCase
//{
//    public function testControllerInvalidArgumentException()
//    {
//        $lockGenerator = new LockGenerator();
//        $request = new Request();
//        $response = new Response();
//
//        $test = new LockController($lockGenerator);
//
//        $this->expectException('InvalidArgumentException');     //Il faudrait faire l'inverse pour que ca marche
//
//        $test->lock($request);
//
//    }
//
//    //$response = new Response();
//    //$this->assertSame(new JsonResponse($response), $test->lock($request));
//}