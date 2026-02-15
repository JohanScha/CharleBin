#### Compte-rendu de Johan Schaeffer, Qualité de développement

## Git 
### Slide 14 -- #1 - Récupération et installation de PrivateBin + utilisation de make 

Mes manipulations :

 1. Récupérer le code de PrivateBin avec git clone
 2. Installer les dépendances avec make install
 3. Lancer PrivateBin avec make start
 4. Créer quelques secrets
 5. Arrêter le serveur
 6. Regarder les modifications détectées par git
 7. Aucune modification detecté car les fichiers contenant les secrets se trouve dans le .gitignore 
 
Commande git :

```bash
git clone git@github.com:floo51/PrivateBin.git
make install
make start
# Après création de secrets et arrêt du serveur
git status
```


### Slide 18 -- #2 - Création de branches et commits distincts


Mes manipulations :

 1. Créer une nouvelle branche
 2. Modifier le fichier lib/Configuration.php pour changer languagedefault par fr
 3. Modifier le fichier lib/Configuration.php pour ajouter une nouvelle option d'expiration '30min' => 1800
 4. Effectuer 2 commits distincts à l'aide de la commande git add -p
 5. Revenir à la branche main avec git checkout main
 6. Observer l'état du working directory : les modifications ne sont plus visibles car on est revenu sur main
 
Il y avait du code  :

```bash
git switch modification
# Modifications dans lib/Configuration.php
git add -p lib/Configuration.php
git commit -m "message du premier commit"
git add -p lib/Configuration.php
git commit -m "message du second commit"
git checkout main
git status
```

---

### Slide 20 -- #3 - Fusion de branches avec merge

Mes manipulations :

 1. Intégrer les modifications de code de l'exercice précédent dans main avec git merge
 2. Inspecter la branche main pour vérifier que les commits sont présents
 3. Constater que la branche créée existe toujours
 4. Décider de supprimer la branche fusionnée car elle n'est plus nécessaire
 
Il y avait du code  :

```bash
git checkout main
git merge modification
git log
git branch
git branch -d modification
```

---

### Slide 24 -- #4 - Gestion des conflits


Mes manipulations :

 1. Créer une nouvelle branche change-default-expiration à partir de main
 2. Sur change-default-expiration : modifier lib/Configuration.php pour changer le temps d'expiration par défaut à un mois
 3. Sur change-default-expiration : effectuer un commit
 4. Revenir sur main
 5. Sur main : modifier lib/Configuration.php pour changer le temps d'expiration par défaut à un jour
 6. Sur main : effectuer un commit
 7. Essayer de merger change-default-expiration dans main
 
Il y avait du code  :

```bash
git checkout main
git switch -C change-default-expiration
# Modifications : expiration = 1 mois
git add lib/Configuration.php
git commit -m
git checkout main
# Modifications : expiration = 1 jour
git add lib/Configuration.php
git commit -m 
git merge change-default-expiration
# CONFLICT
```

---

### Slide 32 -- #5 - Débugger avec git bisect pour trouver un commit problématique (dichotomie)

Mes manipulations :

 1. Récupérer la branche rename-to-charlebin
 2. Lancer le projet avec make start et constater que la page s'appelle CharleBin (bad)
 3. Lancer git bisect start
 4. Indiquer bad pour le commit actuel
 5. Indiquer good pour un commit où le bug n'existait pas
 6. Bisect positionne sur un commit spécifique
 7. Recharger la page pour voir si le titre est CharleBin (bad) ou PrivateBin (good)
 8. Indiquer bad ou good selon le résultat
 9. Répéter ça jusqu'à trouver le commit problématique
 
Il y avait du code  :

```bash
git checkout rename-to-charlebin
make start
# Constater que le titre est CharleBin
git bisect start
git bisect bad
git bisect good [ref]
# Git positionne sur un commit
make start
# Tester : CharleBin = bad, PrivateBin = good
git bisect bad  # ou git bisect good
# Répéter jusqu'à trouver le commit
git bisect reset
```

---

### Slide 33 -- #6 - git bisect automatisé pourêtre plus rapide 

Mes manipulations :

 1. Utiliser la commande make test qui vérifie le titre de la page
 2. make test échoue si le titre est différent de PrivateBin
 3. Trouver le commit responsable avec git bisect run et make test
 4. Vérifier qu'il s'agit du même commit qu'à l'exercice précédent
 5. La recherche est beaucoup plus rapide car automatisée
 
Il y avait du code :

```bash
git bisect start
git bisect bad
git bisect good [ref]
git bisect run make test
# Git trouve automatiquement le commit
git bisect reset
```

---

## Partie 2 - PR et Review

### Slide 5 -- # 1 - Configuration SSH et création repository

Mes manipulations :

 1. Créer un repository sur GitHub nommé CharleBin
 2. Brancher le repository PrivateBin local à ce nouveau repository github avec git remote set-url
 3. Envoyer tout le contenu de la branche main locale sur github avec git push
 
Il y avait du code  :

```bash
# Créer le repository CharleBin sur mon GitHub
git remote set-url origin git@github.com:JohanScha/CharleBin.git
git push -u origin main
```

---

### Slide 9 -- #2 - Récupération des modifications distantes

Mes manipulations :

 1. Via l'interface github, modifier le titre de la page web de PrivateBin vers CharleBin dans le fichier lib/Configuration.php
 2. Vérifier en local : le changement fait sur github n'est pas présent dans le repository local
 3. Utiliser git fetch pour récupérer l'état du repository distant sans modifier le working directory
 4. Visualiser les changements avec gitk --all
 5. Rapatrier les modifications avec git pull
 
Il y avait du code  :

```bash
# Après modification sur GitHub
git status
# Ne montre pas les changements distants
git fetch origin
gitk --all #Voir toutes les branches avec --all

git pull origin main
```

---

### Slide 14 -- #3 - Ouverture d'une Pull Request

Mes manipulations :

 1. S'assurer d'être sur main avec git status
 2. Créer une nouvelle branche pour supprimer le footer
 3. Développer : supprimer le footer de PrivateBin
 4. Créer un commit
 5. Pousser sur GitHub avec git push -u origin nom-de-la-branche
 6. Créer une pull request sur GitHub
 
Il y avait du code  :

```bash
git status
git switch -C supressionfooter
# Supprimer le footer dans les fichiers appropriés
git add .
git commit -m 
git push -u origin supressionfooter
# Aller sur GitHub pour créer la Pull Request
```

---

### Slide 23 -- #4 - Mise en place de la documentation

Mes manipulations :

 1. Créer un README.md qui sera un compte rendu expliqué de ce que j'ai fait durant les séances 
 2. Créer un CONTRIBUTING.md qui explique toutes les règles de contribution
 3. Recréer la PR de l'exercice 3 en prenant en compte ces nouvelles règles
 

## Partie 3 - Linters

### Slide 8 -- #1 - Installation et configuration des linters

Mes manipulations :

1. Installer et tester les 3 linters sur le projet (PHP Lint, PHP Code Sniffer, PHP Mess Detector)
2. Configurer les règles des linters avec les règles qui me paraissent les plus intéressantes. 
3. Créer une nouvelle target `lint` dans le Makefile pour pouvoir lancer les 3 outils avec `make lint`
4. Lancer `make lint` pour tester l’ensemble
5. Corriger au moins 5 erreurs différentes 
6. Commit et push les modifications sur GitHub (utilisant les parties précédentes pour faire des bons commits)

Il y avait du code  :

```bash
composer require --dev "squizlabs/php_codesniffer=3.*"
composer require --dev "phpmd/phpmd=@stable"

# Mon target dans le makefile 
lint:
        echo "=== PHP Lint ==="
        find . -type f -name "*.php" -not -path "./vendor/*" -exec php -l {} \;

        echo "=== PHP CodeSniffer ==="
        ./vendor/bin/phpcs --extensions=php ./lib/

        echo "=== PHP Mess Detector ==="
        ./vendor/bin/phpmd ./lib ansi codesize,unusedcode,naming
```

---

### Slide 14 -- #2 - Mise en place du pre-commit hook

Mes manipulations :

1. Installer un pre commit hook 
2. Configurer le hook pour utiliser PHP CS Fixer afin de corriger automatiquement un maximum d’erreurs
3. Ajouter automatiquement au staging area les fichiers modifiés par PHP CS Fixer
4. Utiliser PHP Mess Detector pour interdire le commit s’il reste des erreurs
5. Commit les modifications faites dans : .git/hooks/pre-commit.sample
6. Vérifier s’il est possible d’ignorer le hook  

Le code pour ignorer le commit :
```bash 
git commit --no-verify
```

---

### Slide 18 -- #3 - GitHub Action de lint et protection de main

Mes manipulations :

1. Créer une GitHub Action de lint dans `.github/workflows/`
2. Configurer l’action pour lancer les linters à chaque Pull Request
3. Vérifier que la PR ne peut pas être mergée si des erreurs de lint sont présentes
4. Protéger la branche `main` dans les paramètres GitHub
5. Empêcher les commits directs sur `main`
6. Forcer le passage par Pull Request pour intégrer du code

---

## Partie 4 - Dev Tools

### Slide 7 -- #1 - Copilot 

Mes manipulations :

1. Activer Copilot dans VS Code
2. Ouvrir le fichier `lib/Filter.php`
3. Réécrire la méthode `formatHumanReadableTime` avec Copilot, en changeant la signature : la méthode prend maintenant 2 arguments (une valeur entière + une unité en chaîne de caractères)
4. Si Copilot proposait une méthode similaire à l’existante, vider temporairement la classe / la méthode et réessayer 
5. Explorer plusieurs suggestions de Copilot avec `Ctrl + Enter`
6. Comparer les propositions (lisibilité, cas limites, cohérence avec le code existant) et critiquer le résultat retenu 

**Critique:**
Copilot propose vite une solution qui fonctionne et qui est facile à lire, ce qui fait gagner du temps
Mais il ne pense pas toujours aux cas particuliers ou à la cohérence avec le reste du code
Il faut donc relire et adapter la solution avant de l’utiliser

---

# Slide 10 -- #2 - Retrouver un mot de passe “perdu”

Dans un premier temps, j’ai entré un mot de passe au hasard dans le champ `password` de PrivateBin.

Ensuite, j’ai ouvert les DevTools du navigateur (F12).
Je suis allé dans l’onglet **Elements** afin d’inspecter le code HTML de la page.
Le mot de passe tapé ne s’affiche pas directement dans le code HTML, mais il est stocké dans la propriété value de cet élément dans le DOM.
Il y a deux moyens de le récupérer sans modifier l’apparence de la page :
Dans l’onglet Console :
```js
document.getElementById("passwordinput").value
```
En sélectionnant l’élément `<input>` dans l’onglet Elements, puis en consultant sa propriété value dans le panneau “Properties”.

Le mot de passe est donc accessible dans la propriété value de l’élément DOM `<input id="passwordinput">`, tant que la page est ouverte.

---

## Vérification du chiffrement côté client

PrivateBin est censé chiffrer le message côté client avant envoi.

Mes manipulations : 
- J’ai ouvert les DevTools puis je suis allé dans l’onglet **Network**.
- Ensuite, j’ai envoyé un nouveau message (paste).
- Une requête **POST** est alors apparue dans la liste des requêtes réseau.
- J’ai cliqué sur cette requête, puis j’ai ouvert la section **Payload**.
- J’ai vérifié le contenu des données envoyées.
- Le texte de mon message n’apparaissait pas clairement.
- Les données étaient sous une forme non lisible.

Cela prouve que le message est bien chiffré côté client avant d’être envoyé au serveur.

---

## Vérification du stockage local

Pour vérifier que PrivateBin ne stocke rien sur mon navigateur, je suis allé dans l’onglet **Application** des DevTools.

J’ai vérifié :

* **Cookies**
* **Local Storage**
* **Session Storage**
* **IndexedDB**
* **Cache Storage**

Dans chacune de ces sections, j’ai cherché des données liées au message que j’avais envoyé ou au mot de passe saisi.
Je n’ai trouvé aucune donnée correspondant au message ou au mot de passe.
Cela prouve que PrivateBin ne stocke pas le contenu du message ni le mot de passe dans le navigateur.

---

## Partie Tests – Cypress (e2e) + test unitaires sur NetVOD (SAE)
### Slide 13 -- #1 – Création d’un test Cypress sur CharleBin

Mes manipulations :

1. Vérifier que Node.js est bien installé (version 18+)
2. Installer Cypress dans le projet
3. Lancer Cypress en mode interface graphique
4. Créer un nouveau test dans le dossier `cypress/e2e`
5. Écrire un test qui :
   * crée un paste avec une chaîne de caractères et un mot de passe
   * récupère l’URL du paste 
   * charge cette URL
   * saisit le mot de passe
   * vérifie que le message affiché correspond exactement à celui saisi
6. Lancer le test et vérifier qu’il passe correctement
7. Push les modifications sur GitHub

Il y avait du code :

```bash
node -v
npx cypress install
npx cypress open
npx cypress run 
```

Test Cypress utilisé + dossier directement dans le rendu:

```javascript
describe("CharleBin", () => {
  it("créé paste mdp, charge URL, saisit mdp, vérifie message", () => {
    const message = "Test Cypress " + Date.now();
    const mdp = "1234";

    cy.visit("http://localhost:8080");
    cy.contains("Nouveau").click();
    cy.get("textarea").first().type(message);
    cy.get("input[placeholder*='recommand' i]").type(mdp);
    cy.contains("Envoyer").click();

    cy.location("href").then((url) => {
      cy.visit(url);
      cy.get('input[placeholder*="Entrez le mot de passe"]').first().type(mdp, {force: true});  // Saisit MDP
      cy.contains("Déchiffrer").click({ force: true });
      cy.contains(message).should("be.visible");  // Vérifie après saisie
    });
  });
});
```

---

## Tests unitaires – SAE NetVOD

Après avoir réalisé des tests sur CharleBin, j’ai effectué des tests unitaires sur la SAE **NetVOD** pour mieux comprendre comment tester un projet Web en PHP.

J’ai donc créé un dossier `tests/` dans le projet et ajouté deux fichiers de test : 
- un pour le **Repository** 
- un pour les **Actions**.
- 
J’ai ensuite écrit plusieurs tests unitaires.

Au total, j’ai fait **quatre tests côté Repository** et **quatre tests côté Actions** (home, catalogue, profile et logout).

J'ai rencontré quelques problèmes, notamment avec la gestion des sessions, des dépendances et de la base de données lors de l’exécution des tests car on utilisait pas la base de donnée originale, ce qui ma demandé plusieurs ajustements et de recherches de solutions sur internet avant de pouvoir lancer les tests et voir qu'ils fonctionnent.

La commande pour lancer les tests est : 
```bash
# Dans le dossier racine NetVOD 
# Sur windows 
.\vendor\bin\phpunit tests\TestActions.php
.\vendor\bin\phpunit tests\TestRepository.php

# Sur Linux
./vendor/bin/phpunit tests/TestActions.php
./vendor/bin/phpunit tests/TestRepository.php

```

Je fournis dans le rendu les deux fichiers de test présents dans le dossier `tests/`.

---

## Conclusion

Durant ces séances, j’ai pu découvrir et pratiquer plusieurs compétences importantes pour le développement, notamment l’utilisation de Git, le travail avec les Pull Requests, l’usage des linters pour améliorer la qualité du code, ainsi que la mise en place de tests unitaires et de tests end-to-end.

J’ai surtout apprécié le côté pratique, qui m’a permis d’appliquer directement ce que nous avions vu en cours. J’ai également rencontré quelques difficultés, notamment lors de la configuration des outils et de la mise en place des tests, mais cela m’a permis de mieux comprendre leur fonctionnement en cherchant des solutions par moi-même.

Ces expériences m’ont aidé à mieux comprendre l’intérêt de ces outils dans un vrai projet, et je pense qu’elles me seront utiles pour la suite de mes projets et de ma formation.

---
