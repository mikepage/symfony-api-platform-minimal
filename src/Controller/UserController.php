<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends BaseController
{

    #[Route('/api/users', name: 'app_user_index')]
    public function index(Request $request, UserRepository $userRepository): JsonResponse
    {
        $params = $request->query->all();

        return $this->json([
            'result' => [
                'items' => $userRepository->listQuery($params),
                'count' => $userRepository->listCountQuery($params),
            ]
        ],
            context: [
                'groups' => [
                    'organisation-list',
                    'organisation-relation-list',
                    'user-list',
                ]
            ]);
    }
}
