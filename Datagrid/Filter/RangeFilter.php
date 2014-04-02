<?php

/*
 * This file is part of the Sonata package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonata\ElasticaBundle\Datagrid\Filter;

use Sonata\DatagridBundle\Filter\BaseFilter;
use Sonata\DatagridBundle\ProxyQuery\ProxyQueryInterface;

class RangeFilter extends BaseFilter
{
    /**
     * {@inheritdoc}
     */
    public function apply($queryBuilder, $value)
    {
        $this->filter($queryBuilder, null, null, null);
    }

    /**
     * {@inheritdoc}
     */
    public function filter(ProxyQueryInterface $queryBuilder, $alias, $field, $data)
    {
        $queryBuilder->getQuery()->setFilter(new \Elastica\Filter\Range($this->getFieldName(),
            array(
                'gt' => $this->getOption('min'),
                'lt' => $this->getOption('max')
            )
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getDefaultOptions()
    {
        return array(
            'field_name' => null,
            'min'        => null,
            'max'        => null,
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getRenderSettings()
    {
        return array('sonata_type_filter_choice', array(
            'field_type'    => $this->getFieldType(),
            'field_options' => $this->getFieldOptions(),
            'label'         => $this->getLabel()
        ));
    }
}
