<?php

// Chargement des modèles
require_once('models/ChapterManager.php');
require_once('models/CommentManager.php');
require_once('models/UsersManager.php');

class Controller {

//
//          FRONT    ////
//

//Affiche les 3 derniers chapitres sur la page d'accueil
function listLastsChapters() {
    $chaptersManager = new PostChapter(); 
    $lastschapters = $chaptersManager->getLastsChapters();
    require('views/homeView.php');
}

//Affiche tous les chapitres sur la page tous les chapitres
function listAllChapters() {
    $chaptersManager = new PostChapter(); 
    $allchapters = $chaptersManager->getallChapters(); 
    $countnbchap = $chaptersManager -> count_nb_chap();
    require('views/allChaptersView.php');
}

//Affiche 1 chapitre sur la page d'1 chap et ses coms associés
function chapter() {
    $chaptersManager = new PostChapter();
    $commentManager = new CommentManager();
    //Affiche les infos contenues dans le chap
    $chapter = $chaptersManager->getChapter($_GET['chapter_number']);
    //Affiche les coms
    $GetComsOK = $commentManager->getComments($_GET['chapter_number']);
    require('views/chapterView.php');
}

//Permet d'ajouter un com sur la page d'1 chapitre
function addComment($chapterId, $author, $comment) { 
    $commentManager = new CommentManager();
    $chaptersManager = new PostChapter();
    //Recup le n° du chapitre
    $chapter = $chaptersManager->getChapter($_GET['chapter_number']);
    //Recupère les infos
    $affectedLines = $commentManager->postComment($chapterId, $author, $comment);
    //Vérification
    if ($affectedLines === false) {
        throw new Exception('Impossible d\'ajouter le commentaire !');
    }
    else { //Si OK alors :
        $number_of_coms_OK = $chapter['number_of_coms_OK'] + 1; //+1 dans le compte des coms
        $newnbcomments = $chaptersManager->MAJnbcomments($chapterId, $number_of_coms_OK); //modif de la BDD avec le +1
        //Affichage le com sur la page et nous remet a la page du chapitre
        $Page  = 'index.php?action=chapter&chapter_number=' . $chapterId;
        $Time = 1;
    ?>
<script type="text/javascript">
    window.setTimeout("location=('<?php echo $Page; ?>');", <?php echo $Time; ?>);

</script>
<?php
    }
}

//Quand un utilisateur signaler un commentaire :
function IsReported($chapterId2) {
    $commentManager = new CommentManager();
    //Le status du commentaire passe en WAIT
    $isreported = $commentManager->ToWAIT($_GET['id']);    
    $chaptersManager = new PostChapter();
    //Recup du n° du chapitre
    $chapter = $chaptersManager->getChapter($_GET['chapter_number']);
    // -1 dans le nombre de coms OK
    $number_of_coms_OK = $chapter['number_of_coms_OK'] - 1;
    // +1 dans le nombre de coms en attente (WAIT)
    $number_of_coms_WAIT = $chapter['number_of_coms_WAIT'] + 1;
    //modif dans la BDD
    $majnbcommentsOKtoWAIT = $chaptersManager->MAJnbcommentsOKtoWAIT($chapterId2, $number_of_coms_OK, $number_of_coms_WAIT);
    //Affichage la page du chapitre
    $Page  = 'index.php?action=chapter&chapter_number=' . $chapterId2;
    $Time = 1;
   ?>
<script type="text/javascript">
    window.setTimeout("location=('<?php echo $Page; ?>');", <?php echo $Time; ?>);

</script>

<?php
}       
    
    
//
//          BACK    ////
//
    
    
//Quand l'admin ajoute un chapitre
function addChapter($nbcoms, $title, $content)
{
    $chaptersManager = new PostChapter();
    //Recupère les infos
    $newLines = $chaptersManager->postChapters($nbcoms, $title, $content);
    //Vérification
    if ($newLines === false) {
        throw new Exception('Impossible d\'ajouter le chapitre !');
    }
    else {
        //Affichage la page admin
        $Page  = 'index.php?action=acces_admin_page';
        $Time = 1;
   ?>
<script type="text/javascript">
    window.setTimeout("location=('<?php echo $Page; ?>');", <?php echo $Time; ?>);

</script>

<?php
    }
}
    
//pour afficher la page de modification d'un chapitre
function displayUpdatePage () {
    $chaptersManager = new PostChapter();
    //Affiche le chap
    $chapter = $chaptersManager->getChapter($_GET['chapter_number']);
   
    require('views/updateChapterView.php');
}
    
//pour valider la modification d'un chapitre
function UpdateChapter ($chapter_number) {
    $chaptersManager = new PostChapter();
    $chapter = $chaptersManager->getChapter($_GET['chapter_number']);
    //recuperation des infos
    $title = $_POST['title'];
    $content_chap = $_POST['content_chap'];
    $content_chap = $chaptersManager -> MAJChapter($chapter_number, $title, $content_chap);
    //Affichage de la page  admin 
    $Page  = 'index.php?action=acces_admin_page';
    $Time = 1;
   ?>
<script type="text/javascript">
    window.setTimeout("location=('<?php echo $Page; ?>');", <?php echo $Time; ?>);

</script>

<?php
    
}        
        
    
//Si l'admin 'supprime' un commentaire signalé :
function SuppCommentsAdmin($chapterId4) {
    $commentManager = new CommentManager();
    //Le status du commentaire passe en DEL comme deleted
    $suppcommentsadmin = $commentManager->ToDEL($_GET['id']);    
    $chaptersManager = new PostChapter();
    //Recup du n° du chapitre
    $chapter = $chaptersManager->getChapter($_GET['chapter_number']);
    // -1 dans le nombre de coms en attente WAIT
    $number_of_coms_WAIT = $chapter['number_of_coms_WAIT'] - 1;
    // +1 dans le nombre de coms DEL
    $number_of_coms_DEL = $chapter['number_of_coms_DEL'] + 1;
    //modif dans la BDD
    $majnbcommentsWAITtoDEL = $chaptersManager->MAJnbcommentsWAITtoDEL($chapterId4, $number_of_coms_WAIT, $number_of_coms_DEL);
    //Affichage la page du chapitre concerné coté admin
    $Page  = 'index.php?action=manageComs&chapter_number=' . $chapterId4;
    $Time = 1;
   ?>
<script type="text/javascript">
    window.setTimeout("location=('<?php echo $Page; ?>');", <?php echo $Time; ?>);

</script>

<?php
}
    
//Quand l'admin 'supprime' un commentaire OK 
function SuppcommentsOK($chapterIdOKK) {
    $commentManager = new CommentManager();
    //Le status du commentaire passe en DEL comme deleted
    $suppcommentsOK = $commentManager->DeleteComsOK($_GET['id']);
    $chaptersManager = new PostChapter();
    //Recup du n° du chapitre
    $chapter = $chaptersManager->getChapter($_GET['chapter_number']);
    // -1 dans le nombre de coms en attente WAIT
    $LEnumber_of_comsOK = $chapter['number_of_coms_OK'] - 1;
    // +1 dans le nombre de coms DEL
    $number_of_coms_DEL = $chapter['number_of_coms_DEL'] + 1;
    //modif dans la BDD
    $newnbcommentsOK = $chaptersManager->MAJnbcommentsOKtoSUP($chapterIdOKK, $LEnumber_of_comsOK, $number_of_coms_DEL);
    //Affichage la page du chapitre concerné coté admin
    $Page  = 'index.php?action=manageComs&chapter_number=' . $chapterIdOKK;
    $Time = 1;
   ?>
<script type="text/javascript">
    window.setTimeout("location=('<?php echo $Page; ?>');", <?php echo $Time; ?>);

</script>

<?php
}



//Changement de mdp
function new_pwd($new_pwd, $confirm_pwd) {
//    $new_pwd_secure = htmlspecialchars($_POST['new_pwd']);
//    $confirm_new_pwd_secure = htmlspecialchars($_POST['confirm_new_pwd']);
    
    if ($new_pwd == $confirm_pwd) {
        $password = hash('md5', $confirm_pwd);
        $usersManager = new UsersManager();
        $newpwd = $usersManager->change_pwd($password);
        $chaptersManager = new PostChapter();
        //Affichage de la page admin avec tous les chap
        $allchaptersdesc = $chaptersManager -> getAllChaptersDesc();
        $countnbchap = $chaptersManager -> count_nb_chap();
        require ('views/adminPageView.php'); ?>
<script>
    alert('Votre mot de passe a bien été changé.');

</script>
<?php
    } else { 
        $chaptersManager = new PostChapter();
        $allchaptersdesc = $chaptersManager -> getAllChaptersDesc();
        $countnbchap = $chaptersManager -> count_nb_chap();
        require ('views/adminPageView.php'); ?>
<script>
    alert('Les mots de passe sont différents.');

</script>
<?php 
    }
}
    
//Quand l'admin s'identifie
function getlogIn () {
    $usersManager = new UsersManager();
    $chaptersManager = new PostChapter();
    $commentManager = new CommentManager();
    $secure_pwd = htmlspecialchars($_POST['pwd']);
    $secure_username = htmlspecialchars($_POST['username']);
    $pass_hache = (hash('md5', $secure_pwd));
    $user = $usersManager -> logIn ();
    while ($AccesUser = $user->fetch()) {
        //Verif mdp et username
        if ($pass_hache == $AccesUser['password'] && $secure_username == $AccesUser['username']) {
            $chaptersManager = new PostChapter();
            //Affichage de la page admin avec tous les chap
            $allchaptersdesc = $chaptersManager -> getAllChaptersDesc();
            $_SESSION['admin'] = 'ONLINE';
            $countnbchap = $chaptersManager -> count_nb_chap();
            require ('views/adminPageView.php');
            
        } else { 
//Si mdp ou username incorrect?>
<script>
    alert('Le nom d\'utilisateur ou le mot de passe est invalide.');

</script>

<?php
            $chaptersManager = new PostChapter(); 
            $lastschapters = $chaptersManager->getLastsChapters();
            require('views/homeView.php');
        }
    }
    $user->closeCursor();
}

//pour acceder a la page admin
function acces_admin_page () {
    $chaptersManager = new PostChapter();
    //Affichage de la page admin avec tous les chap
    $allchaptersdesc = $chaptersManager -> getAllChaptersDesc();
    $countnbchap = $chaptersManager -> count_nb_chap();
    require ('views/adminPageView.php');
}

//Quand l'admin se deconnecte
function getlogOut () {
    $_SESSION['admin'] = 'OFFLINE';
    $chaptersManager = new PostChapter(); 
    $lastschapters = $chaptersManager->getLastsChapters();
    require ('views/homeView.php');
    $_SESSION['admin'] = 'OFFLINE';
}

//Suppression d'un chapitre si l'admin veut sup un chapitre
function Suppchapter(){
    $chaptersManager = new PostChapter();
    $deletechapter = $chaptersManager->DeleteChapter($_GET['chapter_number']);
    $chaptersManager = new PostChapter();
    //Affichage de la page admin avec tous les chap
    $allchaptersdesc = $chaptersManager -> getAllChaptersDesc();
    $countnbchap = $chaptersManager -> count_nb_chap();
    require ('views/adminPageView.php'); 
}
    
//Les commentaires concernés se suppriment aussi si l'admin sup un chapitre 
function Suppcomments() {
    $commentManager = new CommentManager();
    $suppcomments = $commentManager->DeleteComs($_GET['chapter_number']);
}
    
//Quand l'admin revalide un commentaire supprimé
function DELToOK($chapterId) {
    $commentManager = new CommentManager();
    //Le status du commentaire passe en WAIT
    $deltook = $commentManager->Revalide($_GET['id']);    
    $chaptersManager = new PostChapter();
    //Recup du n° du chapitre
    $chapter = $chaptersManager->getChapter($_GET['chapter_number']);
    // -1 dans le nombre de coms DEL
    $number_of_coms_DEL = $chapter['number_of_coms_DEL'] - 1;
    // +1 dans le nombre de OK
    $number_of_coms_OK = $chapter['number_of_coms_OK'] + 1;
    //modif dans la BDD
    $majnbcommentsSUPtoOK = $chaptersManager->MAJnbcommentsSUPtoOK($chapterId, $number_of_coms_DEL, $number_of_coms_OK);
    //Affichage de la page du chap concerné
    $Page  = 'index.php?action=manageComs&chapter_number=' . $chapterId;
    $Time = 1;
   ?>
<script type="text/javascript">
    window.setTimeout("location=('<?php echo $Page; ?>');", <?php echo $Time; ?>);

</script>
<?php
}

//Quand l'admin affiche quand même un com signalé
function WAITToOK($chapterId) {
    $commentManager = new CommentManager();
    //Le status du commentaire passe en WAIT
    $waittook = $commentManager->DisplayReported($_GET['id']);    
    $chaptersManager = new PostChapter();
    //Recup du n° du chapitre
    $chapter = $chaptersManager->getChapter($_GET['chapter_number']);
    // -1 dans le nombre de coms WAIT
    $number_of_coms_WAIT = $chapter['number_of_coms_WAIT'] - 1;
    // +1 dans le nombre de OK
    $number_of_coms_OK = $chapter['number_of_coms_OK'] + 1;
    //modif dans la BDD
    $majnbcommentsWAITtoOK = $chaptersManager->MAJnbcommentsWAITtoOK($chapterId, $number_of_coms_WAIT, $number_of_coms_OK);
    //Affichage de la page du chap concerné
    $Page  = 'index.php?action=manageComs&chapter_number=' . $chapterId;
    $Time = 1;
   ?>
<script type="text/javascript">
    window.setTimeout("location=('<?php echo $Page; ?>');", <?php echo $Time; ?>);

</script>

<?php
}
    
//Affiche les commentaires et les nombres de commentaires sur la page de gestion des coms d'1 chapitre
function manageComs() {
    $chaptersManager = new PostChapter();
    $commentManager = new CommentManager();
    //Permet d'afficher un apercu du contenu d'un chapitre
    $chapter = $chaptersManager->getChapter($_GET['chapter_number']);
    //Affiche les infos relatives aux coms (contenu + nombre de chaque categorie de com)
    $Reported = $commentManager->getReportedComments($_GET['chapter_number']);
    require('views/manageComsView.php');
} 

//Affiche la page pour rediger un nouveau chapitre
function DisplayNewChapterPage (){
    require ('views/newChapterView.php');
}
    
//Affiche la page Acces refusé
function DisplayAccesDeniedPage (){
    require ('views/accesDeniedView.php');
}
    
//Affiche la page mentions legales
function DisplayMentionsLeg (){
    require ('views/MentionsLegales.php');
}
    
//Affiche la page home quand on est co 
function DisplayHomeViewCo (){
    $_SESSION['admin'] = 'ONLINE';
    $chaptersManager = new PostChapter(); 
    $lastschapters = $chaptersManager->getLastsChapters();
    require ('views/homeView.php');
}

function forgottenPWD() { //Avec PHPMailer
    require 'PHPMailerAutoload.php';
    $mail = new PHPMailer;
    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = 'smtp.ionos.com';  // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = '*******';                 // SMTP username
    $mail->Password = '******';                           // SMTP password
    $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 587;                                    // TCP port to connect to
    $mail->setFrom('*****', 'Site Billet simple pour l\'Alaska');
    $mail->addAddress('*********', 'Jean Forteroche');     // Add a recipient
      // Optional name
    $mail->isHTML(true);                                  // Set email format to HTML

    //Generation d'une chaine aléatoire
    $longueur = 10; 
    $caracteres = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $longueurMax = strlen($caracteres);
    $chaineAleatoire = '';
    for ($i = 0; $i < $longueur; $i++) {
        $chaineAleatoire .= $caracteres[rand(0, $longueurMax - 1)];
    }

    $mail->Subject = 'Mot de passe oubli&eacute; - Billet Simple pour l\'Alaska';

    $mail->Body    = ' Bonjour. Vous avez oublié votre mot de passe pour le site "Billet Simple pour l\'Alaska". Voici un mot de passe provisoire que vous pouvez utliser pour vous reconnecter : ' . $chaineAleatoire . '.<br> Vous pourrez changer ce mot de passe une fois connecté. ';

    $mail->AltBody = 'Bonjour. Vous avez oublié votre mot de passe pour la site "Billet Simple pour l\'Alaska". Voici un mot de passe provisoire que vous pouvez utliser pour vous reconnecter : ' . $chaineAleatoire . ' Vous pourrez changer ce mot de passe une fois connecté. ';
    
    $usersManager = new UsersManager();
    $user = $usersManager -> logIn ();
    while ($AccesUser = $user->fetch()) {
        if ($_POST['confirm_email'] == $AccesUser['email']){
            if(!$mail->send()) {
                echo 'Message could not be sent.';
                echo 'Mailer Error: ' . $mail->ErrorInfo;
            } else { ?>
<script>
    alert('Un mail vient de vous être envoyé. Utilisez le mot de passe contenu dans le mail pour vous reconnecter');

</script>
<?php 
                $usersManager = new UsersManager();
                $new_forgotten_pwd = $usersManager->pwd_forgotten(hash('md5', $chaineAleatoire));
                $chaptersManager = new PostChapter();
                $lastschapters = $chaptersManager->getLastsChapters();
            require('views/homeView.php');
            }
        } else { 
            $chaptersManager = new PostChapter();
            $lastschapters = $chaptersManager->getLastsChapters();
            require('views/homeView.php'); ?>
<script>
    alert('L\'adresse email est inconnue.');

</script>
<?php 
        }
    }    
}
}

?>