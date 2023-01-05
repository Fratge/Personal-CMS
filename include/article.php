<?php

include('elements.php');

class article {
  public $id_article;
  public $h1_article;
  public $chapo_article;
  public $auteur_article;
  public $elements_article;

  function create(){
    $sql = 'INSERT INTO article (h1_article ,chapo_article, auteur_article) VALUES (:h1_article , :chapo_article, :auteur_article);';
    $pdo = connexion();
    $query = $pdo->prepare($sql);
    $query->bindValue(':h1_article', $this->h1_article, PDO::PARAM_STR);
    $query->bindValue(':chapo_article', $this->chapo_article, PDO::PARAM_STR);
    $query->bindValue(':auteur_article', $this->auteur_article, PDO::PARAM_STR);
    $query->execute();
    $this->id_article = $pdo->lastInsertId();
}

  function modifier($a, $b, $c) {
    $this->h1_article = $a;
    $this->chapo_article = $b;
    $this->auteur_article = $c;
  }

  static function readAll() {
      $sql= 'select * from article';
      $pdo = connexion();
      $query = $pdo->prepare($sql);
      $query->execute();
      $tableau = $query->fetchAll(PDO::FETCH_CLASS,'article');
      return $tableau;
    }

  function affiche () {
      echo '<h4>Voici tout les articles ! </h4>
      <p>'.$this->h1_article.'</p>
      <p>'.$this->chapo_article.'</p>
      <p>Auteur :'.$this->auteur_article.'</p>';
  }

  static function readOne($id) {
      $sql = 'select * from article where id_article = :valeur';
      $pdo = connexion();
      $query = $pdo->prepare($sql);
      $query->bindValue(':valeur', $id, PDO::PARAM_INT);
      $query->execute();
      $objet = $query->fetchObject('article');
      $objet->elements_article = element::readByArticle($id);
      return $objet;
    }

    function chargePOST() {
      $this->id_article = $_POST['id_article'];
      $this->h1_article = $_POST['h1_article'];
      $this->chapo_article = $_POST['chapo_article'];
      $this->auteur_article = $_POST['auteur_article'];
    }

    function update(){
      $sql = 'UPDATE article SET h1_article = :h1_article, chapo_article = :chapo_article, auteur_article = :auteur_article WHERE id_article = :id_article;';
      $pdo = connexion();
      $query = $pdo->prepare($sql);
      $query->bindValue(':id_article', $this->id_article, PDO::PARAM_INT);
      $query->bindValue(':h1_article', $this->h1_article, PDO::PARAM_STR);
      $query->bindValue(':chapo_article', $this->chapo_article, PDO::PARAM_STR);
      $query->bindValue(':auteur_article', $this->auteur_article, PDO::PARAM_STR);
      $query->execute();
    }

  function afficheForm(){
    echo '<h2>Modification de l\'article !</h2>';
    echo '<form method=post action="controleur.php?page=article&action=update">';
    echo '<input type="hidden" name="id_article" value="'.$this->id_article.'">';
    echo '<input type="text" name="h1_article" value="'.$this->h1_article.'" placeholder="Titre article">';
    echo '<input type="text" name="chapo_article" value="'.$this->chapo_article.'" placeholder="chapo">';
    echo '<input type="text" name="auteur_article" value="'.$this->auteur_article.'" placeholder="auteur">';
    echo '<input type="submit" value="Modifier">';
    echo '</form>';
  }

  static function delete($id) {
    $sql = 'DELETE FROM article WHERE id_article = :id_article;';

    $pdo = connexion();

    $query = $pdo->prepare($sql);

    $query->bindValue(':id_article', $id, PDO::PARAM_INT);

    $query->execute();
}

}