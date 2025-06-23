# SHE-015 Noise Survey Module Documentation

## Document Overview
### Document Purpose
This document provides comprehensive documentation for the SHE-015 Noise Survey module, which manages and tracks workplace noise level monitoring across different work locations.

### Project Name
Noise Survey Management - Smart Form Module SHE-015

### Version History
- v1.0.0 - Initial release
- Current Version: 1.0.0

### Document Status
Active/In Development

## Project Overview
### Project Description
The SHE-015 Noise Survey module is a critical health and safety component that manages and tracks workplace noise level monitoring across various work locations. It ensures compliance with occupational noise exposure limits and identifies areas requiring noise control measures.

### Project Scope
- Dashboard with survey statistics
- Noise survey form management
- Multi-level approval workflow
- PDF report generation
- Location-specific monitoring
- Risk level assessment
- Findings documentation

### Project Goals
- Monitor workplace noise levels
- Track high-risk areas
- Document survey findings
- Generate survey reports
- Support approval workflow
- Identify control measures

### Target Users
- Safety Officers
- Industrial Hygienists
- Department Heads
- Site Supervisors
- Safety Managers
- Compliance Officers

## Functional Requirements

### User Interface Requirements
- Dashboard with statistics display:
  - Total surveys counter
  - Monthly surveys counter
  - Location count
  - High-risk area alerts
- Advanced filtering capabilities:
  - Date range filter
  - Work location filter
  - Document number search
  - Risk level filter
- Survey form interface
- PDF export functionality
- Approval workflow interface

### Form Validation Rules
- Required field validation for:
  - Document number (auto-generated)
  - Survey date
  - Department
  - Site name
  - Work location
  - Risk level
  - Inspector details
- Date validation
- Status validation
- Risk level validation

### Data Processing Requirements
- Automatic document number generation
- PDF report generation
- Monthly statistics calculation
- Risk level assessment
- Approval status tracking
- Finding documentation

### Business Logic
- Multi-level approval workflow:
  - Inspector review
  - Supervisor acknowledgment
- Risk level categorization
- Location-based tracking
- Monthly survey requirements
- Department-specific validations
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
#### Table: she_noise_survey
- id (Primary Key)
- doc_number (Unique)
- revision
- survey_date
- department
- site_name
- inspector_count
- inspection_date
- acknowledgment_date
- inspected_by_name
- inspected_by_nik
- acknowledged_by_name
- acknowledged_by_nik
- shift
- work_location
- risk_level
- activities
- work_areas
- findings_description
- approval_status
- created_at
- updated_at

### API Endpoints

#### 1. Dashboard View
- **Route**: GET `/she-015/noise`
- **Name**: `she.noise.dashboard`
- **Description**: Main dashboard interface
- **Query Parameters**:
  - `search` (string, optional): Search by doc number or location
  - `start_date` (date, optional): Filter by start date
  - `end_date` (date, optional): Filter by end date
  - `work_location` (string, optional): Filter by location
- **Response**: View with statistics and filtered records

#### 2. Add Form
- **Route**: GET `/she-015/noise/add`
- **Name**: `she.noise.add-form`
- **Description**: Display survey form
- **Response**: Form view with survey fields

#### 3. Store Record
- **Route**: POST `/she-015/noise/store`
- **Name**: `she.noise.store`
- **Description**: Save new survey
- **Request Body**:
  ```json
  {
    "survey_date": "date",
    "department": "string",
    "site_name": "string",
    "work_location": "string",
    "inspector_count": "integer",
    "shift": "string",
    "risk_level": "string",
    "activities": "string",
    "work_areas": "string",
    "findings_description": "string",
    "inspected_by_name": "string",
    "inspected_by_nik": "string"
  }
  ```
- **Response**: JSON response with status

#### 4. Update Record
- **Route**: POST `/she-015/noise/update/{id}`
- **Name**: `she.noise.update`
- **Description**: Update survey record
- **Request Body**: Same as Store Record
- **Response**: JSON response with status

#### 5. Edit Form
- **Route**: GET `/she-015/noise/edit/{id}`
- **Name**: `she.noise.edit-form`
- **Description**: Edit survey form
- **Parameters**: Record ID
- **Response**: Form view with existing data

#### 6. Export PDF
- **Route**: GET `/she-015/noise/export/{id}`
- **Name**: `she.noise.export`
- **Description**: Generate PDF report
- **Parameters**: 
  - `id` (integer): Record ID
- **Response**: PDF download

#### 7. View Form
- **Route**: GET `/she-015/noise/view/{id}`
- **Name**: `she.noise.view-form`
- **Description**: View survey details
- **Parameters**: Record ID
- **Response**: Detail view with survey data

#### 8. Delete Record
- **Route**: DELETE `/she-015/noise/delete/{id}`
- **Name**: `she.noise.delete`
- **Description**: Delete survey record
- **Parameters**: Record ID
- **Response**: JSON response with status

#### 9. Update Status
- **Route**: POST `/she-015/noise/status`
- **Name**: `she.noise.update-status`
- **Description**: Update approval status
- **Request Body**:
  ```json
  {
    "id": "integer",
    "status": "string"
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
- Survey form layout
- PDF preview

### Navigation Flow
1. Dashboard view
2. Survey form creation
3. Form submission
4. Approval process
5. PDF generation

### Form Elements
- Text inputs
- Date pickers
- Location selectors
- Risk level selector
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
2. Data validation
3. Status tracking
4. Database storage
5. PDF generation

### Data Validation
- Required fields checking
- Date format validation
- Status validation
- Risk level validation

### Data Storage
- Main record storage
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
2. PDF generation
3. Approval workflow
4. Filter functionality
5. CRUD operations
6. Date handling
7. Risk level assessment

### Test Scenarios
- Complete survey record creation
- Invalid data handling
- PDF report generation
- Search and filter operations
- Approval process testing
- Status update functionality
- Risk level categorization

### Acceptance Criteria
- Successful survey record creation
- Accurate risk level tracking
- Proper PDF report generation
- Responsive UI
- Proper error handling
- Data integrity maintenance
- Working approval workflow
- Valid finding documentation
