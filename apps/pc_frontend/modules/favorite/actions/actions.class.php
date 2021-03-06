<?php

/**
 * This file is part of the OpenPNE package.
 * (c) OpenPNE Project (http://www.openpne.jp/)
 *
 * For the full copyright and license information, please view the LICENSE
 * file and the NOTICE file that were distributed with this source code.
 */

/**
 * favorite actions.
 *
 * @package    OpenPNE
 * @subpackage favorite
 * @author     Masato Nagasawa
 */
class favoriteActions extends opFavoritePluginFavoriteActions
{
 /**
  * Executes add action
  *
  * @param sfRequest $request A request object
  */
  public function executeAdd($request)
  {
    $this->idCheck();
    $favoriteTable = Doctrine::getTable('Favorite');
    if ($request->isMethod('post'))
    {
      if ($request->hasParameter('add'))
      {
        $favoriteTable->add($this->getUser()->getMemberId(), $this->id);
        $this->redirect('favorite/list');
      }
      $this->redirect('member/profile?id=' . $this->id);
    }
    $this->member = Doctrine::getTable('Member')->find($this->id);
    if ($favoriteTable->retrieveByMemberIdFromAndTo($this->getUser()->getMemberId(), $this->id))
    {
      return sfView::ALERT;
    }
  }

 /**
  * Executes diary action
  *
  * @param sfRequest $request A request object
  */
  public function executeDiary($request)
  {
    $this->pager = Doctrine::getTable('Favorite')->retrieveDiaryPager($this->getUser()->getMemberId(), $request->getParameter('page', 1));
    if (!$this->pager->getNbResults())
    {
      return sfView::ERROR;
    }
  }

 /**
  * Executes blog action
  *
  * @param sfRequest $request A request object
  */
  public function executeBlog($request)
  {
    $this->blogList = Doctrine::getTable('Favorite')->getBlogListOfFavorite($this->getUser()->getMemberId());
    if (!count($this->blogList))
    {
      return sfView::ALERT;
    }
  }
}
