# 🐺 Loup-Garou TDD

[![PHP Version](https://img.shields.io/badge/php-^8.0-blue)](https://php.net)
[![PHPUnit](https://img.shields.io/badge/phpunit-^9.5-green)](https://phpunit.de)

> Implémentation du jeu du Loup-Garou en PHP 8 en utilisant le **Test Driven Development (TDD)**

Ce projet est inspiré de [PhpUnit_mythicalCreatures](https://github.com/bu7ch/PhpUnit_mythicalCreatures) et suit une approche pédagogique progressive pour maîtriser PHPUnit et les bonnes pratiques de développement.

---

## 📋 Prérequis

- PHP 8.0 ou supérieur
- [Composer](https://getcomposer.org/)
- Extension PHP : `mbstring`

---

## 🚀 Installation

```bash
# Cloner le repository
git clone https://github.com/votre-nom/loup-garou-tdd.git
cd loup-garou-tdd

# Installer les dépendances
composer install
```

---

## 🧪 Exécution des tests

### Tous les tests
```bash
composer test
# ou
./vendor/bin/phpunit
```

### Tests par phase
```bash
# Phase 1 : Fondations (Player, PlayerCollection, Role)
./vendor/bin/phpunit tests/Players
./vendor/bin/phpunit tests/Roles

# Tests spécifiques
./vendor/bin/phpunit tests/Players/PlayerTest.php
./vendor/bin/phpunit --filter testPlayerCanBeCreatedWithNameAndRole
```

### Avec couverture de code
```bash
composer test:coverage
# Rapport HTML généré dans coverage-html/index.html
```

---

## 📚 Structure du projet

```
loup-garou-tdd/
├── src/                          # Code source
│   ├── Roles/                    # Rôles du jeu
│   │   ├── Role.php              # Interface commune
│   │   ├── Villageois.php        # Villageois simple
│   │   └── LoupGarou.php         # Loup-garou
│   └── Players/                  # Gestion des joueurs
│       ├── Player.php            # Entité joueur
│       └── PlayerCollection.php  # Collection de joueurs
├── tests/                        # Tests PHPUnit
│   ├── Roles/
│   │   └── RoleTest.php
│   └── Players/
│       ├── PlayerTest.php
│       └── PlayerCollectionTest.php
├── composer.json
├── phpunit.xml
└── README.md
```

---

## 🎯 Phases de développement

### ✅ Phase 1 : Fondations
**Objectif** : Modéliser les entités de base du jeu

| Composant | Description | Tests |
|-----------|-------------|-------|
| `Role` | Interface pour tous les rôles | `RoleTest` |
| `Villageois` | Rôle de base, équipe village | `RoleTest` |
| `LoupGarou` | Rôle antagoniste, équipe loups | `RoleTest` |
| `Player` | Joueur avec état (vivant/mort, protection, amour) | `PlayerTest` |
| `PlayerCollection` | Gestion de liste de joueurs (filtres, recherche) | `PlayerCollectionTest` |

**Concepts PHP 8 utilisés :**
- Typage strict (`declare(strict_types=1)`)
- Types de retour (`: string`, `: bool`, `: void`)
- Types union (`?Player`)
- Fonctions fléchées (`fn() => ...`)
- Interfaces

---

### 🚧 Phase 2 : Mécaniques de jeu *(à venir)*
- `Game` : Orchestration de la partie
- `Round` : Gestion des tours (jour/nuit)
- `Vote` : Système de vote pour éliminer
- `WinConditions` : Vérification des victoires

---

### 🚧 Phase 3 : Rôles spéciaux *(à venir)*
- `Voyante` : Détecte les loups
- `Sorciere` : Potions de vie/mort
- `Chasseur` : Dernière action avant de mourir
- `Cupidon` : Lie deux amoureux
- `PetiteFille` : Espionne les loups

---

## 🔄 Cycle TDD

Ce projet suit strictement le cycle **Red-Green-Refactor** :

1. **🔴 Red** : Écrire un test qui échoue
   ```bash
   ./vendor/bin/phpunit --filter testNomDuTest
   # Expected: FAILURES!
   ```

2. **🟢 Green** : Écrire le minimum de code pour passer le test
   ```php
   // Implémentation la plus simple possible
   public function getName(): string { return 'Villageois'; }
   ```

3. **🔵 Refactor** : Améliorer le code sans casser les tests
   - Extraire des méthodes
   - Renommer des variables
   - Optimiser les performances

---

## 📝 Exemple d'utilisation

```php
<?php
use App\Players\Player;
use App\Players\PlayerCollection;
use App\Roles\Villageois;
use App\Roles\LoupGarou;

// Créer des joueurs
$alice = new Player('Alice', new Villageois());
$bob = new Player('Bob', new LoupGarou());
$charlie = new Player('Charlie', new Villageois());

// Gérer une collection
$players = new PlayerCollection([$alice, $bob, $charlie]);

// Filtrer les vivants
$alive = $players->getAlive();

// Tuer un joueur (protégé par les règles métier)
try {
    $alice->kill();
    echo "$alice est éliminé(e) !";
} catch (RuntimeException $e) {
    echo "Impossible : " . $e->getMessage();
}
```

---

## 🎓 Règles du jeu (référence)

### Objectifs
- **Villageois** : Éliminer tous les Loups-Garous
- **Loups-Garous** : Éliminer tous les Villageois ou atteindre l'égalité

### Déroulement
1. **Nuit** : Les Loups-Garous choisissent une victime
2. **Jour** : Les joueurs votent pour éliminer un suspect
3. Répéter jusqu'à ce qu'une équipe gagne

### Rôles spéciaux (futur)
- **Voyante** : Chaque nuit, découvre le rôle d'un joueur
- **Sorcière** : Possède une potion de vie et une potion de mort
- **Chasseur** : En mourant, élimine un joueur de son choix
- **Cupidon** : La première nuit, lie deux amoureux (gagnent ensemble ou meurent ensemble)

---

## 🤝 Contribution

Les contributions sont les bienvenues ! Suivez le processus TDD :

1. Fork le projet
2. Créez une branche (`git checkout -b feature/nouveau-role`)
3. Écrivez les tests d'abord
4. Implémentez la solution
5. Refactorisez
6. Commit (`git commit -m 'Ajoute le role Sorciere'`)
7. Push (`git push origin feature/nouveau-role`)
8. Ouvrez une Pull Request

---

## 📖 Ressources

- [Documentation PHPUnit](https://phpunit.readthedocs.io/)
- [PHP 8 Nouveautés](https://www.php.net/releases/8.0/en.php)
- [TDD by Example - Kent Beck](https://www.oreilly.com/library/view/test-driven-development/0321146530/)



