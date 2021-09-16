<?php

require_once("Manager.php");

class PostChapter extends Manager {
//    // requete pour récupérer les 3 derniers chapitre ordre DESC   
    public function getLastsChapters() {
        $debut = 0;
        $limite = 3;
        $db = $this->dbConnect();
        $lastschapters = $db->prepare('SELECT id, chapter_number, title, author_chap, content_chap, number_of_coms_OK, number_of_coms_WAIT, number_of_coms_DEL,  DATE_FORMAT(chap_publi_date, \'%d/%m/%Y à %Hh%imin\') AS chap_publi_date_fr FROM Chapters ORDER BY chapter_number DESC LIMIT :debut, :limite');
        $lastschapters->bindValue('debut', $debut, PDO::PARAM_INT);
        $lastschapters->bindValue('limite', $limite, PDO::PARAM_INT);
        $lastschapters->execute();
        
        return $lastschapters;
    }
    
    // requete pour récupérer tous les chapitres et pagination
    public function getAllChapters() {
        $page = (!empty($_GET['page']) ? $_GET['page'] : 1);
        $limite = 5;
        $debut = ($page - 1) * $limite;
        /* Ne pas oublier d'adapter notre requête */
        $db = $this->dbConnect();
        $allchapters = $db->prepare('SELECT SQL_CALC_FOUND_ROWS id, chapter_number, title, author_chap, content_chap, number_of_coms_OK, number_of_coms_WAIT, number_of_coms_DEL, DATE_FORMAT(chap_publi_date, \'%d/%m/%Y à %Hh%imin\') AS chap_publi_date_fr FROM Chapters ORDER BY chapter_number LIMIT :limite OFFSET :debut');
        $allchapters->bindValue('debut', $debut, PDO::PARAM_INT);
        $allchapters->bindValue('limite', $limite, PDO::PARAM_INT);
        $allchapters->execute();
        
        return $allchapters;
    }
    
    // requete pour récupérer tous les chapitres ordre DESC et pagination
    public function getAllChaptersDesc() {
        $page = (!empty($_GET['page']) ? $_GET['page'] : 1);
        $limite = 5;
        $debut = ($page - 1) * $limite;
        /* Ne pas oublier d'adapter notre requête */
        $db = $this->dbConnect();
        $allchaptersdesc = $db->prepare('SELECT SQL_CALC_FOUND_ROWS id, chapter_number, title, author_chap, content_chap, number_of_coms_OK, number_of_coms_WAIT, number_of_coms_DEL, DATE_FORMAT(chap_publi_date, \'%d/%m/%Y à %Hh%imin\') AS chap_publi_date_fr FROM Chapters ORDER BY chapter_number DESC LIMIT :limite OFFSET :debut');
        $allchaptersdesc->bindValue('debut', $debut, PDO::PARAM_INT);
        $allchaptersdesc->bindValue('limite', $limite, PDO::PARAM_INT);
        $allchaptersdesc->execute();
        
        return $allchaptersdesc;
    }
    
    //Compte le nb de chapitres pour pagination
    public function count_nb_chap () {
       $author_chap = 'Jean Forteroche';
        $db = $this->dbConnect();
        $countnbchap = $db->prepare("SELECT COUNT(*) as Compteur FROM Chapters WHERE author_chap = :author_chap");
        $countnbchap->bindValue(':author_chap', $author_chap, PDO::PARAM_STR);
        $countnbchap->execute();
        return $countnbchap;
    }
    
     //Pour modification du contenu d'un chapitre
    public function MAJChapter($chapter_number, $title, $content_chap) {
    	$title = htmlspecialchars($title);
        $db = $this->dbConnect();
        $req = $db->prepare('UPDATE Chapters SET title = :title, content_chap = :content_chap WHERE chapter_number = :chapter_number');
        $newcontentchap = $req->execute(array(
            'title' => $title, 
            'content_chap' => $content_chap, 
            'chapter_number' => $chapter_number));
        return $newcontentchap;
    }
    
    // requete pour mettre à jour le nb de commentaires OK quand ajout d'un com
    public function MAJnbcomments($chapterId, $number_of_coms_OK) {
        $db = $this->dbConnect();
        $req = $db->prepare('UPDATE Chapters SET number_of_coms_OK = :number_of_coms_OK WHERE chapter_number = :chapter_number');
        $newnbcomments = $req->execute(array(
            'number_of_coms_OK' => $number_of_coms_OK, 
            'chapter_number' => $chapterId));
        return $newnbcomments;
    }
    
    // requete pour mettre à jour le nb de commentaires OK et en attente (WAIT) quand un com est signalé
    public function MAJnbcommentsOKtoWAIT($chapterId2, $number_of_coms_OK, $number_of_coms_WAIT) {
        $db = $this->dbConnect();
        $req = $db->prepare('UPDATE Chapters SET number_of_coms_OK = :number_of_coms_OK, number_of_coms_WAIT = :number_of_coms_WAIT WHERE chapter_number = :chapter_number');
        $majnbcommentsOKtoWAIT = $req->execute(array(
            'number_of_coms_OK' => $number_of_coms_OK, 
            'number_of_coms_WAIT' => $number_of_coms_WAIT, 
            'chapter_number' => $chapterId2));
        return $majnbcommentsOKtoWAIT;
    }
    
    //Quand l'admin revalide un commentaire supprimé
    public function MAJnbcommentsSUPtoOK($chapterId, $number_of_coms_DEL, $number_of_coms_OK) {
        $db = $this->dbConnect();
        $req = $db->prepare('UPDATE Chapters SET number_of_coms_DEL = :number_of_coms_DEL, number_of_coms_OK = :number_of_coms_OK WHERE chapter_number = :chapter_number');
        $majnbcommentsSUPtoOK = $req->execute(array(
            'number_of_coms_DEL' => $number_of_coms_DEL, 
            'number_of_coms_OK' => $number_of_coms_OK, 
            'chapter_number' => $chapterId));
        return $majnbcommentsSUPtoOK;
    }
    
    //Quand l'admin affiche quand même un com signalé
    public function MAJnbcommentsWAITtoOK($chapterId, $number_of_coms_WAIT, $number_of_coms_OK) {
        $db = $this->dbConnect();
        $req = $db->prepare('UPDATE Chapters SET number_of_coms_WAIT = :number_of_coms_WAIT, number_of_coms_OK = :number_of_coms_OK WHERE chapter_number = :chapter_number');
        $majnbcommentsWAITtoOK = $req->execute(array(
            'number_of_coms_WAIT' => $number_of_coms_WAIT, 
            'number_of_coms_OK' => $number_of_coms_OK, 
            'chapter_number' => $chapterId));
        return $majnbcommentsWAITtoOK;
    }
    
    
    // requete pour mettre à jour le nb de commentaires en attente (WAIT) et com en DEL quand l'admin 'supprime' un commentaire
    public function MAJnbcommentsWAITtoDEL($chapterId4, $number_of_coms_WAIT, $number_of_coms_DEL) {
        $db = $this->dbConnect();
        $req = $db->prepare('UPDATE Chapters SET number_of_coms_WAIT = :number_of_coms_WAIT, number_of_coms_DEL = :number_of_coms_DEL WHERE chapter_number = :chapter_number');
        $majnbcommentsWAITtoDEL = $req->execute(array(
            'number_of_coms_WAIT' => $number_of_coms_WAIT, 
            'number_of_coms_DEL' => $number_of_coms_DEL, 
            'chapter_number' => $chapterId4));
        return $majnbcommentsWAITtoDEL;
    }
    
    //De OK a SUP
    public function MAJnbcommentsOKtoSUP($chapterIdOKK, $LEnumber_of_comsOK, $number_of_coms_DEL) {
        $db = $this->dbConnect();
        $req = $db->prepare('UPDATE Chapters SET number_of_coms_OK = :LEnumber_of_comsOK, number_of_coms_DEL = :number_of_coms_DEL WHERE chapter_number = :chapter_number');
        $newnbcommentsOK = $req->execute(array(
            'LEnumber_of_comsOK' => $LEnumber_of_comsOK, 
            'number_of_coms_DEL' => $number_of_coms_DEL, 
            'chapter_number' => $chapterIdOKK));
        return $newnbcommentsOK;
    }
    
    // requete pour récuperer 1 chapitre en particulier
    public function getChapter($chapterId) {
        $db = $this->dbConnect();
        $allchapters = $db->prepare('SELECT id, chapter_number, title, author_chap, content_chap, number_of_coms_OK, number_of_coms_WAIT, number_of_coms_DEL,   DATE_FORMAT(chap_publi_date, \'%d/%m/%Y à %Hh%imin\') AS chap_publi_date_fr FROM Chapters WHERE chapter_number = ?');
        $allchapters->execute(array($chapterId));
        $chapter = $allchapters->fetch();

        return $chapter;
    }
    
    // requete pour inserer/poster un chapitre
    public function postChapters($nbcoms, $title, $content) {
        $secure_content_chap = $content;
        $secure_title = htmlspecialchars($title);
        $db = $this->dbConnect();
        $Chapters = $db->prepare("INSERT INTO Chapters(chapter_number, title, author_chap, chap_publi_date, content_chap, number_of_coms_OK, number_of_coms_WAIT, number_of_coms_DEL) VALUES(?, ?,'Jean Forteroche', NOW(), ?, 0, 0, 0)");
        $newLines = $Chapters->execute(array($nbcoms, $secure_title, $secure_content_chap));

        return $newLines;
    }
    
    // requete pour supp un chapitre quand l'admin en supprimer un
    public function DeleteChapter($chapterId) {
        $db = $this->dbConnect();
        $DelChapter = $db->prepare('DELETE FROM Chapters WHERE chapter_number = ?');
        $DelChapter->execute(array($chapterId));
        $deletechapter = $DelChapter->fetch();
        
        return $deletechapter;
    }    
    
}