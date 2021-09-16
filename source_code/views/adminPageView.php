<?php $title = "Page administrateur - Billet simple pour l\'Alaska"; ?>

<?php ob_start(); ?>

<section id="title_page">
    <h2>Billet simple pour l'Alaska</h2>
    <h2>Espace administrateur</h2>
</section>

<section class="content_admin_page">

    <a class="write_new_chap" href="index.php?action=DisplayNewChapterPage">Rediger un nouveau chapitre</a>

    <?php while ($data = $allchaptersdesc->fetch()) { ?>
    <div class="unique_chapter_admin_page">
        <div class="infos_chapter_admin_page">
            <p>Chapitre <?= $data['chapter_number'] ?> : <?=htmlspecialchars($data['title']) ?></p>
            <p>le <?= $data['chap_publi_date_fr'] ?></p>
        </div>
        <div class="nb_com_per_chap">
            <p>Nombre de commentaires affichés : <mark class="nb_coms_ok bold"><?= $data['number_of_coms_OK'] ?> commentaire<?php if ($data['number_of_coms_OK'] > 1){ echo 's'; }; ?></mark></p>
            <p>Nombre de commentaires en attente de modération : <mark class="nb_coms_wait bold"><?= $data['number_of_coms_WAIT'] ?> commentaire<?php if ($data['number_of_coms_OK'] > 1){ echo 's'; }; ?></mark></p>
            <p>Nombre de commentaires supprimés : <mark class="nb_coms_del bold"><?= $data['number_of_coms_DEL'] ?> commentaire<?php if ($data['number_of_coms_OK'] > 1){ echo 's'; }; ?></mark></p>
            <p>Total des commentaires : <mark class="nb_coms_tot bold"><?= $data['number_of_coms_DEL']+$data['number_of_coms_WAIT']+$data['number_of_coms_OK'] ?> commentaire<?php if ($data['number_of_coms_OK'] > 1){ echo 's'; }; ?></mark></p>
        </div>

        <div class="actions_chapitre">
            <a href="index.php?action=manageComs&amp;chapter_number=<?= $data['chapter_number']?> ">Gerer les commentaires</a>
            
            <a href="index.php?action=displayUpdatePage&amp;chapter_number=<?= $data['chapter_number']?>">Modifier le chapitre</a>
            
            <a href="index.php?action=Suppchapter&amp;chapter_number=<?= $data['chapter_number']?> ">Supprimer le chapitre</a>
        </div>

        <div class="display_chapter">
            <button> Afficher le contenu du chapitre</button>
            <div class="content_chapter_admin_page">
              <?= nl2br($data['content_chap']) ?>
          </div>
        </div>
    </div>
    <?php
    } 
    ?>

    <div class="pages_buttons">
        <?php 
        while ($displaycount = $countnbchap->fetch()){
            $nb_chapters = $displaycount['Compteur'];
        }

        $page = (!empty($_GET['page']) ? $_GET['page'] : 1);
        $limite = 5;

        $nombreDePages = ceil($nb_chapters / $limite);
        /* Si on est sur la première page, on n'a pas besoin d'afficher de lien
         * vers la précédente. On va donc l'afficher que si on est sur une autre
         * page que la première */
        if ($page > 1):
        ?><a href="index.php?action=acces_admin_page&page=<?php echo $page - 1; ?>">Page précédente</a> — <?php
        endif;

        /* On va effectuer une boucle autant de fois que l'on a de pages */

            //http://localhost:8888/P4V19/index.php?action=acces_admin_page&page=3

        for ($i = 1; $i <= $nombreDePages; $i++):
        ?><a href="index.php?action=acces_admin_page&page=<?php echo $i; ?>"><?php echo $i; ?></a> <?php
        endfor;

        /* Avec le nombre total de pages, on peut aussi masquer le lien
         * vers la page suivante quand on est sur la dernière */
        if ($page < $nombreDePages):
        ?>— <a href="index.php?action=acces_admin_page&page=<?php echo $page + 1; ?>">Page suivante</a><?php
        endif;
        ?>
    </div>

</section>

<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>



