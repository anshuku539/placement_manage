# Placement Management System

![PHP](https://img.shields.io/badge/PHP-7.4%20|%208.x-777bb4?style=flat-square&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-Database-4479a1?style=flat-square&logo=mysql&logoColor=white)
![Bootstrap](https://img.shields.io/badge/Bootstrap-5.3-7952b3?style=flat-square&logo=bootstrap&logoColor=white)
![Responsive](https://img.shields.io/badge/Design-Responsive-success?style=flat-square)

A web-based Placement Management System developed using procedural PHP, MySQL, and Bootstrap 5. The platform simplifies campus recruitment activities by connecting students, recruiting companies, and the college placement cell on a single, easy-to-use platform.

---

## Project Overview

The Placement Management System is built as a **BCA Minor Project** to automate and streamline the campus placement process in colleges and universities.

In traditional placement workflows, records of students, recruiting companies, job openings, and student applications are often maintained using spreadsheets and manual notices. This project solves those problems by providing:
- A dynamic public website for announcements, statistics, and recruiters.
- A dedicated student portal to browse jobs and track applications.
- A company portal to post vacancies and review applicant resumes.
- A central admin panel to manage approvals, track placements, and update website content.

---

## Key Features

### Public Website
- Responsive homepage with dynamic hero section, placement statistics, recruiter logos, and success stories.
- About Us page detailing placement objectives, workflow steps, and placement team members.
- Public directory of approved partner companies with search functionality.
- Job portal where visitors can explore open campus drives and job details.
- Contact page with college address, office hours, interactive Google Map, and social media handles.
- Easy navigation with responsive design and quick access to login/registration portals.

### Student Portal
- Secure registration and login with input validation.
- Personalized dashboard displaying total applications, shortlist status, and updates.
- Profile management with academic records, skills, and resume upload (PDF/DOC).
- Explore approved job listings with filter and search options.
- One-click job application system with instant status tracking (Pending, Shortlisted, Selected, Rejected).
- Notifications page and password management settings.

### Company Portal
- Registration and verification system for recruiting companies.
- Employer dashboard tracking active job postings and candidate applications.
- Company profile management with logo, contact info, and company bio.
- Job management: create, view, edit, and close job postings with eligibility criteria.
- Applicant review module: view candidate details, download resumes, and update recruitment status with remarks.
- Account settings and password update options.

### Admin Panel
- Secure administrator authentication and dashboard overview.
- Comprehensive statistics showing total students, verified companies, posted jobs, and placed candidates.
- Student management: view, search, and manage registered students and their resumes.
- Company approval workflow: verify or reject company registration requests.
- Job oversight: review and manage all job openings posted on the platform.
- Application tracking and dedicated Selected Students report.
- Website Management (CMS): live management of public website content including Hero banner, Statistics, Recruiters, Testimonials, About details, Team members, and Contact links with custom display ordering.

---

## Technology Stack

| Technology | Usage |
| :--- | :--- |
| **PHP (Procedural)** | Server-side backend logic and session management |
| **MySQL** | Relational database management |
| **Bootstrap 5** | Responsive CSS framework, UI components, and modal dialogs |
| **HTML5 & CSS3** | Page structure, custom styling, and animations |
| **JavaScript (Vanilla)** | Client-side validation, password toggling, and interactive UI |
| **Apache (XAMPP)** | Local web server environment |

---

## Folder Structure

```text
Placement_manage/
├── student/               # Student portal scripts (dashboard, jobs, applications, profile)
├── company/               # Company portal scripts (dashboard, post-job, applicants, profile)
├── assets/
│   ├── css/               # Custom stylesheets (style.css, admin.css)
│   ├── js/                # Custom scripts (main.js, validation)
│   ├── images/            # Static icons, logos, and default placeholders
│   └── uploads/           # User uploads (student resumes, company logos, CMS media)
├── includes/              # Shared helper scripts, database connection, navbar, footer
├── database/              # SQL schema file (placement_manage.sql)
├── index.php              # Public homepage
├── about.php              # Public about page
├── companies.php          # Public partner companies page
├── jobs.php               # Public jobs listing page
├── contact.php            # Public contact us page
├── student-login.php      # Student login page
├── student-register.php   # Student registration page
├── company-login.php      # Company login page
├── company-register.php   # Company registration page
├── robots.txt             # Search engine crawling rules
├── sitemap.xml            # Public XML sitemap
└── README.md              # Project documentation
```

---

## Installation Guide

Follow these steps to set up and run the project locally on your system using XAMPP:

### 1. Download / Clone Project
Download the project ZIP file and extract it, or clone it using Git:
```bash
git clone https://github.com/anshuku539/Placement_manage.git
```

### 2. Copy into htdocs
Move the project folder into your XAMPP `htdocs` directory:
```text
C:\xampp\htdocs\Placement_manage
```

### 3. Start Apache & MySQL
- Open the **XAMPP Control Panel**.
- Start both the **Apache** and **MySQL** services.

### 4. Import placement_manage.sql
- Open your browser and navigate to: `http://localhost/phpmyadmin/`
- Click on **New** to create a new database.
- Name the database: `Placement_manage` (Collation: `utf8mb4_general_ci`).
- Go to the **Import** tab.
- Click **Choose File**, select `database/placement_manage.sql` from the project directory, and click **Import**.

### 5. Configure Database
Check the database connection settings in `includes/config.php`:
```php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "Placement_manage";
```
*Note: If your local MySQL setup has a password, enter it in `$pass`.*

### 6. Open localhost
Open your web browser and visit:
```text
http://localhost/Placement_manage/
```

---

## Database

The database file is located at:
```text
database/placement_manage.sql
```

It contains all the necessary table structures and default initial records, including:
- `admin` - Stores administrator credentials and details.
- `students` - Stores student registration details, academic scores, and resumes.
- `companies` - Stores recruiting company details and approval status.
- `jobs` - Stores posted job openings, eligibility criteria, and deadlines.
- `applications` - Links student applications with jobs and tracks statuses.
- `cms_hero`, `cms_statistics`, `cms_recruiters`, `cms_testimonials`, `cms_why_choose_us`, `cms_drives`, `cms_about`, `cms_team`, `cms_settings` - Content management tables for public website pages.

---


## Project Modules

- **Public Website:** Provides public information about campus placements, top recruiters, job postings, and cell contact details.
- **Student Portal:** Allows registered students to manage their academic profile, upload their resume, browse job openings, and monitor their application status in real-time.
- **Company Portal:** Allows approved employers to post job vacancies, define eligibility requirements, browse candidate applications, and evaluate applicants.
- **Admin Panel:** Gives placement administrators full control over company approvals, student records, job listings, application results, and dynamic website content.

---

## Screenshots

### Home Page

### Student Dashboard

### Company Dashboard

### Admin Dashboard

---

## Future Improvements

- **Email Notifications:** Automatic email updates to students when application status changes or when a new drive is announced.
- **Interview Scheduling:** Integrated calendar module for companies to schedule interview rounds and notify students.
- **Placement Analytics:** Visual charts and exportable PDF/Excel reports for yearly placement statistics.
- **Resume Scoring:** Automatic resume checking and keyword matching against job requirements.
- **OTP Verification:** Two-step email or mobile OTP verification during student and company registration.

---

## Version

**v1.0.0**

---

## License

This project is created for **Educational Purpose Only** under the MIT License. See [LICENSE](LICENSE) for details.

---

## 👨‍💻 Developer

- **Name:** Anshu Kumar
- **College:** Amritsar Group of Colleges
- **Course:** Bachelor of Computer Applications (BCA)
- **GitHub:** <https://github.com/anshuku539>
- **LinkedIn:** <https://www.linkedin.com/in/anshukumar539>
- **Email:** <mailto:anshuku539@gmail.com>

---

## Acknowledgements

This project was developed as a BCA Minor Project for academic purposes. It demonstrates the implementation of a web-based Placement Management System using PHP, MySQL, Bootstrap 5, HTML, CSS, and JavaScript.