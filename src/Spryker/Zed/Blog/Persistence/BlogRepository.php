<?php
/**
 * Copyright © 2017-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\Blog\Persistence;

use Generated\Shared\Transfer\BlogCommentTransfer;
use Generated\Shared\Transfer\BlogCriteriaFilterTransfer;
use Generated\Shared\Transfer\BlogTransfer;
use Generated\Shared\Transfer\CriteriaTransfer;
use Generated\Shared\Transfer\FilterTransfer;
use Orm\Zed\Blog\Persistence\Map\SpyBlogCommentTableMap;
use Orm\Zed\Blog\Persistence\Map\SpyBlogTableMap;
use Orm\Zed\Blog\Persistence\SpyBlog;
use Orm\Zed\Blog\Persistence\SpyBlogComment;
use Orm\Zed\Blog\Persistence\SpyBlogQuery;
use Orm\Zed\Customer\Persistence\SpyCustomerQuery;
use Propel\Runtime\Formatter\ArrayFormatter;
use Spryker\Zed\Kernel\Persistence\Repository\TransferObjectFormatter;
use Spryker\Zed\PropelOrm\Business\Runtime\ActiveQuery\Criteria;
use Spryker\Zed\Kernel\Persistence\AbstractRepository;

/**
 * @method \Spryker\Zed\Blog\Persistence\BlogPersistenceFactory getFactory()
 */
class BlogRepository extends AbstractRepository implements BlogRepositoryInterface
{
    /**
     * @param \Generated\Shared\Transfer\BlogCriteriaFilterTransfer $blogCriteriaFilterTransfer
     *
     * @return \Generated\Shared\Transfer\SpyBlogEntityTransfer[]
     */
    public function filterBlogPosts(BlogCriteriaFilterTransfer $blogCriteriaFilterTransfer)
    {
        $blogQuery = $this->getFactory()
            ->createBlogQuery();

        if ($blogCriteriaFilterTransfer->getName()) {
            $blogQuery->filterByName($blogCriteriaFilterTransfer->getName(), Criteria::LIKE);
        }

        $collection = $this->buildQueryFromCriteria($blogQuery, $blogCriteriaFilterTransfer->getFilter())
            ->find();

        $comments = $this->populateCollectionWithRelation($collection, 'SpyBlogComment');
        $this->populateCollectionWithRelation($comments, 'SpyBlogCustomer');

        return $collection;
    }

    /**
     * @api
     *
     * @dependency Customer, Product, Store should be included in composer.json
     *
     * @param string $blogName
     * @param \Generated\Shared\Transfer\FilterTransfer $filterTransfer
     *
     * @return \Generated\Shared\Transfer\SpyBlogEntityTransfer[]
     */
    public function findBlogCollectionByFirstName($blogName, FilterTransfer $filterTransfer = null)
    {
        $customerQuery = $this->queryBlogByName($blogName)
            ->joinWithSpyBlogComment()
            ->useSpyBlogCommentQuery()
               ->joinWithSpyBlogCustomer()
            ->endUse();

        return $this->buildQueryFromCriteria($customerQuery, $filterTransfer)->find();
    }

    /**
     * @param string $blogName
     *
     * @return \Generated\Shared\Transfer\SpyBlogEntityTransfer
     */
    public function findBlogByName($blogName)
    {
        $customerQuery = $this->queryBlogByName($blogName)
            ->joinWithSpyBlogComment();

        return $this->buildQueryFromCriteria($customerQuery)->find()[0];
    }

    /**
     * @param string $blogName
     *
     * @return int
     */
    public function countBlogByName($blogName)
    {
        $customerQuery = $this->queryBlogByName($blogName);

        return $this->buildQueryFromCriteria($customerQuery)->count();
    }

    /**
     * @param string $blogName
     *
     * @return \Generated\Shared\Transfer\SpyBlogEntityTransfer
     */
    public function findBlogByNameWithCommentCount($blogName)
    {
        $customerQuery = $this->queryBlogByName($blogName)
            ->joinSpyBlogComment()
            ->withColumn('COUNT(' . SpyBlogCommentTableMap::COL_ID_BLOG_COMMENT . ')', 'totalComments')
            ->groupBy(SpyBlogCommentTableMap::COL_ID_BLOG_COMMENT);

        return $this->buildQueryFromCriteria($customerQuery)->findOne();
    }

    /**
     * @param string $name
     *
     * @return \Orm\Zed\Blog\Persistence\SpyBlogQuery
     */
    protected function queryBlogByName($name)
    {
        return $this->getFactory()
            ->createBlogQuery()
            ->filterByName($name);
    }
}
