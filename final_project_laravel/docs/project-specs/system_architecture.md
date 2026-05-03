# System Architecture Specification

## Overview
The Passport Inquiry System is built using a modern, decoupled architecture designed for high scalability, security, and maintainability. It utilizes Laravel 13 as the backend core and adheres to the **Action Pattern** and **Event-Driven Architecture**.

## Core Patterns

### 1. Action Pattern (Single Responsibility)
We moved away from bloated Service Classes to focused **Actions**. Each business process is encapsulated in a single class:
- `CreateApplicationAction`: Handles the initial entry of a passport application.
- `UpdateStatusAction`: Manages state transitions.
- `CancelApplicationAction`: Handles application revocation.
- `ArchiveApplicationAction`: Manages data lifecycle for completed records.

**Benefits:**
- **Testability**: Each action can be unit-tested in isolation.
- **SRP Compliance**: Changes to "Cancellation" logic don't risk breaking "Creation" logic.

### 2. Event-Driven side Effects
Business logic is decoupled from side effects (logging, notifications) via **Laravel Events**:
- **Flow:** Action Executes -> Event Dispatched -> Multiple Listeners Respond.
- **Listeners:**
    - `LogAuditTrail`: Records history for security auditing.
    - `SendStatusNotification`: Communicates with citizens via Mock SMS/Email.

## Security Layer
- **Hybrid Auth**: Session-based for Web Admin; Sanctum Token-based for Mobile API.
- **Custom Middleware**: `EnsureSensitiveActionAuthorized` provides a centralized security gate for administrative actions, logging all access attempts.

## Frontend Architecture
The system follows a **Mobile-First Responsive Design** strategy, ensuring full compatibility from small smartphones to ultra-wide desktops.

### 1. Design System
- **Styling**: Vanilla CSS utilizing a custom Figma-inspired token system (e.g., `--primary`, `--accent`, `--space-md`).
- **Typography**: Optimized for RTL (Arabic) using 'Cairo' and 'Noto Sans Arabic' for high readability.
- **Components**: Glassmorphic elements, refined border-radii (12px standard), and subtle micro-animations for a premium feel.

### 2. Layout Strategy
- **Admin Layout**: Collapsible sidebar with a horizontal profile section and dedicated logout isolation.
- **Citizen Layout**: A clean, sidebar-free interface focused on search accessibility.
- **RTL Support**: Native RTL implementation using logical properties (`margin-inline`, `padding-block`) and `flex-direction: row-reverse`.

## Data & Search Logic

### 1. Dual-Track Search
- **Serial Number**: A public-facing identifier (`SER-XXXX`) used by citizens to check status without exposing sensitive tracking data.
- **Tracking Number**: An internal administrative identifier (`TRK-XXXX`) used by staff for backend processing and auditing.

### 2. Timeline Status System
The system maps English database states (`pending`, `processing`, `ready`, `collected`) to localized Arabic timeline nodes, providing citizens with a clear, date-stamped progress history.

## Security & Performance
- **Database Indexing**: Optimized lookups for `national_id`, `serial_number`, and `tracking_number`.
- **Rate Limiting**: Throttling on inquiry endpoints (`throttle:inquiry`) to prevent scraping.
- **Access Control**: Strict separation between Public Inquiry routes and Authenticated Admin routes.
