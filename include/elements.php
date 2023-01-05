<?php

include('connexion.php');

class element {
    public $id;
    public $balise;
    public $contenu;
    public $style;
    public $src;
    public $alt;
    public $id_article;

function create(){
    $sql = 'INSERT INTO elements (balise, contenu, alt, src, id_article) VALUES (:balise, :contenu, :alt, :src, :id_article);';
    $pdo = connexion();
    $query = $pdo->prepare($sql);
    $query->bindValue(':balise', $this->balise, PDO::PARAM_STR);
    $query->bindValue(':contenu', $this->contenu, PDO::PARAM_STR);
    $query->bindValue(':alt', $this->alt, PDO::PARAM_STR);
    $query->bindValue(':src', $this->src, PDO::PARAM_STR);
    $query->bindValue(':id_article', $this->id_article, PDO::PARAM_INT);
    $query->execute();
    $this->id = $pdo->lastInsertId();
}

function modifier($a,$b, $c, $d) {
    $this->balise = $a;
    $this->contenu =$b;
    $this->alt =$c;
    $this->src =$d;
}

static function readAll() {
    $sql= 'select * from elements';
    $pdo = connexion();
    $query = $pdo->prepare($sql);
    $query->execute();
    $tableau = $query->fetchAll(PDO::FETCH_CLASS,'element');
    return $tableau;
  }

function affiche () {
    echo '
    <div class="elements-container">
      <h3> Article : </h3>
      <p>'.$this->src.'</p>
      <'.$this->balise.'>'.$this->contenu.'</'.$this->balise.'>    
      <a href="controleur.php?page=elements&action=delete&id='.$this->id.'">supprimer</a>   
      <a href="controleur.php?page=elements&action=edit&id='.$this->id.'">modifier</a>
    </div>';
}

static function readOne($id) {
    $sql= 'select * from elements where id = :valeur';
    $pdo = connexion();
    $query = $pdo->prepare($sql);
    $query->bindValue(':valeur', $id, PDO::PARAM_INT);
    $query->execute();
    $objet = $query->fetchObject('element');
    return $objet;
  }

  function chargePOST() {
    $this->balise = $_POST['balise'];
    $this->contenu = $_POST['contenu'];
    $this->alt = $_POST['alt'];
    $this->src = $_POST['src'];
    $this->id_article = $_POST['id_article'];
    $this->id = $_POST['id'];
  }

  function update(){
    $sql = 'UPDATE elements SET balise = :balise, contenu = :contenu, alt = :alt, src = :src WHERE id = :id;';
    $pdo = connexion();
    $query = $pdo->prepare($sql);
    $query->bindValue(':id', $this->id, PDO::PARAM_INT);
    $query->bindValue(':balise', $this->balise, PDO::PARAM_STR);
    $query->bindValue(':contenu', $this->contenu, PDO::PARAM_STR);
    $query->bindValue(':alt', $this->alt, PDO::PARAM_STR);
    $query->bindValue(':src', $this->src, PDO::PARAM_STR);
    $query->execute();
  }

  static function delete($id) {
    $sql = 'DELETE FROM elements WHERE id = :id;';

    $pdo = connexion();

    $query = $pdo->prepare($sql);

    $query->bindValue(':id', $id, PDO::PARAM_INT);

    $query->execute();
}

function afficheForm(){
    echo '<h2>Modification d\'un contenu</h2>';
    echo 'Modification d\'un contenu';
    echo '<form method=post action="controleur.php?page=elements&action=update">';
    echo '<input type="hidden" name="id" value="'.$this->id.'">';
    echo '<input type="hidden" name="id_article" value="'.$this->id_article.'">';
    echo '<select name="balise" id="balise">
    <option value="p">paragraphe</option>
    <option value="h1">h1</option>
    <option value="h2">h2</option>
    <option value="h3">h3</option>
    </select>'; 
    echo '<input type="text" name="contenu" value="'.$this->contenu.'">';
    echo '<input type="text" name="alt" value="'.$this->alt.'">';
    echo '<input type="text" name="src" value="'.$this->src.'">';
    echo '<input type="submit" value="Modifier">';
    echo '</form>';
  }

  static function readByArticle($id){
    $sql= 'select * from elements where id_article = :id_article';
    
    $pdo = connexion();
    $query = $pdo->prepare($sql);
    $query->bindValue(':id_article', $id, PDO::PARAM_INT);
    $query->execute();
    $tableau = $query->fetchAll(PDO::FETCH_CLASS,'element');

    return $tableau;
  }
    // function ajouterImage(){
    //     $sql = 'INSERT INTO elements (balise, contenu, src, alt) VALUES (:balise, :contenu, :src, :alt);';
    //     $pdo = connexion();
    //     $query = $pdo->prepare($sql);
    //     $query->bindValue(':balise', $this->balise, PDO::PARAM_STR);
    //     $query->bindValue(':contenu', $this->contenu, PDO::PARAM_STR);
    //     $query->bindValue(':src', $this->src, PDO::PARAM_STR);
    //     $query->bindValue(':alt', $this->alt, PDO::PARAM_STR);
    //     $query->execute();
    //     $this->id = $pdo->lastInsertId();
    // }
}





