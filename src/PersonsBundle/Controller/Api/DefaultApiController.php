<?php

namespace TheFox\PersonsBundle\Controller\Api;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Swagger\Annotations as SWG;

class DefaultApiController extends BaseApiController
{
    /**
     * Internal Test
     *
     * @SWG\Tag(name="Test")
     * @SWG\Response(response=200, description="OK")
     * @SWG\Parameter(name="test", in="query", type="string", description="Test field.")
     * @param Request $request
     * @return JsonResponse
     */
    public function testAction(Request $request)
    {
        $appName = $this->getParameter('app_name');
        $appVersion = $this->getParameter('app_version');

        $data = [
            'app_name' => $appName,
            'app_version' => $appVersion,
            // 'format' => $request->getRequestFormat(),
            // 'php_version' => phpversion(),
        ];

        return new JsonResponse($data);
    }
}
