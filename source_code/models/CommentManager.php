<?php
require_once("Manager.php");

class CommentManager extends Manager {
    // requête pour recupérer les coms non signalés d'un chapitre
    public function getComments($chapterId) {
        $db = $this->dbConnect();
        $GetComsOK = $db->prepare('SELECT id, author_com, content_com, status, DATE_FORMAT(com_publi_date, \'%d/%m/%Y à %Hh%imin\') AS com_publi_date_fr FROM Comments WHERE status = "OK" AND id_post = ? ORDER BY com_publi_date DESC');
        $GetComsOK->execute(array($chapterId));

        return $GetComsOK;
    }
     
    // requête pour recupérer tous les coms
    public function getReportedComments($chapterId) {
        $db = $this->dbConnect();
        $Reported = $db->prepare('SELECT id, author_com, content_com, status, DATE_FORMAT(com_publi_date, \'%d/%m/%Y à %Hh%imin\') AS com_publi_date_fr FROM Comments WHERE id_post = ? ORDER BY status');
        $Reported->execute(array($chapterId));

        return $Reported;
    }
    
    //Requête pour inserer/poster un com dans la BDD
    public function postComment($chapterId, $author, $comment) {
        $secure_comment = htmlspecialchars($comment);
        $secure_author = htmlspecialchars($author);
        $db = $this->dbConnect();
        $Comments = $db->prepare("INSERT INTO Comments(id_post, author_com, content_com, com_publi_date, status) VALUES(?, ?, ?, NOW(), 'OK')");
        $affectedLines = $Comments->execute(array($chapterId, $secure_author, $secure_comment));

        return $affectedLines;
    }
    
    //requête pour supprimer définitivement un commentaire (s'execute quand un chapitre est supprimé)
    public function DeleteComs($chapterId) {
        $db = $this->dbConnect();
        $DeleteComs = $db->prepare("DELETE FROM Comments WHERE id_post = $_GET[chapter_number]");
        $DeleteComs->execute(array($chapterId));
        $deletecomments = $DeleteComs->fetch();
        
        return $deletecomments;
    }
    
    //Requête pour changer le status d'un commentaire à DEL quand un com est signalé et supprimé par l'admin
    public function ToDEL($chapterId2) {
        $db = $this->dbConnect();
        $ToDEL = $db->prepare("UPDATE Comments SET status = 'DEL' WHERE id = $_GET[id]");
        $ToDEL->execute(array($chapterId2));
        $todel = $ToDEL->fetch();
        return $todel;
    }
    
     //Requête de OK a DEL
    public function DeleteComsOK($chapterIdOK) {
        $db = $this->dbConnect();
        $DeleteComsOK = $db->prepare("UPDATE Comments SET status = 'DEL' WHERE id = $_GET[id]");
        $DeleteComsOK->execute(array($chapterIdOK));
        $deletecommentsOK = $DeleteComsOK->fetch();
        return $deletecommentsOK;
    }
    
    //Requête pour changer le status d'un commentaire à en attente WAIT quand un com est signalé
    public function ToWAIT($chapterId3) {
        $db = $this->dbConnect();
        $ToWAIT = $db->prepare("UPDATE Comments SET status = 'WAIT' WHERE id = $_GET[id]");
            
        $ToWAIT->execute(array($chapterId3));
        $towait = $ToWAIT->fetch();
        
        return $towait;
    }
    
    //Quand l'admin revalide un commentaire supprimé
    public function Revalide($chapterId) {
        $db = $this->dbConnect();
        $Revalide = $db->prepare("UPDATE Comments SET status = 'OK' WHERE id = $_GET[id]");
            
        $Revalide->execute(array($chapterId));
        $revalide = $Revalide->fetch();
        
        return $revalide;
    }
    
    //Quand l'admin affiche quand même un com signalé
    public function DisplayReported($chapterId) {
        $db = $this->dbConnect();
        $DisplayReported = $db->prepare("UPDATE Comments SET status = 'OK' WHERE id = $_GET[id]");
            
        $DisplayReported->execute(array($chapterId));
        $displayreported = $DisplayReported->fetch();
        
        return $displayreported;
    }
}


