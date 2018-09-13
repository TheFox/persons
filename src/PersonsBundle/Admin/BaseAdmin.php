<?php

namespace TheFox\PersonsBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Route\RouteCollection;

class BaseAdmin extends AbstractAdmin
{
    protected $translationDomain = 'entity';

    /**
     * @var string
     */
    protected $translationName;

    /**
     * @var string
     */
    protected $translationEntityName;

    protected $maxPerPage = 25;

    protected $perPageOptions = [25, 50, 100, 500, 1000];

    public function configure()
    {
        $className = get_class($this);
        $items = preg_split('/\\\\/', $className);
        $name = array_pop($items);

        $this->translationName = strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $name));
        $this->translationEntityName = str_replace('_admin', '', $this->translationName);
    }

    protected function configureRoutes(RouteCollection $collection)
    {
        // Disable delete.
        $collection->remove('delete');
    }

    public function getExportFormats()
    {
        // Disable Export.
        return [];
    }
}
