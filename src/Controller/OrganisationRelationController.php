<?php

namespace App\Controller;

use App\Repository\OrganisationRelationRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class OrganisationRelationController extends BaseController
{

    #[Route('/api/organisation-relations')]
    public function index(
        Request $request,
        OrganisationRelationRepository $organisationRelationRepository
    ): JsonResponse {
        $params = $request->query->all();

        return $this->json([
            'result' => [
                'items' => $organisationRelationRepository->listQuery($params),
                'count' => $organisationRelationRepository->listCountQuery($params),
            ]
        ],
            context: [
                'groups' => [
                    'id',
                    'organisation-list',
                    'organisation-relation-list',
                ]
            ]);
    }
}