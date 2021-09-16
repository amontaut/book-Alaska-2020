<?php $title = "Lecture d'un chapitre- Billet simple pour l'Alaska"; ?>

<?php ob_start(); ?>

<section id="title_page">
    <h2>Billet simple pour l'Alaska</h2>
    <h2>Chapitre <?= $chapter['chapter_number'] ?> : <?= htmlspecialchars($chapter['title']) ?></h2>
    <h2><?= $chapter['number_of_coms_OK'] ?> commentaire<?php if ($chapter['number_of_coms_OK'] > 1){ echo 's'; }; ?></h2>
</section>

<section id="chapter">
    <div class="global_chapter">
        <div class="display_list_chapters content_one_chapter">
            <p class="txt_one_chapter"> <?= nl2br($chapter['content_chap']) ?></p>
            <p class="info_txt_one_chapter"> le <?= $chapter['chap_publi_date_fr'] ?></p>
        </div>

    </div>
    <div class="comments_part">
        <p class="title_comments_part">Commentaires :</p>

        <p class="subtitle_comment">Laisser un commentaire :</p>
        <hr>
        <form class="form_comment" action="index.php?action=addComment&amp;chapter_number=<?= $chapter['chapter_number'] ?>" method="post">
            <div>
                <label for="author_com">Auteur</label><br />
                <input type="text" id="author_com" name="author_com" required />
            </div>
            <div>
                <label for="content_com">Commentaire</label><br />
                <textarea id="content_com" name="content_com" required></textarea>
            </div>
            <input class="submit_form_leave_com" type="submit" />
        </form>

        <p class="subtitle_comment">Les derniers commentaires : </p>
        <hr>
        <div class="coms_posted_and_OK display_list_chapters">
            <?php if ($chapter['number_of_coms_OK'] > 0){
                while ($comment = $GetComsOK->fetch()) { ?>

                <p class="author_comment_posted bold">
                    Par <?= htmlspecialchars($comment['author_com']) ?>, le <?= $comment['com_publi_date_fr'] ?> :
                </p>
                <div class="content_comment_posted">
                    <p>
                        <?= nl2br(htmlspecialchars($comment['content_com'])) ?>
                    </p>

                    <a href="index.php?action=IsReported&amp;id=<?= $comment['id']?>&amp;chapter_number=<?= $chapter['chapter_number'] ?>">Signaler ce commentaire</a>

                    <!--<a href="index.php?action=addComment2&amp;chapter_number=<?= $chapter['chapter_number'] ?>">Signaler ce commentaire2</a>-->

                </div>

                <?php
            }
        } else { ?>
    <p class="no_comment">Il n'y a pas encore de commentaire</p>
<?php }
        ?>
        </div>

    </div>
</section>

<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>


