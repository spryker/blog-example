<?php
/**
 * Copyright © 2017-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\Blog\Persistence;

use Orm\Zed\Blog\Persistence\SpyBlogCommentQuery;
use Orm\Zed\Blog\Persistence\SpyBlogCustomerQuery;
use Orm\Zed\Blog\Persistence\SpyBlogQuery;
use Spryker\Zed\Kernel\Persistence\AbstractPersistenceFactory;
use Spryker\Zed\Blog\BlogDependencyProvider;

class BlogPersistenceFactory extends AbstractPersistenceFactory
{
    /**
     * @return \Orm\Zed\Blog\Persistence\SpyBlogQuery
     */
    public function createBlogQuery()
    {
        return SpyBlogQuery::create();
    }

    /**
     * @return \Orm\Zed\Blog\Persistence\SpyBlogCommentQuery
     */
    public function createBlogCommentQuery()
    {
        return SpyBlogCommentQuery::create();
    }

    /**
     * @return \Orm\Zed\Blog\Persistence\SpyBlogCustomerQuery
     */
    public function createBlogCustomerQuery()
    {
        return SpyBlogCustomerQuery::create();
    }

}
