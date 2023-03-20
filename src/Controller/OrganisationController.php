<?php

namespace App\Controller;

use App\Repository\OrganisationRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class OrganisationController extends BaseController
{

    #[Route('/api/organisations', name: 'app_organisation_index')]
    public function index(Request $request, OrganisationRepository $organisationRepository): JsonResponse
    {
        $params = $request->query->all();

        return $this->json([
            'result' => [
                'items' => $organisationRepository->listQuery($params),
                'count' => $organisationRepository->listCountQuery($params),
            ]
        ],
            context: [
                'groups' => [
                    'organisation-list',
                ]
            ]);
    }
}
