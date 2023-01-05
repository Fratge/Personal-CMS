<?php
include('config.php');
 
function connexion() {
  global $config;
 
  $pdo = new PDO($config['driver'].':host='.$config['serveur'].';dbname='.$config['base'].';charset=utf8',
    $config['utilisateur'],
    $config['mdp']);
  if ($pdo) {
    return $pdo;
  } else {
    echo '<p>Connexion impossible !</p>';
    exit;
  }
}