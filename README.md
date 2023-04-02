# Test PHP natif

## Environnement

Ce projet fonctionne au sein d'un environnement PHP 8.

Pour le développement, j'ai utilisé laragon & PHP 8.1.10

Placer l'arboréscence dans le dossier www de votre serveur web ou dans un répertoure où l'exécutable PHP est accessible.

## Format de données d'entrée choisi pour les cartes d'embarquement 

Chaîne de caractères contenant un tableau json d'éléments json (voir resource/boarding-template.json).

## Fichiers

* **api/ComputePath.php :** Classe servant d'API interne, pour l'utiliser, il suffit d'appeler sa méthode exécute statiquement.
* **config/autoload.php :** Fichier servant à gérer le chargement automatique de classes pour les points d'entrée.
* **model/BoardingCard.php :** Fichier servant à représenter une carte d'embarquement, avec quelques méthodes usuelles.
* **resource/boarding-data.json :** Fichier contenant la représentation des cartes d'embarquement de l'exercice au format choisi.
* **resource/boarding-template.json :** Voir plus haut.
* **service/ComputePathService :** Service contenant les méthodes de tri des cartes et d'affichage final en fonction d'une liste de cartes.
* **tests/unit/ComputePathServiceTests.php :** Classe de tests unitaires pour la Classe ComputePathService. 
* **tests/unit/ComputePathTests.php :** Classe de tests unitaires pour la Classe ComputePath. 
* **tests/TestClass.php :** Classe abstraite de tests unitaires contenant les différentes méthodes usuelles pour réaliser des tests unitaires (asserts). 
* **index.php :** Point d'entrée non utilisé dans le cadre de cet exercice. 
* **README.md :** Ce fichier. 
* **test_runner.php :** Point d'entrée permettant de lancer les tests unitaires de cet exercice. 

## Tester l'application

Aller à la racine du projet (test-mobireport) et lancer la commande suivante :
```
php test_runner.php
```
En cas de succès, la sortie suivante doit apparaître :
```
begin tests                                     
                                                
test class ComputePathServiceTests              
                                                
test method testSortBoardingCards OK            
test method testSortBoardingCardsEmpty OK       
test method testSortBoardingCardsException OK   
test method testWritePath OK                    
test method testWritePathEmpty OK               
                                                
test class ComputePathTests                     
                                                
test method testComputeEmpty OK                 
test method testComputeBadDecodedFirstLayer OK  
test method testComputeBadDecodedSecondLayer OK 
test method testComputeBadArray OK              
test method testComputeValidateError OK         
test method testCompute OK                      
                                                
end tests                                       
```