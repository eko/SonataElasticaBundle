<?php

/*
 * This file is part of the Sonata package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonata\ElasticaBundle\Tests\Datagrid;

use Sonata\ElasticaBundle\Datagrid\ProxyQuery;

/**
 * Class ProxyQueryTest
 *
 * Tests Elastica specific ProxyQuery
 *
 * @author Vincent Composieux <vincent.composieux@gmail.com>
 */
class ProxyQueryTest extends \PHPUnit_Framework_TestCase
{
    public function testExecute()
    {
        // Given
        $results = $this->getMockBuilder('FOS\ElasticaBundle\Paginator\TransformedPartialResults')
            ->disableOriginalConstructor()
            ->getMock();
        $results->expects($this->any())->method('toArray')->will($this->returnValue(array(1, 2)));

        $transformedPager = $this->getMockBuilder('FOS\ElasticaBundle\Paginator\TransformedPaginatorAdapter')
            ->disableOriginalConstructor()
            ->getMock();
        $transformedPager->expects($this->any())->method('getResults')->will($this->returnValue($results));

        $repository = $this->getMockBuilder('FOS\ElasticaBundle\Repository')
            ->disableOriginalConstructor()
            ->getMock();
        $repository->expects($this->once())->method('createPaginatorAdapter')->will($this->returnValue($transformedPager));

        $elasticaQuery = $this->getMockBuilder('Sonata\ElasticaBundle\Datagrid\QueryBuilder')
            ->disableOriginalConstructor()
            ->getMock();
        $elasticaQuery->expects($this->once())->method('getRepository')->will($this->returnValue($repository));

        $pager = $this->getMock('Sonata\DatagridBundle\Pager\PagerInterface');

        // When
        $proxyQuery = new ProxyQuery($elasticaQuery, $pager);

        $results = $proxyQuery->execute();

        // Then
        $this->assertEquals(array(1, 2), $results);
    }
}
