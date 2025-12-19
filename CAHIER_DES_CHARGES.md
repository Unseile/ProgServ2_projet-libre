# Cahier des charges du projet libre de ProgServ2         

> Les modifications sont en citation

## But du site

Mettre en relation des élèves entre eux, afin de leur offrir une option pour qu'ils puissent s'entraider.

## Les contenus

### Pages ouvertes (sans être connecté)

#### Page d'inscription

Formulaire avec :

- Nom
- Prénom
- Pseudo
- Email
- Mot de passe
- > Checkbox s'il est enseignant
- Bouton d'envoi
- Une fois le compte créé, on doit pouvoir vérifier l'email

#### Page de connexion

Formulaire avec :

- > Pseudo
- Mot de passe
- Option de choix de connection : prof ou élève
- Bouton d'envoie

#### Page de consultation DES cours (page d'accueil)

Affiche tous les cours disponibles avec les informations suivants :

- Titre du cours
- Matière du cours
- Le professeur
- Le nombre d'inscrits
- La date
- L'heure

_Facultatif : Il doit y avoir la possibilité de trier les cours par matière et afficher uniquement la matière sélectionnée. > Qui n'as été effectué par manque de temps

#### Page de consultation D'UN cours (version déconnectée)

Affiche les informations d'un cours avec les informations suivantes :

- Titre du cours
- Matière du cours
- Le professeur
- Le nombre d'inscrits
- La date
- L'heure de début
- La description
- La durée
- Le lieu
- Le prix
- Un bouton pour se connecter

### Pages privées (doit être connecté)

#### Page de création de cours (si connecté en tant que professeur)

Avec un formulaire qui contient les champs suivants :

- Titre du cours
- Matière du cours
- Le professeur
- Le nombre d'inscrits
- La date et l'heure de début
- La durée
- La description
- Le lieu
- Le prix

#### Page de consultation D'UN cours (version connectée)

Changement du bouton "se connecter" en bouton d'inscription au cours

#### Page de profil utilisateur

On y retrouve :

- Le nom
- Le prénom
- Pseudo
- L'email > et si il est vérifié ou non
- (Optionnel) Une option pour passer le compte en compte professeur

### Page de déconnexion
> Qui renvoie à la page d'accueil, en étant déconnecté

### L'historique des cours pris et des cours données


## Les pages optionnels pour lesquels ils nous manquaient du temps
#### (Optionnel) Page de modification du mot du passe

#### (Optionnel) Page de modification de cours

#### (Optionnel) Page de suppression de cours

## Autres critères à faire attention

Tout le site doit être en Français - Anglais
La connexion à la session doit être maintenue une fois connecté
Un bouton de déconnexion dois être disponible une fois connecté
Stockage des mots de passes de façon sécurisée
Le code PHP doit être typé
L'application doit être en orienté objet, les classes sont chargées automatiquement (avec autoloader).
Fichier database.ini pour les infos de connexion à la base de donnée

## Utilisation de l'IA
Le CSS a été généré par IA et modifié manuellement.
