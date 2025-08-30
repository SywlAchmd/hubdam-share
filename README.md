# Hubdam Share

## 🚀 Features

- **Monolithic architecture** — Backend & frontend in a single repository
- **SSR support** — Server-side rendering enabled for better performance and SEO
- **Modern frontend** — React with Vite, Inertia.js, and TypeScript
- **Powerful backend** — Laravel 11 & Inertia.js support
- **Admin panel** — Built with FilamentPHP for fast CRUD and management
- **Styling** — Tailwind CSS with responsive design
- **Database** — MySQL with migrations, factories, and seeders
- **Testing** — PHPUnit for unit & feature testing
- **Containerized** — Docker + Docker Compose + Nginx for production-ready deployment
- **CI/CD** — GitHub Actions workflows for testing and deployment

## 🛠 Tech Stack

- **Backend:** Laravel 11 (PHP)
- **Frontend:** React + Vite + Inertia.js + TypeScript
- **Admin Panel:** FilamentPHP
- **Database:** MySQL
- **Styling:** Tailwind CSS
- **Server:** Nginx
- **Containerization:** Docker & Docker Compose
- **Testing:** PHPUnit
- **CI/CD:** GitHub Actions

## System Architecture

### Backend

| Folder      | Purpose                                                                                 |
|-------------|-----------------------------------------------------------------------------------------|
| app/        | Main backend source code (Controllers, Models, Resources, Helpers, Filament admin panel, etc.) |
| bootstrap/  | Laravel bootstrap files and initial configuration                                       |
| config/     | Application configuration files (database, mail, queue, etc.)                           |
| database/   | Database migrations, seeders, and factories                                             |
| public/     | Publicly accessible static files (images, css, js, favicon, etc.)                       |
| routes/     | Application route definitions (web, api, console, auth)                                 |
| storage/    | Generated files (logs, cache, uploads, etc.)                                            |
| tests/      | Unit & feature tests for the application                                                |
| docker/     | Docker configuration for development & deployment                                       |
| .github/    | CI/CD workflows (GitHub Actions)                                                        |

### Frontend (`resources/`)

| Folder         | Purpose                                                                                   |
|----------------|------------------------------------------------------------------------------------------|
| css/           | Global and custom CSS, Tailwind configuration                                            |
| js/            | Main frontend source code (React + TypeScript)                                           |
| js/components/ | Reusable UI components (atoms, molecules, organisms, pages, layouts, etc.)               |
| js/constants/  | Constants for UI, layouts, and components                                                |
| js/hooks/      | Custom React hooks                                                                       |
| js/layouts/    | Layout components (Navbar, Footer, Hero, etc.)                                           |
| js/pages/      | Page-level React components               |
| js/types/      | TypeScript type definitions                                                              |
| js/utils/      | Utility/helper functions                                                                 |
