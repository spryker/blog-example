<?php
/**
 * Copyright © 2017-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\Blog;

use Orm\Zed\Customer\Persistence\SpyCustomerQuery;
use Spryker\Zed\Kernel\AbstractBundleDependencyProvider;
use Spryker\Zed\Kernel\Container;

class BlogDependencyProvider extends AbstractBundleDependencyProvider
{
    const PROPEL_QUERY_CUSTOMER = 'propel query customer';

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function providePersistenceLayerDependencies(Container $container)
    {
        //document use of propel query object between modules. Use cases.
        $container[static::PROPEL_QUERY_CUSTOMER] = function (Container $container) {
            return SpyCustomerQuery::create();
        };

        return $container;
    }

}
