# SHE-034 Mess/Housing Inspection Module Documentation

## Document Overview
### Document Purpose
This document provides comprehensive documentation for the SHE-034 Mess/Housing Inspection module, which manages and tracks inspections of mess halls and housing facilities across different work locations.

### Project Name
Mess/Housing Inspection Management - Smart Form Module SHE-034

### Version History
- v1.0.0 - Initial release
- Current Version: 1.0.0

### Document Status
Active/In Development

## Project Overview
### Project Description
The SHE-034 Mess/Housing Inspection module is a critical health and safety component that manages and tracks inspections of mess halls and housing facilities across various work locations. It ensures proper maintenance, hygiene, and safety standards in company-provided dining and accommodation facilities.

### Project Scope
- Dashboard with inspection statistics
- Mess/Housing inspection form
- Multi-level approval workflow
- PDF report generation
- Location-specific monitoring
- Checklist-based inspection
- Findings documentation

### Project Goals
- Ensure facility cleanliness
- Track maintenance needs
- Monitor hygiene standards
- Generate inspection reports
- Support approval workflow
- Identify improvement areas

### Target Users
- Safety Officers
- Facility Managers
- Housekeeping Staff
- Department Heads
- Site Supervisors
- Health Inspectors

## Functional Requirements

### User Interface Requirements
- Dashboard with statistics display:
  - Total inspections counter
  - Monthly inspections counter
  - Location count
  - Compliance alerts
- Advanced filtering capabilities:
  - Date range filter
  - Work location filter
  - Document number search
  - Status filter
- Inspection form interface
- PDF export functionality
- Multi-inspector approval interface

### Form Validation Rules
- Required field validation for:
  - Document number (auto-generated)
  - Survey date
  - Site name
  - Work location
  - Inspector details
  - Checklist items
- Date validation
- Status validation
- Checklist validation

### Data Processing Requirements
- Automatic document number generation
- PDF report generation
- Monthly statistics calculation
- Checklist processing
- Approval status tracking
- Finding documentation

### Business Logic
- Multi-level approval workflow:
  - Initial inspection
  - Supervisor review
  - Department head approval
  - Final acknowledgment
- Location-based tracking
- Monthly inspection requirements
- Checklist completion validation
- User role-based access control

### Error Handling
- Database query exception handling
- PDF generation error management
- Date parsing error handling
- User-friendly error messages
- Logging system integration

## Technical Specifications

### Framework & Technologies
- Laravel Framework
- DomPDF for PDF generation
- MySQL Database
- Bootstrap UI
- Carbon for date handling

### Database Schema
#### Table: she_mess_survey
- id (Primary Key)
- doc_number (Unique)
- survey_date
- site_name
- work_location
- checklist_items (JSON)
- inspector_count
- inspection_date
- inspection_date2
- inspection_date3
- acknowledgment_date
- inspected_by_name
- inspected_by_nik
- acknowledged_by_name
- acknowledged_by_nik
- approval_status
- completion_date
- created_at
- updated_at

### API Endpoints

#### 1. Dashboard View
- **Route**: GET `/she-034/mess`
- **Name**: `she.mess.dashboard`
- **Description**: Main dashboard interface
- **Query Parameters**:
  - `search` (string, optional): Search by doc number or location
  - `start_date` (date, optional): Filter by start date
  - `end_date` (date, optional): Filter by end date
  - `work_location` (string, optional): Filter by location
- **Response**: View with statistics and filtered records

#### 2. Add Form
- **Route**: GET `/she-034/mess/add`
- **Name**: `she.mess.add-form`
- **Description**: Display inspection form
- **Parameters**:
  - `id` (integer, optional): For edit mode
- **Response**: Form view with inspection checklist

#### 3. Edit Form
- **Route**: GET `/she-034/mess/edit/{id}`
- **Name**: `she.mess.edit-form`
- **Description**: Edit inspection form
- **Parameters**: Record ID
- **Response**: Form view with existing data

#### 4. Store Record
- **Route**: POST `/she-034/mess/store`
- **Name**: `she.mess.store`
- **Description**: Save new inspection
- **Request Body**:
  ```json
  {
    "survey_date": "date",
    "site_name": "string",
    "work_location": "string",
    "checklist_items": "array",
    "inspector_count": "integer",
    "inspected_by_name": "string",
    "inspected_by_nik": "string"
  }
  ```
- **Response**: JSON response with status

#### 5. Export PDF
- **Route**: GET `/she-034/mess/export/{id}`
- **Name**: `she.mess.export`
- **Description**: Generate PDF report
- **Parameters**: 
  - `id` (integer): Record ID
- **Response**: PDF download

#### 6. Approve Record
- **Route**: POST `/she-034/mess/approve/{id}/{role}`
- **Name**: `she.mess.approve`
- **Description**: Approve inspection record
- **Parameters**:
  - `id` (integer): Record ID
  - `role` (string): Approver role
- **Response**: JSON response with status

#### 7. Reject Record
- **Route**: POST `/she-034/mess/reject/{id}/{role}`
- **Name**: `she.mess.reject`
- **Description**: Reject inspection record
- **Parameters**:
  - `id` (integer): Record ID
  - `role` (string): Approver role
- **Response**: JSON response with status

#### 8. Delete Record
- **Route**: DELETE `/she-034/mess/delete`
- **Name**: `she.mess.delete`
- **Description**: Delete inspection record
- **Request Body**:
  ```json
  {
    "id": "integer"
  }
  ```
- **Response**: JSON response with status

### Integration Points
- HRD System for user validation
- PDF Generation System
- Logging System
- Frontend UI

### Security Requirements
- Authentication required
- Role-based access control
- CSRF protection
- Input validation
- Secure file handling

## User Interface Design

### Layout Specifications
- Responsive dashboard
- Statistical widgets
- Filter form section
- Data table component
- Inspection form layout
- PDF preview

### Navigation Flow
1. Dashboard view
2. Inspection form creation
3. Checklist completion
4. Form submission
5. Multi-level approval
6. PDF generation

### Form Elements
- Text inputs
- Date pickers
- Location selectors
- Checklist items
- Approval buttons
- Status indicators

### Messages
- Success notifications
- Error alerts
- Validation messages
- Processing indicators

## Data Flow

### Data Input Process
1. Form submission
2. Checklist validation
3. Status tracking
4. Database storage
5. PDF generation

### Data Validation
- Required fields checking
- Date format validation
- Status validation
- Checklist validation

### Data Storage
- Main record storage
- Checklist data (JSON)
- Status tracking
- Approval tracking
- Audit logging

### Data Retrieval
- Filtered queries
- Pagination handling
- PDF generation
- Statistical calculations

## Testing Requirements

### Test Cases
1. Form submission validation
2. Checklist completion
3. PDF generation
4. Multi-level approval workflow
5. Filter functionality
6. CRUD operations
7. Date handling

### Test Scenarios
- Complete inspection record creation
- Invalid data handling
- PDF report generation
- Search and filter operations
- Approval process testing
- Status update functionality
- Checklist validation

### Acceptance Criteria
- Successful inspection record creation
- Accurate checklist tracking
- Proper PDF report generation
- Responsive UI
- Proper error handling
- Data integrity maintenance
- Working approval workflow
- Valid finding documentation
