# Changelog

All notable changes to the **Placement Management System** project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

---

## [1.0.0] - 2026-09-20

### Initial Release (BCA Minor Project)

#### Added
- **Public Website:**
  - Modern responsive landing page with dynamic Hero banner, Placement Statistics, Top Recruiters marquee, and Student Success Stories.
  - Informative About Us page outlining placement objectives, process workflow, and placement team directory.
  - Searchable Partner Companies directory showing approved recruiting partners.
  - Public Jobs listing page with category, location, and keyword filtering.
  - Contact Us page with campus address, office hours, interactive Google Maps embed, inquiry form, and social media handles.
  - Dedicated Privacy Policy (`privacy.php`) and Terms of Service (`terms.php`) pages.

- **Student Portal (`/student`):**
  - Secure student registration and authentication system.
  - Student dashboard displaying application counters, shortlist status, and alerts.
  - Profile management module for academic scores (10th, 12th, CGPA) and resume upload.
  - One-click job application engine with live status tracking (Pending, Shortlisted, Selected, Rejected).
  - Notifications center and account settings.

- **Company Portal (`/company`):**
  - Employer registration with admin approval workflow.
  - Company dashboard tracking active job listings and total applications received.
  - Job posting engine with salary package, eligibility criteria, and deadline management.
  - Candidate evaluation module with resume download and status updating with feedback remarks.
  - Company profile and contact settings.

- **Admin Panel (`/admin`):**
  - Comprehensive placement dashboard with analytical counters.
  - Student management module with search, details inspection, and resume review.
  - Company verification system (Approve/Reject pending registrations).
  - Job management and global application oversight.
  - Selected Students report tracking placed candidates.
  - Integrated Website Management (CMS) module for live updates to homepage sections, team members, and contact information.

- **System & Security:**
  - Secure password hashing using PHP `password_hash()` and `password_verify()`.
  - Role-based session access controls preventing unauthorized URL access.
  - SQL injection protection via `clean()` helper and real escape strings.
  - Custom branded error handling for `404 Not Found`, `403 Forbidden`, and `500 Server Error`.
  - SEO optimization with `sitemap.xml`, `robots.txt`, and structured metadata.
