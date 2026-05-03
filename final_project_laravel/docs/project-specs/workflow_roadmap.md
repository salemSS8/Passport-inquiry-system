# Workflow Roadmap

## Backend (Laravel) - Phase 2
- [ ] **Data Export Service**: Implementation of PDF/Excel exports for monthly branch reports.
- [ ] **Advanced Searching**: Integration of **Laravel Scout** with Algolia or Meilisearch for ultra-fast fuzzy search.
- [ ] **Real-time Updates**: Integration of **Laravel Reverb** (Pusher-compatible) to notify the Admin Dashboard of new applications in real-time.
- [ ] **API Versioning**: Solidify V2 plans for multi-lingual support (Arabic/English).

## Mobile (Flutter) - Phase 2
- [ ] **Authentication Flow**: Implement Sanctum-compatible login and secure token storage using `flutter_secure_storage`.
- [ ] **Status Tracking UI**: Interactive timeline view using the data from `StatusUpdateResource`.
- [ ] **Push Notifications**: Integration with Firebase Cloud Messaging (FCM) to trigger from Laravel listeners.
- [ ] **Offline Mode**: Local caching of inquiry results using `Hive` or `sqflite`.

## DevOps & Deployment
- [ ] **CI/CD Pipeline**: Automated Pest testing on GitHub Actions.
- [ ] **Dockerization**: Containerization of the environment for consistent development across teams.
