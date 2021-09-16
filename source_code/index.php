<?php
session_start();
require('controller/controller.php');

class Routeur { 
    public function RenvoisController () {
        $controller = new Controller ();
        
        try { 
            if (isset($_GET['action'])) {
                
                //Pour afficher les derniers chapitres
                if ($_GET['action'] == 'listLastsChapters') {
                    $actioncontroller = $controller -> listLastsChapters();
                }
                //Pour afficher tous les chapitres
                elseif ($_GET['action'] == 'listAllChapters'){
                    $actioncontroller = $controller -> listAllChapters();
                }
                //Pour afficher 1 chapitre
                elseif ($_GET['action'] == 'chapter') {
                    if (isset($_GET['chapter_number']) && $_GET['chapter_number'] > 0) {
                        $actioncontroller = $controller -> chapter();
                    }
                    else {
                        throw new Exception('Aucun identifiant de billet envoyé');
                    }
                }
                
                //Affiche les commentaires et les nombres de commentaires sur la page de gestion des coms d'1 chapitre
                elseif ($_GET['action'] == 'manageComs') {
                     
                    //Si l'admin est CO
                     if (isset($_SESSION['admin']) && $_SESSION['admin'] == 'ONLINE'){
                        if (isset($_GET['chapter_number']) && $_GET['chapter_number'] > 0) {
                            $actioncontroller = $controller -> manageComs();
                        } else {
                            throw new Exception('Aucun identifiant de billet envoyé');
                        }
                     } else {
                         //Si admin pas co
                        $actioncontroller = $controller -> DisplayAccesDeniedPage();
                    }
                }
                
                //pour ajouter un chapitre
                elseif ($_GET['action'] == 'addChapter') {
                    if (isset($_SESSION['admin']) && $_SESSION['admin'] == 'ONLINE'){
                        //Si l'admin est CO
                        if (!empty($_POST['chapter_number']) && !empty($_POST['title']) && !empty($_POST['content_chap'])) {
                            $actioncontroller = $controller -> addChapter($_POST['chapter_number'], $_POST['title'], $_POST['content_chap']);
                        } else {
                            // Autre exception
                            throw new Exception('Tous les champs ne sont pas remplis !');
                        }
                    } else {
                        //Si admin pas co
                        $actioncontroller = $controller -> DisplayAccesDeniedPage();
                    }
                }
                    
                //Pour suprimer 1 chapitre
                elseif ($_GET['action'] == 'Suppchapter') {
                    //Si l'admin est CO
                    if (isset($_SESSION['admin']) && $_SESSION['admin'] == 'ONLINE'){
                        if (isset($_GET['chapter_number']) && $_GET['chapter_number'] > 0) {
                            $actioncontroller = $controller -> Suppchapter();
                            $actioncontroller = $controller -> Suppcomments();
                        } else {
                            throw new Exception('Aucun identifiant de billet envoyé');
                        } 
                    } else {
                        //Si admin pas co
                        $actioncontroller = $controller -> DisplayAccesDeniedPage();
                    }
                }
                
                //Pour quand l'admin supprime vrmt un commentaire signalé :
                elseif ($_GET['action'] == 'SuppCommentsAdmin') {
                    //Si l'admin est CO
                    if (isset($_SESSION['admin']) && $_SESSION['admin'] == 'ONLINE'){
                        if (isset($_GET['id']) && $_GET['id'] > 0 && isset($_GET['chapter_number']) && $_GET['chapter_number'] > 0) {
                            $actioncontroller = $controller -> SuppCommentsAdmin($_GET['chapter_number']);
                        } else {
                            throw new Exception('Aucun n° de chapitre envoyé');
                        }
                    } else {
                        //Si admin pas co
                        $actioncontroller = $controller -> DisplayAccesDeniedPage();
                    }
                }
                
                //DE OK a SUP
                elseif ($_GET['action'] == 'SuppcommentsOK') {
                     
                    //Si l'admin est CO
                    if (isset($_SESSION['admin']) && $_SESSION['admin'] == 'ONLINE'){
                        if (isset($_GET['id']) && $_GET['id'] > 0 && isset($_GET['chapter_number']) && $_GET['chapter_number'] > 0) {
                            $actioncontroller = $controller -> SuppcommentsOK($_GET['chapter_number']);
                        } else {
                            throw new Exception('Aucun n° de chapitre envoyé');
                        }
                    } else {
                        //Si admin pas co
                        $actioncontroller = $controller -> DisplayAccesDeniedPage();
                    }
                }
                
                //Pour modifier 1 chapitre
                elseif ($_GET['action'] == 'UpdateChapter') {
                    //Si l'admin est CO
                    if (isset($_SESSION['admin']) && $_SESSION['admin'] == 'ONLINE'){
                        if (isset($_GET['chapter_number']) && $_GET['chapter_number'] > 0) {
                            if (!empty($_POST['title']) && !empty($_POST['content_chap'])) {
                                $actioncontroller = $controller -> UpdateChapter($_GET['chapter_number']);
                            }
                            else {
                                throw new Exception('Tous les champs ne sont pas remplis !');
                            }
                        }
                        else {
                            throw new Exception('Aucun identifiant de billet envoyé');
                        }
                    } else {
                        //Si admin pas co
                        $actioncontroller = $controller -> DisplayAccesDeniedPage();
                    }
                }
                
                //Pour signaler 1 commentaire
                elseif ($_GET['action'] == 'IsReported') {
                    if (isset($_GET['id']) && $_GET['id'] > 0) {
                        $actioncontroller = $controller -> IsReported($_GET['chapter_number']);
                    }
                    else {
                        throw new Exception('Aucun n° de chapitre envoyé');
                    }
                }
                
                //Quand l'admin revalide un commentaire supprimé
                elseif ($_GET['action'] == 'DELToOK') {
                    //Si l'admin est CO
                    if (isset($_SESSION['admin']) && $_SESSION['admin'] == 'ONLINE'){
                        if (isset($_GET['id']) && $_GET['id'] > 0 && isset($_GET['chapter_number']) && $_GET['chapter_number'] > 0) {
                            $actioncontroller = $controller -> DELToOK($_GET['chapter_number']);
                        } else {
                            throw new Exception('Aucun n° de chapitre envoyé');
                        }
                    } else {
                        //Si admin pas co
                        $actioncontroller = $controller -> DisplayAccesDeniedPage();
                    }
                }
                
                //Quand l'admin affiche quand même un com signalé
                elseif ($_GET['action'] == 'WAITToOK') {
                    //Si l'admin est CO
                    if (isset($_SESSION['admin']) && $_SESSION['admin'] == 'ONLINE'){
                        if (isset($_GET['id']) && $_GET['id'] > 0 && isset($_GET['chapter_number']) && $_GET['chapter_number'] > 0) {
                            $actioncontroller = $controller -> WAITToOK($_GET['chapter_number']);
                        } else {
                            throw new Exception('Aucun n° de chapitre envoyé');
                        }
                    } else {
                        //Si admin pas co
                        $actioncontroller = $controller -> DisplayAccesDeniedPage();
                    }
                }
                
                //Pour afficher la page de redaction d'un chapitre
                elseif ($_GET['action'] == 'DisplayNewChapterPage'){
                    //Si l'admin est CO
                     if (isset($_SESSION['admin']) && $_SESSION['admin'] == 'ONLINE'){
                        $actioncontroller = $controller -> DisplayNewChapterPage();
                    } else {
                         //Si admin pas co
                        $actioncontroller = $controller -> DisplayAccesDeniedPage();
                    }
                }
                
                //Pour afficher la page de modification d'un chapitre
                elseif ($_GET['action'] == 'displayUpdatePage'){
                    //Si l'admin est CO
                     if (isset($_SESSION['admin']) && $_SESSION['admin'] == 'ONLINE'){
                        $actioncontroller = $controller -> displayUpdatePage();
                    } else {
                         //Si admin pas co
                        $actioncontroller = $controller -> DisplayAccesDeniedPage();
                    }
                }
                
                //Pour afficher la page admin
                elseif ($_GET['action'] == 'acces_admin_page'){
                    //Si admin est CO
                     if (isset($_SESSION['admin']) && $_SESSION['admin'] == 'ONLINE'){
                        $actioncontroller = $controller -> acces_admin_page();
                    } else {
                         //Si admin pas co
                        $actioncontroller = $controller -> DisplayAccesDeniedPage();
                    }
                }
                
                //Pour afficher la page home quand connecté
                elseif ($_GET['action'] == 'DisplayHomeViewCo'){
                    //Si admin est CO
                     if (isset($_SESSION['admin']) && $_SESSION['admin'] == 'ONLINE'){
                        $actioncontroller = $controller -> DisplayHomeViewCo();
                    } else {
                         //Si admin pas co
                        $actioncontroller = $controller -> DisplayAccesDeniedPage();
                    }
                }
                
                //Pour afficher les mentions legales
                elseif ($_GET['action'] == 'DisplayMentionsLeg'){
                    $actioncontroller = $controller -> DisplayMentionsLeg();
                }
                
                //Pour ajouter un commentaire
                elseif ($_GET['action'] == 'addComment') {
                    if (isset($_GET['chapter_number']) && $_GET['chapter_number'] > 0) {
                        if (!empty($_POST['author_com']) && !empty($_POST['content_com'])) {
                            $actioncontroller = $controller -> addComment($_GET['chapter_number'], $_POST['author_com'], $_POST['content_com']);
                        }
                        else {
                            throw new Exception('Tous les champs ne sont pas remplis !');
                        }
                    }
                    else {
                        throw new Exception('Aucun identifiant de billet envoyé');
                    }
                }
                
            //pour se connecter    
                elseif ($_GET['action'] == 'getlogIn'){
                    $actioncontroller = $controller -> getlogIn();
                }
            
            //pour se deconnecter    
                elseif ($_GET['action'] == 'getlogOut'){
                    $actioncontroller = $controller -> getlogOut();
                }
            
            //Quand mot de passe oublié
                elseif ($_GET['action'] == 'forgottenPWD'){
                    $actioncontroller = $controller -> forgottenPWD();
                }
                
            //pour changer de password    
                elseif ($_GET['action'] == 'new_pwd'){
                    //si l'admin est CO
                     if (isset($_SESSION['admin']) && $_SESSION['admin'] == 'ONLINE'){
                        $new_pwd_secure = htmlspecialchars($_POST['new_pwd']);
                        $confirm_new_pwd_secure = htmlspecialchars($_POST['confirm_new_pwd']);
                        $actioncontroller = $controller -> new_pwd($new_pwd_secure, $confirm_new_pwd_secure);
                        
                    } else {
                         //Si l'admin pas co 
                         $actioncontroller = $controller -> DisplayAccesDeniedPage();
                    }
                }
            }
                    
            //Si aucune action n'est envoyée, alors on affiche la page home avec les derniers chapitres
            else {
                $_SESSION['admin'] = 'OFFLINE';
                $actioncontroller = $controller -> listLastsChapters();
                
            }
        }
        catch(Exception $e) { // S'il y a eu une erreur, alors...
            echo 'Erreur : ' . $e->getMessage();
        }
    }
}

$routeur = new Routeur;
$routeur -> RenvoisController();



