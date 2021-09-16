<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title><?= $title ?></title>
    <link rel="stylesheet" type="text/css" href="global/bookAlaska.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="alicemntt">
    <meta name="description" content="Livre 'Billet simple pour l'Alaska'">
    <meta name="keywords" content="livre, alaska, jean forteroche, openclassrooms, projet4, php, mysql">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="https://billetsimplepourlAlaska.alicemta.com">

    <link rel="shortcut icon" href="global/images/favicon.ico" type="image/x-icon">

    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>



    <!-- fonts-->
    <link href="https://fonts.googleapis.com/css2?family=Manrope&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Amatic+SC&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat+Subrayada&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@300&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Unica+One&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Julius+Sans+One&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Six+Caps&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Didact+Gothic&display=swap" rel="stylesheet">

    <script src="https://kit.fontawesome.com/f3421f1a5c.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
    <header>
        <div class="menu_burger">
            <hr class="bar">
            <hr class="bar">
            <hr class="bar">
        </div>

        <div class="close_menu_burger">
            <i class="fas fa-times"></i>
        </div>

        <div class="menu_classique">
            <?php 
if ($_SESSION['admin'] == 'OFFLINE'){?>
            <a href="index.php"><i class="fas fa-home"></i></a>
            <?php
} ?>

            <a href="index.php?action=DisplayHomeViewCo" class="homeco"><i class="fas fa-home"></i></a>

            <a href="index.php?action=listAllChapters">Tous les chapitres</a>

            <a class="acces_admin_page" href='index.php?action=acces_admin_page'>Espace administrateur</a>

            <?php 
if ($_SESSION['admin'] == 'OFFLINE'){?>
            <a class="display_block" href="#get_long_in">Connexion</a>
            <?php
} ?>

            <a href="#figure_change_pwd" class="button_change_pwd">Changer de mot de passe </a>

            <div class="lightbox" id="figure_change_pwd">
                <figure>
                    <a href="#" class="closemsg"></a>
                    <figcaption>
                        <form class="change_pwd" action="index.php?action=new_pwd" method=post>
                            <div>
                                <label for="new_pwd">Nouveau mot de passe : </label>
                                <input type="password" id="new_pwd" name="new_pwd" required>
                            </div>

                            <div>
                                <label for="confirm_new_pwd">Confirmation du mot de passe : </label>
                                <input type="password" id="confirm_new_pwd" name="confirm_new_pwd" required>
                            </div>

                            <p class="check_new_pwd">Les mots de passe ne sont pas identiques</p>

                            <input type="submit" value="Changer de mot de passe" class="submit_change_pwd">

                        </form>
                    </figcaption>
                </figure>

            </div>

            <a class="button_deconnexion" href='index.php?action=getlogOut'>Déconnexion</a>
        </div>
    </header>

    <?= $content ?>


    <div class="lightbox2" id="get_long_in">
        <figure>
            <a href="#" class="closemsg"></a>
            <figcaption>
                <div class='login_area'>
                    <form action="index.php?action=getlogIn" method="post">
                        <label for="username">Nom d'Utilisateur : </label><br>
                        <input type="text" id="username" name="username" required><br>

                        <label for="pwd">Mot de passe :</label><br>
                        <input type="password" id="pwd" name="pwd" required><br>
                        <input type="submit" value="Connexion" class="co">
                    </form>

                    <br>
                    <button class="button_mdp_oublie">Mot de passe oublié </button>
                    <br>
                    <form action="index.php?action=forgottenPWD" method="post" class="form_forgot_pwd">
                        <label for="confirm_email">Adresse email :</label>
                        <input type="email" id="confirm_email" name="confirm_email" required>
                        <br>
                        <input type="submit" value="Valider" class="submit_pwd_forgotten">
                    </form>
                </div>
            </figcaption>
        </figure>

    </div>

    <footer>
        <p> <a href="index.php?action=DisplayMentionsLeg">Mentions légales</a> - © Jean Forteroche </p>
    </footer>

    <?php 
    if (isset($_SESSION['admin']) && $_SESSION['admin'] == 'ONLINE'){?>
    <!-- JQuery -->
    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js'></script>
    <script src="global/connexion.js"></script>
    <script>
        let global2 = new Global2();
        global2.login();

    </script>
    <?php
    } ?>




    <script src="global/bookAlaska.js"></script>
</body>

</html>
