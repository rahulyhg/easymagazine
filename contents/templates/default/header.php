<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//<?= Magazine::getMagazineLanguage() ?>" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
    <head profile="http://gmpg.org/xfn/11">
        <title><?= $this->title?></title>
        <link rel="stylesheet" href="<?= URIMaker::templatePath('style.css') ?>" type="text/css" media="screen" />
        <meta name="keywords" content="<?= $this->metakeywords; ?>" />
        <meta name="description" content="<?= $this->metadescritpion; ?>" />
    </head>
    <body>
        <div ><a name='up' id='up'></a></div>
        <div id="wrapper">
            <div id="header">
                <ul id="nav">
                    <li class="page_item"><a href="<?= URIMaker::index() ?>">Home</a></li>
                    <li class="page_item"><a href="<?= URIMaker::people() ?>">People</a></li>
                    <li class="page_item"><a href="<?= URIMaker::numberslist() ?>">Numbers</a></li>
                    <?
                    foreach ($this->pages as $page) {
                        echo '<li class="page_item"><a href="'.URIMaker::page($page).'">'.$page->getTitle().'</a></li>';
                    }
                    ?>
                </ul>
                <p class="description">
                    <?= Magazine::getMagazineDescription() ?>
                </p>
                <h1><a href="<?= URIMaker::index() ?>"><?= Magazine::getMagazineTitle() ?></a></h1>
            </div>