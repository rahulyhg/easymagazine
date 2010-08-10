<?php include("sidebar.php");?>

<div id="content">

    <div class="post">

        <h2>
            <?= $this->article->getTitle(); ?>
        </h2>

        <div class="date"><small><?= $this->article->getCreatedFormatted() ?></small> by
            <?
            foreach ($this->article->users() as $user) {
                echo $user->getName().' ';
            }
            ?>
        </div>

        <div class="entry">

            <?= $this->article->getSummary() ?>

        </div>

        <h3>Comments</h3>

        <?
        if (isset($this->advice)) {
            echo '<b>'.$this->advice.'</b>';
        }
        ?>

        <? foreach($this->article->commentsPublished()  as $comment) { ?>

        <div class="date"><small><?= $comment->getCreatedFormatted() ?></small> by
                <?= $comment->getSignature() ?>
        </div>
        <div class="date"><small><?= Taghandler::tagsToLink($this->article->getTag()) ?></small>
        </div>

        <div class="entry">

                <?= $comment->getTitle() ?><br />

                <?= $comment->getBody() ?>

        </div>

        <? } ?>

        <? if ($this->article->getCommentsallowed() && $this->article->number()->getCommentsallowed()): ?>
        <p>
        <form name="newcomment" method="post" action="<?= URIMaker::comment($this->article) ?>">
            Title<br />
            <input type="text" name="Title" value="<?= $this->postedtitle ?>"/><br />
            Body<br />
            <textarea name="Body" rows="4" cols="40"><?= $this->postedbody ?></textarea><br />
            Signature<br />
            <input type="text" name="Signature" value="<?= $this->postedsignature ?>"/><br /><br />
            <!-- pass a session id to the query string of the script to prevent ie caching -->
            <img src="<?= URIMaker::fromBasePath('lib/securimage/securimage_show.php?sid='.md5(uniqid(time())))?>"><br />
            <input type="text" name="code" /><br /><br />
            <input type="submit" value="Ok" name="Ok" />
        </form>
        </p>
        <? endif; ?>
    </div>