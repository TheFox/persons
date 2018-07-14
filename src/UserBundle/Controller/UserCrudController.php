<?php

namespace TheFox\UserBundle\Controller;

use TheFox\UserBundle\Entity\User;
use Sonata\AdminBundle\Controller\CRUDController as BaseController;
use Sonata\AdminBundle\Datagrid\ProxyQueryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

class UserCrudController extends BaseController
{
    public function batchActionSetActive(ProxyQueryInterface $selectedModelQuery, Request $request = null)
    {
        /** @var User[] $selectedModels */
        $selectedModels = $selectedModelQuery->execute();

        $modelManager = $this->admin->getModelManager();
        foreach ($selectedModels as $user) {
            $user->setEnabled(true);
            $modelManager->update($user);
        }

        $response = new RedirectResponse(
            $this->admin->generateUrl('list', [
                'filter' => $this->admin->getFilterParameters(),
            ])
        );
        return $response;
    }

    public function batchActionSetInactive(ProxyQueryInterface $selectedModelQuery, Request $request = null)
    {
        /** @var User[] $selectedModels */
        $selectedModels = $selectedModelQuery->execute();

        $modelManager = $this->admin->getModelManager();
        foreach ($selectedModels as $ico) {
            $ico->setEnabled(false);
            $modelManager->update($ico);
        }

        $response = new RedirectResponse(
            $this->admin->generateUrl('list', [
                'filter' => $this->admin->getFilterParameters(),
            ])
        );
        return $response;
    }
}
