# CLAUDE.md – nmrentalsoft

Dieses Dokument beschreibt Projektstruktur, Konventionen und Arbeitsanweisungen für Claude Code in diesem Repository.

## Projektübersicht

**nmrentalsoft** ist eine Laravel 12 Webanwendung auf Basis des offiziellen Livewire Starter Kits.

- **Backend:** PHP 8.2+, Laravel 12, Laravel Fortify (Auth)
- **Frontend:** Livewire 4, Livewire Flux 2 (UI-Komponenten), Tailwind CSS 4
- **Testing:** Pest 3, Mockery
- **Build-Tools:** Vite 7, Laravel Vite Plugin
- **Code-Style:** Laravel Pint (PSR-12-basiert)
- **Datenbank:** SQLite (Entwicklung), konfigurierbar via `.env`

## Verzeichnisstruktur

```
app/
  Actions/          # Single-Action-Klassen (Fortify, Business Logic)
  Concerns/         # PHP Traits
  Http/
    Controllers/    # HTTP Controller
    Actions/        # Action-Klassen für HTTP-Layer
  Livewire/         # Livewire-Komponenten
    Actions/        # Livewire-spezifische Actions
  Models/           # Eloquent Models
  Providers/        # Service Provider
database/
  factories/        # Model Factories
  migrations/       # Datenbank-Migrationen
  seeders/          # Seeders
resources/
  views/
    components/     # Blade-Komponenten
    flux/           # Flux UI Overrides
    layouts/        # Layout-Templates
    pages/          # Seiten-Views
    partials/       # Wiederverwendbare Partials
routes/
  web.php           # Web-Routen
  settings.php      # Settings-Routen
  console.php       # Artisan-Routen
tests/              # Pest-Tests
```

## Wichtige Befehle

```bash
# Entwicklungsserver starten (Server + Queue + Vite gleichzeitig)
composer dev

# Tests ausführen
composer test

# Nur Lint prüfen (ohne Fehler zu beheben)
composer lint:check

# Code automatisch formatieren
composer lint

# Setup (Erstinstallation)
composer setup
```

## Konventionen

### PHP / Laravel
- PHP 8.2+ Features verwenden (readonly properties, enums, fibers wo sinnvoll)
- Eloquent Models in `app/Models/`
- Business Logic in Action-Klassen, nicht in Controllern oder Livewire-Komponenten
- Validierung per Form Request oder Livewire `#[Rule]` Attribute
- Migrations immer rückwärtskompatibel (up/down)

### Livewire / Frontend
- Livewire-Komponenten in `app/Livewire/`
- Flux UI Komponenten bevorzugen (z. B. `<flux:button>`, `<flux:input>`)
- Tailwind CSS 4 für Styling, keine eigenen CSS-Klassen ohne Notwendigkeit
- Blade-Templates in `resources/views/`

### Tests
- Framework: **Pest 3**
- Tests in `tests/Feature/` (Integrationstests) und `tests/Unit/` (Unit-Tests)
- Factories für Test-Datengenerierung nutzen
- Keine echten HTTP-Requests in Unit-Tests

### Code-Stil
- Laravel Pint konfiguriert via `pint.json`
- Vor dem Commit: `composer lint` ausführen
- Keine `var_dump`, `dd`, `dump` im finalen Code

## Umgebung

- `.env` basiert auf `.env.example`
- Datenbank-Verbindung: `DB_CONNECTION=sqlite`, Datei: `database/database.sqlite`
- Queue: synchron in Entwicklung (`QUEUE_CONNECTION=sync`)
- Mail: Log-Treiber in Entwicklung

## Hinweise für Claude Code

- Keine Commits ohne explizite Aufforderung erstellen
- Keine Dateien in `vendor/` oder `node_modules/` ändern
- Immer vorhandene Dateien lesen, bevor Änderungen vorgeschlagen werden
- Keine unnötigen Abstraktionen einführen – so einfach wie möglich
- Sicherheitsrelevante Punkte (SQL Injection, XSS, CSRF) immer beachten
- Bei destruktiven Aktionen (Migrationen löschen, Daten überschreiben) vorher nachfragen
