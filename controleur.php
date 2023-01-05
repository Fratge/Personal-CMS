<?php

include('include/article.php');

include('include/twig.php');
$twig = init_twig();

if (isset($_GET['page'])) $page = $_GET['page']; else $page = '';
if (isset($_GET['action'])) $action = $_GET['action']; else $action = 'read';
if (isset($_GET['id'])) $id = intval($_GET['id']); else $id = 0;

$modele = '';
$data = [];

switch ($page) {
  case 'elements' :
    switch ($action) {
      case 'read' :
        $contenu = 'affichage des elements';
        if ($id > 0) {
            $modele = 'affichage_elements.twig';
            $data = ['element' => element::readOne($id), 'aside' => article::readAll()]; 
            echo $twig->render($modele, $data);
          }
          else {
            $modele = 'affichage_elements.twig';
            $data = ['elements' => element::readAll($id), 'aside' => article::readAll()]; 
            echo $twig->render($modele, $data);
          }
      break;
      case 'create' : 
          $auteur = new element();
          $auteur->chargePOST();
          $auteur->create();
          $data = ['article' => article::readOne($auteur->id_article), 'aside' => article::readAll()]; 
          $modele = 'article_unique.twig'; 
          echo $twig->render($modele, $data);
      break;
      case 'delete' :
        echo 'Suppression de l\'element '.$id;
        element::delete($id);
        header('Location: controleur.php?page=elements');
      break;
      case 'update' :
        $element= new element();
        $element->chargePOST();
        $element->update();
        header('Location: controleur.php?page=elements');
    break;
      default :
        echo 'Action non reconnue';
        case 'edit' :
            $auteur = element::readOne($id);
            $modele = 'modifier_elements.twig';
            $data = ['aside' => article::readAll()];
            echo $twig->render($modele, $data);
            $auteur->afficheForm();
            break;
        }
        break;
  
  case 'form_elements' :
    $modele = 'create.twig';
    $data = ['elements' => element::readAll($id), 'article' => article::readAll(), 'aside' => article::readAll()]; 
    echo $twig->render($modele, $data);
  break;

  case 'article' :
    switch ($action) {
      case 'read' :
        $contenu = 'affichage des articles';
        if ($id > 0) {
            $modele = 'article_unique.twig';
            $data = ['article' => article::readOne($id), 'aside' => article::readAll()]; 
            echo $twig->render($modele, $data);
          }
          else {
            $modele = 'affichage_articles.twig';
            $data = ['articles' => article::readAll(), 'aside' => article::readAll()]; 
            echo $twig->render($modele, $data);
          }
      break;
      case 'create' : 
          $auteur = new article();
          $auteur->chargePOST();
          $auteur->create();
        header('Location: controleur.php?page=article');
      break;
      case 'delete' :
        echo 'Suppression de l\'article '.$id;
        article::delete($id);
        header('Location: controleur.php?page=article');
      break;
      case 'update' :
        $article= new article();
        $article->chargePOST();
        $article->update();
        $modele = 'affichage_articles.twig';
        $data = ['articles' => article::readAll(), 'aside' => article::readAll()]; 
        echo $twig->render($modele, $data);
    break;
      default :
        echo 'Action non reconnue';
        case 'edit' :
            $auteur = article::readOne($id);
            $modele = 'modifier_articles.twig';
            $data = ['aside' => article::readAll()];
            echo $twig->render($modele, $data);
            $auteur->afficheForm();
            break;
        }
        break;
    case 'erreur' :
        echo '<h1>Page Erreur</h1>';
    break;
  default :
    $modele = 'accueil.twig';
    $data = []; 
}
