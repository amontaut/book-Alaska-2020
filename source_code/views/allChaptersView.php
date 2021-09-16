<?php $title = "Tous les chapitres - Billet simple pour l\'Alaska"; ?>

<?php ob_start(); ?>

<section id="title_page">
    <h2>Billet simple pour l'Alaska </h2>
    <h2> Tous les chapitres : </h2>
</section>

<section class="list_chapters">
    <!-- div surtout utile pour le background img-->
    <div class="display_list_chapters borders">
        <?php while ($data = $allchapters->fetch()) {
        ?>
        <div class="one_chapter_only">
            <p class="title_chapter_only">
                Chapitre <?= $data['chapter_number'] ?> :
                <?=htmlspecialchars($data['title']) ?>
            </p>
            <p class='infos_compl_chapter_only'>
                Par <?= $data['author_chap'] ?>
                le <?= $data['chap_publi_date_fr'] ?>
                <br>
                <?= $data['number_of_coms_OK'] ?> commentaire<?php if ($data['number_of_coms_OK'] > 1){ echo 's'; }; ?>
            </p>
		
        <div class="content_one_chapter">
            <p>
                <?php echo substr(nl2br($data['content_chap']), 0, 600);
                    ?>
                ...
            </p>
          </div>
            <a class="read_more" href="index.php?action=chapter&amp;chapter_number=<?= $data['chapter_number']?> ">Lire la suite</a>
        </div>
        <?php
        }
        ?>

    </div>
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
        ?><a id='page=1' href="index.php?action=listAllChapters&page=<?php echo $page - 1; ?>">Page précédente</a> — <?php
        endif;

        /* On va effectuer une boucle autant de fois que l'on a de pages */

            //http://localhost:8888/P4V19/index.php?action=acces_admin_page&page=3

        for ($i = 1; $i <= $nombreDePages; $i++):
        ?><a href="index.php?action=listAllChapters&page=<?php echo $i; ?>"><?php echo $i; ?></a> <?php
        endfor;

        /* Avec le nombre total de pages, on peut aussi masquer le lien
         * vers la page suivante quand on est sur la dernière */
        if ($page < $nombreDePages):
        ?>— <a href="index.php?action=listAllChapters&page=<?php echo $page + 1; ?>">Page suivante</a><?php
        endif;
        ?>
    </div>
</section>


<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>


