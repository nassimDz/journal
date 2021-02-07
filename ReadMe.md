# Projet Cloud - 4AL

Pour faire fonctionner le projet: 

1. extraire le code source depuis l'archive. Le code source du site est dans le répértoire *app/*

2. Pour que le site fonctionne correctement, il faut configurer le serveur de base de données et
l'alimenter.
    - Pour configurer la base de données, il suffit de changer les valeurs de configuration
    dans le fichier php/settings.php
    - une fois la base de données installée correctement, il faut l'alimenter en important le fichier
    BDD/projet.sql

3. Afin d'utiliser le service mail trustifi, il faut changer les valeur de **TRUSTIFI_KEY**
et **TRUSTIFI_SECRET** dans *app/WebParts/html/parts/email.php* 


