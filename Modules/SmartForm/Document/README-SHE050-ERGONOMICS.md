# SHE-050 Ergonomics Assessment Module Documentation

## Document Overview
### Document Purpose
This document provides comprehensive documentation for the SHE-050 Ergonomics Assessment module, which manages and tracks workplace ergonomics assessments across different work locations.

### Project Name
Ergonomics Assessment Management - Smart Form Module SHE-050

### Version History
- v1.0.0 - Initial release
- Current Version: 1.0.0

### Document Status
Active/In Development

## Project Overview
### Project Description
The SHE-050 Ergonomics Assessment module is a critical health and safety component that manages and tracks workplace ergonomics assessments across various work locations. It ensures proper ergonomic conditions and identifies potential musculoskeletal disorder risks in the workplace.

### Project Scope
- Dashboard with assessment statistics
- Ergonomics assessment form
- Multi-level approval workflow
- PDF report generation
- Location-specific monitoring
- Risk level assessment
- Recommendations tracking

### Project Goals
- Assess workplace ergonomics
- Track ergonomic risks
- Document assessments
- Generate assessment reports
- Support approval workflow
- Identify improvement areas
- Track implementation status

### Target Users
- Safety Officers
- Ergonomics Specialists
- Department Heads
- Site Supervisors
- Occupational Health Staff
- HR Personnel

## Functional Requirements

### User Interface Requirements
- Dashboard with statistics display:
  - Total assessments counter
  - Monthly assessments counter
  - Location count
  - High-risk alerts
- Advanced filtering capabilities:
  - Date range filter
  - Work location filter
  - Document number search
  - Risk level filter
- Assessment form interface
- PDF export functionality
- Multi-level approval interface

### Form Validation Rules
- Required field validation for:
  - Document number (auto-generated)
  - Assessment date
  - Department
  - Work location
  - Job position
  - Task description
  - Risk factors
  - Recommendations
- Date validation
- Status validation
- Risk level validation

### Data Processing Requirements
- Automatic document number generation
- PDF report generation
- Monthly statistics calculation
- Risk level assessment
- Approval status tracking
- Recommendations tracking

### Business Logic
- Multi-level approval workflow:
  - Initial assessment
  - Supervisor review
  - Department head approval
  - Final acknowledgment
- Risk level categorization
- Location-based tracking
- Monthly assessment requirements
- Implementation status tracking
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
#### Table: she_ergonomics_assessment
- id (Primary Key)
- doc_number (Unique)
- assessment_date
- department
- work_location
- job_position
- task_description
- employee_count
- shift_hours
- risk_factors (JSON)
- risk_level
- recommendations (JSON)
- implementation_status
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
- created_at
- updated_at

### API Endpoints

#### 1. Dashboard View
- **Route**: GET `/she-050/ergonomics`
- **Name**: `she.ergonomics.dashboard`
- **Description**: Main dashboard interface
- **Query Parameters**:
  - `search` (string, optional): Search by doc number or location
  - `start_date` (date, optional): Filter by start date
  - `end_date` (date, optional): Filter by end date
  - `work_location` (string, optional): Filter by location
  - `risk_level` (string, optional): Filter by risk level
- **Response**: View with statistics and filtered records

#### 2. Add Form
- **Route**: GET `/she-050/ergonomics/add`
- **Name**: `she.ergonomics.add-form`
- **Description**: Display assessment form
- **Response**: Form view with assessment fields

#### 3. Store Record
- **Route**: POST `/she-050/ergonomics/store`
- **Name**: `she.ergonomics.store`
- **Description**: Save new assessment
- **Request Body**:
  ```json
  {
    "assessment_date": "date",
    "department": "string",
    "work_location": "string",
    "job_position": "string",
    "task_description": "string",
    "employee_count": "integer",
    "shift_hours": "string",
    "risk_factors": "array",
    "risk_level": "string",
    "recommendations": "array",
    "implementation_status": "string",
    "inspected_by_name": "string",
    "inspected_by_nik": "string"
  }
  ```
- **Response**: JSON response with status

#### 4. Update Record
- **Route**: POST `/she-050/ergonomics/update/{id}`
- **Name**: `she.ergonomics.update`
- **Description**: Update assessment record
- **Request Body**: Same as Store Record
- **Response**: JSON response with status

#### 5. Edit Form
- **Route**: GET `/she-050/ergonomics/edit/{id}`
- **Name**: `she.ergonomics.edit-form`
- **Description**: Edit assessment form
- **Parameters**: Record ID
- **Response**: Form view with existing data

#### 6. Export PDF
- **Route**: GET `/she-050/ergonomics/export/{id}`
- **Name**: `she.ergonomics.export`
- **Description**: Generate PDF report
- **Parameters**: 
  - `id` (integer): Record ID
- **Response**: PDF download

#### 7. View Form
- **Route**: GET `/she-050/ergonomics/view/{id}`
- **Name**: `she.ergonomics.view-form`
- **Description**: View assessment details
- **Parameters**: Record ID
- **Response**: Detail view with assessment data

#### 8. Delete Record
- **Route**: DELETE `/she-050/ergonomics/delete/{id}`
- **Name**: `she.ergonomics.delete`
- **Description**: Delete assessment record
- **Parameters**: Record ID
- **Response**: JSON response with status

#### 9. Update Status
- **Route**: POST `/she-050/ergonomics/status`
- **Name**: `she.ergonomics.update-status`
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
- Assessment form layout
- PDF preview

### Navigation Flow
1. Dashboard view
2. Assessment form creation
3. Risk factor documentation
4. Recommendations input
5. Form submission
6. Multi-level approval
7. PDF generation

### Form Elements
- Text inputs
- Date pickers
- Location selectors
- Risk factor checklist
- Risk level selector
- Recommendation fields
- Implementation status
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
2. Risk assessment
3. Status tracking
4. Database storage
5. PDF generation

### Data Validation
- Required fields checking
- Date format validation
- Status validation
- Risk level validation
- Implementation status validation

### Data Storage
- Main record storage
- Risk factors (JSON)
- Recommendations (JSON)
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
2. Risk assessment calculation
3. PDF generation
4. Multi-level approval workflow
5. Filter functionality
6. CRUD operations
7. Date handling
8. Implementation tracking

### Test Scenarios
- Complete assessment record creation
- Invalid data handling
- PDF report generation
- Search and filter operations
- Approval process testing
- Status update functionality
- Risk level categorization
- Recommendation tracking

### Acceptance Criteria
- Successful assessment record creation
- Accurate risk level tracking
- Proper PDF report generation
- Responsive UI
- Proper error handling
- Data integrity maintenance
- Working approval workflow
- Valid recommendation tracking
- Implementation status monitoring
