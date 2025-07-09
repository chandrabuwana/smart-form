# SHE-049 Drinking Water (Air Minum) Inspection Module Documentation

## Document Overview
### Document Purpose
This document provides comprehensive documentation for the SHE-049 Drinking Water Inspection module, which manages and tracks drinking water facility inspections across different work locations.

### Project Name
Drinking Water Inspection Management - Smart Form Module SHE-049

### Version History
- v1.0.0 - Initial release
- Current Version: 1.0.0

### Document Status
Active/In Development

## Project Overview
### Project Description
The SHE-049 Drinking Water module is a critical health and safety component that manages and tracks drinking water facility inspections across various work locations. It ensures proper maintenance and hygiene of drinking water facilities for workplace health compliance.

### Project Scope
- Dashboard with inspection statistics
- Drinking water facility inspection form
- Multi-inspector approval workflow
- PDF report generation
- Location-specific monitoring
- Monthly inspection tracking
- Hygiene condition tracking

### Project Goals
- Ensure regular drinking water inspections
- Track facility cleanliness
- Monitor water quality
- Generate inspection reports
- Support multi-level approvals
- Identify maintenance needs

### Target Users
- Safety Officers
- Health Inspectors
- Supervisors
- Department Heads
- Maintenance Personnel
- Hygiene Officers

## Functional Requirements

### User Interface Requirements
- Dashboard with statistics display:
  - Total inspections counter
  - Monthly inspections counter
  - Location count
  - Attention alerts
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
  - Work location
  - Inspection date
  - Inspector details
  - Facility conditions
- Date validation
- Status validation
- Approval workflow validation

### Data Processing Requirements
- Automatic document number generation
- PDF report generation
- Monthly statistics calculation
- Facility status tracking
- Approval status tracking
- Maintenance alert generation

### Business Logic
- Multi-level approval workflow:
  - Inspector 1 review
  - Inspector 2 review
  - Inspector 3 review
  - Final acknowledgment
- Location-based tracking
- Monthly inspection requirements
- Facility status monitoring
- Cleanliness alerting

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
#### Table: she_air_minum
- id (Primary Key)
- doc_number (Unique)
- work_location
- inspection_date
- has_scattered_items (boolean)
- has_scattered_trash (boolean)
- inspector_1
- inspector_1_status
- inspector_1_date
- inspector_2
- inspector_2_status
- inspector_2_date
- inspector_3
- inspector_3_status
- inspector_3_date
- acknowledged_by
- acknowledged_by_status
- acknowledged_by_date
- approval_status
- notes
- created_at
- updated_at
- deleted_at (soft delete)

### API Endpoints

#### 1. Dashboard View
- **Route**: GET `/she-049/air-minum`
- **Name**: `she-air-minum.dashboard`
- **Description**: Main dashboard interface
- **Query Parameters**:
  - `search` (string, optional): Search by doc number or location
  - `start_date` (date, optional): Filter by start date
  - `end_date` (date, optional): Filter by end date
  - `work_location` (string, optional): Filter by location
- **Response**: View with statistics and filtered records

#### 2. Add Form
- **Route**: GET `/she-049/air-minum/add`
- **Name**: `she-air-minum.add-form`
- **Description**: Display inspection form
- **Response**: Form view with inspection checklist

#### 3. Store Record
- **Route**: POST `/she-049/air-minum/store`
- **Name**: `she-air-minum.store`
- **Description**: Save new inspection
- **Request Body**:
  ```json
  {
    "work_location": "string",
    "inspection_date": "date",
    "has_scattered_items": "boolean",
    "has_scattered_trash": "boolean",
    "inspector_1": "string",
    "notes": "string"
  }
  ```
- **Response**: JSON response with status

#### 4. Update Record
- **Route**: POST `/she-049/air-minum/update/{id}`
- **Name**: `she-air-minum.update`
- **Description**: Update inspection record
- **Request Body**: Same as Store Record
- **Response**: JSON response with status

#### 5. Export PDF
- **Route**: GET `/she-049/air-minum/export/{id}`
- **Name**: `she-air-minum.export`
- **Description**: Generate PDF report
- **Parameters**: 
  - `id` (integer): Record ID
- **Response**: PDF download

#### 6. Delete Record
- **Route**: DELETE `/she-049/air-minum/delete/{id}`
- **Name**: `she-air-minum.delete`
- **Description**: Soft delete inspection record
- **Parameters**: Record ID
- **Response**: JSON response with status

#### 7. Update Approval Status
- **Route**: POST `/she-049/air-minum/approve/{id}/{role}`
- **Name**: `she-air-minum.approve`
- **Description**: Update approval status
- **Parameters**:
  - `id` (integer): Record ID
  - `role` (string): Approver role
- **Request Body**:
  ```json
  {
    "notes": "string"
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
3. Form submission
4. Multi-inspector approval process
5. PDF generation

### Form Elements
- Text inputs
- Date pickers
- Location selectors
- Condition checkboxes
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
- Condition validation

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
3. Multi-inspector approval workflow
4. Filter functionality
5. CRUD operations
6. Date handling
7. Location filtering

### Test Scenarios
- Complete inspection record creation
- Invalid data handling
- PDF report generation
- Search and filter operations
- Approval process testing
- Status reset functionality
- Condition tracking

### Acceptance Criteria
- Successful inspection record creation
- Accurate facility status tracking
- Proper PDF report generation
- Responsive UI
- Proper error handling
- Data integrity maintenance
- Working approval workflow
- Valid condition tracking
