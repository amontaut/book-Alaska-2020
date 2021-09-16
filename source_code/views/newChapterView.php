<?php $title = "Ajouter un chapitre - Billet simple pour l\'Alaska"; ?>

<?php ob_start(); ?>
<section id="title_page">
    <h2>Billet simple pour l'Alaska</h2>
    <h2>Créer un nouveau chapitre</h2>
</section>

<section class="global_chapter">
    <form class="new_chap" action="index.php?action=addChapter" method="post">
        <div class="infos_new_chap">
            <div>
                <label for="chapter_number">Numéro du chapitre : </label><br />
                <input type="number" id="chapter_number" name="chapter_number" min=1 step=1 required />
            </div>
            <div>
                <label for="title">Titre du chapitre : </label><br />
                <input type="text" id="title" name="title" required />
            </div>

        </div>
        <div>

            <textarea id="content_chap" name="content_chap">  </textarea>
        </div>
        <div>
            <input class="valider_new_chap" value="Valider" type="submit" />
        </div>
    </form>
</section>


<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>

<script src="https://cloud.tinymce.com/stable/tinymce.min.js?apiKey=***"></script>
<script src="global/tinymce.js"></script>



