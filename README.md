# IEC Platform

A comprehensive educational platform with Docker-based infrastructure for managing courses, lessons, and users.

## Overview

This platform provides:

- Student dashboard and daily lessons
- Tutor management interface
- Admin control panel for managing modules, lessons, and users
- Quiz and progress tracking system
- Leaderboard functionality
- Announcements system

## Architecture

The platform consists of the following services:

- **Apache/PHP**: Web server serving the main application
- **MariaDB**: Database server
- **BIND**: DNS server for internal name resolution
- **Nagios**: Monitoring service

## Getting Started

### Prerequisites

- Docker
- Docker Compose

### Running the Platform

1. Start all services:

```bash
ansible-playbook ansible/start-services.yml
```

2. Stop all services:

```bash
ansible-playbook ansible/stop-services.yml
```

3. Reset the database:

```bash
ansible-playbook ansible/reset-db.yml
```

## Project Structure

- `Apache/` - Web server configuration and application code
- `mariadb/` - Database configuration
- `bind/` - DNS server configuration
- `nagios/` - Monitoring service configuration
- `ansible/` - Ansible playbooks for service management

## Access

Once running, access the platform at:

- Main application: http://iec.test (or configured domain)

## User Roles

- **Student**: Access daily lessons, take quizzes, view progress
- **Tutor**: Manage classes and view student progress
- **Admin**: Full control over modules, lessons, users, and groups
