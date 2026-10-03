# DEC/DECFP — Examination Management System

A web-based examination management system designed to manage professional examinations in Senegal.

The application centralizes examination centers, examinations, sessions, candidates, competencies, assessments, scores, results, official documents, users, roles and audit operations.

## 🎯 Project Overview

DEC/DECFP provides a centralized platform for managing the different stages of a professional examination process:

* Examination center management
* Examination and session management
* Candidate registration and monitoring
* Candidate document management
* Competency and assessment management
* Score entry and validation
* Result calculation and management
* Official examination reports
* User and role management
* Audit and activity tracking
* Role-based dashboards
* PDF and Excel exports

The application is designed for organizations involved in the administration and supervision of professional examinations.

## 👥 User Roles

The system is designed around several levels of access:

| Role                       | Main responsibilities                                    |
| -------------------------- | -------------------------------------------------------- |
| **Super Administrator**    | Global system administration                             |
| **Ministry / DECFP**       | National examination management and supervision          |
| **Regional Administrator** | Regional supervision of examination centers              |
| **Center Administrator**   | Management of candidates, sessions and center activities |
| **Jury**                   | Candidate assessment and score management                |
| **Candidate**              | Access to personal examination information and results   |

Access to data and functionality is controlled according to user roles and permissions.

## 🚀 Main Features

### Examination Centers

* Create, update and manage examination centers
* Center identification and contact information
* Region and location management
* Active/inactive center status
* Examination and session association

### Examinations

* Examination creation and management
* Examination code, title and description
* Minimum score configuration
* Examination session management
* Initial and resit sessions
* Examination dates and configuration

### Competencies & Weighting

* Create and manage examination competencies
* Associate competencies with examinations
* Configure competency weighting
* Manage CCP assessment weighting

### Candidates

* Candidate registration
* Personal information management
* Examination and session assignment
* Candidate status management
* Candidate document management
* Candidate listing by examination center
* Import and export capabilities

### Scores

* Score entry by competency
* Candidate/session score management
* Score validation workflow
* Validation tracking
* Controlled access to score operations

### Results

* Candidate result management
* Total score calculation
* Decision management
* Mention management
* Competency score breakdown
* Result consultation
* Result export

### Official Documents

* Examination session documents
* Candidate documents
* Official examination reports
* PDF generation
* Document download
* PV management
* Signature management

### Dashboards & Statistics

Role-based dashboards provide access to information according to the user's responsibilities.

The system is designed to provide statistics such as:

* Number of candidates per session
* Examination session statistics
* Result distribution
* Mention distribution
* Examination center statistics

### Audit

The application includes an audit mechanism designed to track important administrative actions, including:

* Candidate creation and modification
* Examination modifications
* Session modifications
* Score operations
* User actions

Audit information can include:

* User
* Action
* Entity
* Changes
* IP address
* User agent
* Date and time

### Notifications

The architecture provides support for notification workflows such as:

* Result publication
* Score validation
* Candidate registration
* Administrative notifications

Email and external messaging integrations can be added according to deployment requirements.

## 🏗️ Architecture

The application follows a Laravel MVC architecture.

```text
┌─────────────────────────────────────┐
│             Web Browser             │
└──────────────────┬──────────────────┘
                   │
                   ▼
┌─────────────────────────────────────┐
│        Laravel Application          │
│                                     │
│  Routes                             │
│     ↓                               │
│  Controllers                        │
│     ↓                               │
│  Services / Business Logic          │
│     ↓                               │
│  Eloquent Models                    │
└──────────────────┬──────────────────┘
                   │
                   ▼
┌─────────────────────────────────────┐
│             Database                │
│                                     │
│ Centers                             │
│ Exams                               │
│ Exam Sessions                       │
│ Candidates                          │
│ Competencies                        │
│ Scores                              │
│ Results                             │
│ Documents                           │
│ Audit Logs                          │
└─────────────────────────────────────┘
```

## 🛠️ Technology Stack

### Backend

* PHP
* Laravel
* Laravel Eloquent ORM
* Laravel Authentication
* Spatie Laravel Permission

### Frontend

* Blade
* Bootstrap
* AdminLTE
* JavaScript
* DataTables
* Chart.js / ApexCharts where applicable

### Database

* MySQL
* PostgreSQL compatible architecture

### Document & Export

* PDF generation
* Excel export
* Laravel notifications

## 📁 Main Application Modules

```text
app/
├── Http/
│   ├── Controllers/
│   │   └── Admin/
│   └── Requests/
│
├── Models/
│
└── Services/

resources/
└── views/
    └── admin/
        ├── dashboard/
        ├── centers/
        ├── exams/
        ├── exam_sessions/
        ├── competencies/
        ├── ccp_weights/
        ├── candidates/
        ├── candidate_documents/
        ├── scores/
        ├── results/
        ├── pv/
        ├── audit/
        ├── notifications/
        ├── users/
        └── roles/
```

## 🔐 Security

The application implements or is designed to implement:

* Authentication
* Role-based authorization
* Permission management
* Password hashing
* CSRF protection
* Server-side validation
* Foreign key constraints
* Controlled access to examination data
* Audit logging for sensitive operations

## 💻 Installation

Clone the repository:

```bash
git clone https://github.com/malado04/decfp.git
cd decfp
```

Install PHP dependencies:

```bash
composer install
```

Create the environment configuration:

```bash
cp .env.example .env
php artisan key:generate
```

Configure your database in `.env`.

Run migrations:

```bash
php artisan migrate
```

Start the development server:

```bash
php artisan serve
```

The application will then be available locally.

## 🧪 Testing

Run the Laravel test suite with:

```bash
php artisan test
```

Tests should cover critical areas such as:

* Authentication
* Authorization
* Candidate management
* Score management
* Result calculation
* Role-based access
* Data validation

## 📊 Project Status

The project is under active development.

Core modules include:

* Examination centers
* Users and roles
* Examinations
* Examination sessions
* Candidates
* Competencies
* Scores
* Results
* Documents
* Audit

Additional workflows such as advanced statistics, PDF generation, Excel exports, notifications and complete automated testing are being progressively integrated and validated.

## 🎓 Business Domain

**DEC/DECFP — Professional Examination Management**

The project focuses on digitizing examination administration workflows and providing a centralized platform for managing examination operations, candidates, assessments and results.

## 👨‍💻 Author

**Amadou Malado Ndiaye**

Software Engineer | Full Stack Developer | Software Architecture

**Technologies:** Java • Spring Boot • Laravel • PHP • Angular • TypeScript • PostgreSQL • MySQL • Docker • Linux

GitHub: https://github.com/malado04

---

⭐ If you find this project useful, feel free to explore the repository and its implementation.
