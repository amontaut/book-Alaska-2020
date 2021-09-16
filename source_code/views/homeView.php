<?php $title = "Accueil - Billet simple pour l'Alaska"; ?>

<?php ob_start(); ?>

<section id="title_home">
    <div class="all_txt_home">
        <h1 class="txt_titre_home">
           BILLET&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;SIMPLE
            <br>
           <em class='em_homeView' >pour</em>
          l'ALASKA
        </h1>
        <div class="global_down_arrow">
            <button class="down_arrow">&darr;</button>
        </div>
    </div>
</section>

<section id="concept">
    <h1 class="title_concept">Concept </h1>
    <p class="txt_concept">
        J'ai voulu créer un livre inédit et unique. Mais comment faire alors que des millers, des millions de livres ont déjà étés écrits ? S'adapter, toujours s'adapter ...
        <br>
        <br>
        Alors voilà, j'ai eu l'idée de faire quelque chose d'innovant et dans l'ère du temps. Un livre numérique, publié sur internet. Dans le même esprit que les séries TV, un nouveau chapitre est publié chaque semaine. Suivez les aventures du protagoniste chapitre après chapitre, semaine après semaine et réagissez !
        <br>
        <br>
        Vous pouvez en effet interragir avec les mois et les autres lecteurs en laissant des commentaires sous chaque chapitres. Veuillez bien-sûr à garder un langage correct pendant vos échanges. Sinon un autre utilisateur pourra signaler le commentaire et je pourrai le supprimer si nécéssaire.
        <br> <br>
        J'espère que ce nouveau format vous plaira !
        <br> <br>
        Très bonne lecture à tous ...
        <br> <br>
        JF
</section>

<section id="lasts_chapters">
    <h1 class="title_lasts_chapters">Les 3 derniers chapitres de mon roman :</h1>

    <div class="display_lasts_chapters">
        <?php while ($data = $lastschapters->fetch()) { ?>
        <div class="unique_chapter">
            <div class="infos_chapter">
                <p>Chapitre <?= $data['chapter_number'] ?> :
                    <?=htmlspecialchars($data['title']) ?></p>
                <p> le <?= $data['chap_publi_date_fr'] ?>
                    <br>
                    <?= $data['number_of_coms_OK'] ?> commentaire<?php if ($data['number_of_coms_OK'] > 1) { echo 's'; }?>
                </p>
            </div>
            <div class="content_chapter">
                <div>
                    <?php
                echo substr(nl2br($data['content_chap']), 0, 600);
                ?>
                    ...
                </div>
            </div>
            <br>
            <a class="read_more_lasts_chapters" href="index.php?action=chapter&amp;chapter_number=<?= $data['chapter_number']?> ">Lire la suite</a>
            <br>
        </div>

        <?php
        }
        $lastschapters->closeCursor();
        ?>
    </div>
    <a href="index.php?action=listAllChapters" class="see_all_chapters">Voir tous les chapitres</a>
</section>


<section id="aboutJF">
    <h1 class="title_aboutJF">A propos de l<em>'</em>auteur </h1>
    <div class="img_and_txt_about_JF">
        <div class="portrait_JF">
            <div class="global_img_JF">
                <img src="global/images/portrait.jpg" alt="portrait de Jean Forteroche">
            </div>
        </div>
        <div class="txt_about_JF">
            <p>
                Jean Forteroche est né à Nantes le 12 juin 1982. A 19 ans, il publie son premier roman "Le feu qui venait du ciel". Il n'a cessé d'écrire depuis.
                <br>
                Auteur inspiré par la nature qui l'entoure, mais aussi par les avancées scientifiques du 18ème siècle, Jean Forteroche a une identité littéraire bien marquée.
            </p>
        </div>
    </div>
</section>


<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>