<?php $title = "Page administrateur - Moderer les commentaires"; ?>

<?php ob_start(); ?>

<section id="title_page">
    <h2>Billet simple pour l'Alaska</h2>
    <h2>Espace administrateur - Gérer les commentaires</h2>
    <h2> Chapitre <?= $chapter['chapter_number'] ?> : <?= htmlspecialchars($chapter['title']) ?> </h2>
</section>

<section class="infos_manage_chapter">
    <div class="nb_coms_categories">
        <p> Nombre de commentaires affichés :
            <?= $chapter['number_of_coms_OK'] ?> </p>
        <p> Commentaires en attente de modération :
            <?= $chapter['number_of_coms_WAIT'] ?> </p>
        <p> Commentaires signalés et supprimés :
            <?= $chapter['number_of_coms_DEL'] ?> </p>
    </div>
    <div class="all_comments">
        <?php while ($reported = $Reported->fetch()) { ?>
        <?php 
        if ($reported['status'] == 'WAIT'){ ?>
        <p class="coms_affiches WAIT bold ">Commentaire en attente : </p>
        <div class="contenu_each_com">
            <p> Par <?= htmlspecialchars($reported['author_com']) ?>, le <?= $reported['com_publi_date_fr'] ?> </p>

            <p><?= nl2br(htmlspecialchars($reported['content_com'])) ?></p>
        </div>
        <div class="action_com_reported">
            <a href="index.php?action=WAITToOK&amp;id=<?= $reported['id']?>&amp;chapter_number=<?= $chapter['chapter_number'] ?>" class="revalider_com">Revalider le commentaire </a>

            <a href="index.php?action=SuppCommentsAdmin&amp;id=<?= $reported['id']?>&amp;chapter_number=<?= $chapter['chapter_number'] ?> " class="supp_com">Supprimer le commentaire</a>
        </div>
        <?php ;
        } else if ($reported['status'] == 'DEL'){ ?>
        <p class="coms_affiches DEL bold">Commentaire supprimé : </p> <?php ; ?>
        <div class="contenu_each_com">
            <p> Par <?= htmlspecialchars($reported['author_com']) ?>, le <?= $reported['com_publi_date_fr'] ?> </p>

            <p><?= nl2br(htmlspecialchars($reported['content_com'])) ?></p>
        </div>
        <div class="action_com_reported">
            <a href="index.php?action=DELToOK&amp;id=<?= $reported['id']?>&amp;chapter_number=<?= $chapter['chapter_number'] ?> " class="revalider_com">Revalider le commentaire </a>
        </div>
        <?php ;
        } else if ($reported['status'] == 'OK') { ?>
        <p class="coms_affiches OK bold"> Commentaire affiché :</p>
        <div class="contenu_each_com">
            <p> Par <?= htmlspecialchars($reported['author_com']) ?>, le <?= $reported['com_publi_date_fr'] ?> </p>

            <p><?= nl2br(htmlspecialchars($reported['content_com'])) ?></p>
        </div>
        <div class="action_com_reported">
            <a href="index.php?action=SuppcommentsOK&amp;id=<?= $reported['id']?>&amp;chapter_number=<?= $chapter['chapter_number'] ?> " class="supp_com">Supprimer le commentaire</a>
        </div>
        <?php
        }
        ?>

        <?php
}
?>
    </div>

    <div class="display_chapter">
        <button> Afficher le contenu du chapitre</button>
        <div class="content_chapter_admin_page">
            <?= nl2br($chapter['content_chap']); ?>
        </div>
    </div>


</section>

<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>


