# Passport Inquiry System (نظام استعلام الجوازات)

A modern, responsive, and secure system for managing passport applications and providing real-time tracking for citizens.

## 🚀 Key Features

- **Mobile-First Design**: Fully responsive UI/UX designed for mobile accessibility first, then scaling to desktop.
- **Dual Tracking System**: 
    - **Citizen Inquiry**: Secure status checks using a private **Serial Number**.
    - **Admin Management**: Internal tracking and processing using a unique **Tracking Number**.
- **Interactive Timeline**: Visual progress tracking for applicants with real-time status updates and timestamps.
- **Modern Admin Dashboard**: Ultra-slim, professional interface for passport office employees and administrators.
- **API-First Architecture**: Robust V1 API supporting future mobile (Flutter) integration.
- **RTL Support**: Native Arabic support with optimized Cairo typography.

## 🛠 Technology Stack

- **Backend**: Laravel 13 (PHP 8.4)
- **Frontend**: Blade, Vanilla JS, Custom CSS (Figma Token-based)
- **Database**: MySQL 8.0
- **Security**: Laravel Sanctum (API), Custom Audit Middleware
- **Testing**: Pest PHP

## 📦 Installation & Setup

1. **Clone the repository**:
   ```bash
   git clone [repository-url]
   ```

2. **Install dependencies**:
   ```bash
   composer install
   npm install
   ```

3. **Environment Setup**:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Database Migration & Seeding**:
   ```bash
   php artisan migrate --seed
   ```

5. **Build Assets**:
   ```bash
   npm run build
   ```

6. **Serve the Application**:
   ```bash
   php artisan serve
   ```

## 📄 Documentation

For detailed technical specifications, please refer to the `docs/` directory:
- [System Architecture](docs/project-specs/system_architecture.md)
- [Workflow Roadmap](docs/project-specs/workflow_roadmap.md)

## ⚖️ License

Private Project - All Rights Reserved.
