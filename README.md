# Inward Gatepass Management System

## Overview
The Inward Gatepass Management System is a web-based application developed for the Cordite Factory Aruvankadu (Indian Ordnance Factories) to streamline and digitize their inward material tracking process. The system manages the documentation and tracking of materials entering the facility.

## Features
- **Secure Authentication**: User authentication system to ensure secure access
- **Material Entry Management**: 
  - Document number tracking
  - Supplier information
  - Transport details
  - Invoice management
  - Item details and specifications
  - Quantity tracking
  - Date management
- **Reporting System**:
  - Comprehensive report generation
  - Paginated view of all entries
  - Sortable by creation date
- **User-Friendly Interface**:
  - Bootstrap-based responsive design
  - Clean and intuitive navigation
  - Mobile-friendly layout

## Technical Stack
- **Backend**: PHP 7+
- **Database**: MySQL/MariaDB
- **Frontend**: 
  - HTML5
  - CSS3
  - Bootstrap 5.1.3
  - JavaScript
- **Server**: Apache (WAMP Stack)

## Database Structure
The system uses a primary table `inward_gatepass` with the following key fields:
- document_no
- supplied_by
- mode_of_transport
- invoice_no
- invoice_date
- item_code
- nomenclature
- quantity
- unit_of_quantity
- date_received
- status
- created_at

## Security Features
- PDO prepared statements for SQL injection prevention
- HTML escaping for XSS prevention
- Session-based authentication
- Input validation and sanitization

## Installation
1. Clone the repository
2. Set up WAMP/LAMP server
3. Import the database schema
4. Configure database connection in `config/database.php`
5. Set up authentication parameters

## Requirements
- PHP 7.0 or higher
- MySQL 5.7 or higher
- Apache 2.4 or higher
- Web browser with JavaScript enabled

## Future Enhancements
- Export functionality for reports (PDF, Excel)
- Advanced search and filtering options
- Material status tracking
- Email notifications
- API integration capabilities
