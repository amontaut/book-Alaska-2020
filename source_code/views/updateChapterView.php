<?php $title = "Modifier un chapitre - Billet simple pour l\'Alaska"; ?>

<?php ob_start(); ?>
<section id="title_page">
    <h2>Billet simple pour l'Alaska</h2>
    <h2>Modification du chapitre <?= $chapter['chapter_number'] ?></h2>
</section>

<section class="global_chapter">
    <div class="form_update_and_cancel">
        <form class="update_chap" action="index.php?action=UpdateChapter&amp;chapter_number=<?= $chapter['chapter_number'] ?>" method="post">
            <div class="infos_new_chap">
                <div>
                    <label for="title">Titre du chapitre : </label><br />
                    <input type="text" id="title" name="title" required value='<?= htmlspecialchars($chapter['title']) ?>' />
                </div>

            </div>
            <div>

                <textarea id="content_chap" name="content_chap"> <?= nl2br($chapter['content_chap']) ?>
              </textarea>
            </div>
            <div>
                <input class="valider_new_chap" value="Valider" type="submit" />
            </div>
        </form>
        <a href="index.php?action=acces_admin_page" class="cancel_update_chap">Annuler</a>
    </div>

</section>


<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>

<script src="https://cloud.tinymce.com/stable/tinymce.min.js?apiKey=***"></script>
<script src="global/tinymce.js"></script>

