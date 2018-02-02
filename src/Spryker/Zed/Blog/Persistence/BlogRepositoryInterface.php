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

interface BlogRepositoryInterface
{
    /**
     * @param \Generated\Shared\Transfer\BlogCriteriaFilterTransfer $blogCriteriaFilterTransfer
     *
     * @return \Generated\Shared\Transfer\SpyBlogEntityTransfer[]
     */
    public function filterBlogPosts(BlogCriteriaFilterTransfer $blogCriteriaFilterTransfer);

    /**
     * @param string $blogName
     *
     * @param \Generated\Shared\Transfer\CriteriaTransfer $criteriaTransfer
     *
     * @return \Generated\Shared\Transfer\SpyBlogEntityTransfer[]
     */
    public function findBlogCollectionByFirstName($blogName, CriteriaTransfer $criteriaTransfer = null);

    /**
     * @param string $blogName
     *
     * @return \Generated\Shared\Transfer\SpyBlogEntityTransfer
     */
    public function findBlogByName($blogName);

    /**
     * @param string $blogName
     *
     * @return int
     */
    public function countBlogByName($blogName);

    /**
     * @param string $blogName
     *
     * @return int
     */
    public function findBlogByNameWithCommentCount($blogName);
}
