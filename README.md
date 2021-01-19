# S3B_WishList_AMBELLOUIS_CRIVELLI_GRONDIN_LOESEL_SAGET
Projet WishList.app PHP @IUT-NC 2020

## Installation

Utilisez [composer](https://getcomposer.org/) pour installer WishList.

```bash
git clone https://github.com/andrea-crivelli/S3B_WishList_AMBELLOUIS_CRIVELLI_GRONDIN_LOESEL_SAGET.git
cd S3B_WishList_AMBELLOUIS_CRIVELLI_GRONDIN_LOESEL_SAGET
composer install
```

Il faut créer un fichier de configuration pour la base de donnée nommé **db.config.ini** dans le répertoire wishlist/conf (il faut créer le répertoire).
En insérant:

| Paramètre     | Valeur d'exemple | Description               |
| :------------:|:----------------:|:-------------------------:|
| driver        | mysql            | Driver de votre SGBD      |
| username      | root             | Nom d'user de votre BDD   |
| password      | root             | Mot de passe de votre BDD |
| host          | localhost        | Hôte de votre BDD         |
| database      | wish             | Nom de votre BDD          |



## Utilisation

Lancez un serveur XAMP, importez le fichier de création de la BDD [document/donnees/wishlist.sql](document/donnees/wishlist.sql) et connectez-vous sur le site.

## Fonctionnalités

Pour voir plus en détail --> [Excel](document/TableauDeBord.ods)

### Participant

- [x] *Afficher une liste de souhaits* 
- [x] *Afficher un item d'une liste* 
- [x] *Réserver un item* 
- [ ] *Ajouter un message avec sa réservation* 
- [x] *Ajouter un message sur une liste* 

### Créateur
- [x] *Créer une liste* 
- [x] *Modifier les informations générales d'une de ses listes* 
- [x] *Ajouter des items* 
- [x] *Modifier un item* 
- [x] *Supprimer un item* 
- [ ] *Rajouter une image à un item* 
- [ ] *Modifier une image à un item* 
- [ ] *Supprimer une image d'un item* 
- [x] *Partager une liste* 
- [ ] *Consulter les réservations d'une de ses listes avant échéance* 
- [ ] *Consulter les réservations et messages d'une de ses listes après échéance* 

### Extensions
- [ ] *Créer un compte* 
- [ ] *S'authentifier* 
- [ ] *Modifier son compte*
- [ ] *Rendre une liste publique* 
- [ ] *Afficher les listes de souhaits publiques* 
- [ ] *Créer une cagnotte sur un item*
- [ ] *Participer à une cagnotte*
- [ ] *Uploader une image*
- [ ] *Créer un compte participant*
- [ ] *Afficher la liste des créateurs*
- [ ] *Supprimer son compte*
- [ ] *Joindre les listes à son compte*



