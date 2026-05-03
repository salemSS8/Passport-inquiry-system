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

## Performance
- **Database Indexing**: Optimized lookups for `national_id` and `tracking_number`.
- **Rate Limiting**: Throttling on inquiry endpoints to prevent scraping and brute-force.
