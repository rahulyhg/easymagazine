<?php

/*
    Copyright (C) 2009  Fabio Mattei

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

require_once(STARTPATH.DATAMODELPATH.'/article.php');
require_once(STARTPATH.DATAMODELPATH.'/page.php');

require_once('router.php');

class CommentsRouter extends Router {

    private $article;
    private $pages;
    private $numbers;

    function loadData(){
        $arURI = $this->getArrayURI();
        $this->article = Article::findById($arURI['id']);
        $this->numbers = Number::findAllPublishedOrderedByIndexNumber();
        $this->pages = Page::findAllPublished();
    }

    function applyTemplate(){
        $this->getRemote()->executeCommandBeforeComments();
        if (file_exists(TEMPLATEPATH.'/comments.php')) {
            include (TEMPLATEPATH.'/comments.php');

        } else if (file_exists(TEMPLATEPATH.'/index.php')) {
            include (TEMPLATEPATH.'/index.php');

        }
        $this->getRemote()->executeCommandAfterComments();
    }

}

?>
