<?php $title = "Accès refusé - Billet simple pour l\'Alaska"; ?>

<?php ob_start(); ?>

<div class="acces_denied_body">
    <i class="far fa-times-circle"></i>
    <p>Vous n'avez pas accès à cette page</p>
    <a href="index.php">Retourner à la page d'accueil</a>
</div>

<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>


