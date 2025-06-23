# SHE-037 Eyewash Station Inspection Module Documentation

## Document Overview
### Document Purpose
This document provides comprehensive documentation for the SHE-037 Eyewash Station Inspection module, which manages safety inspections of emergency eyewash stations across different locations.

### Project Name
Eyewash Station Inspection Management - Smart Form Module SHE-037

### Version History
- v1.0.0 - Initial release
- Current Version: 1.0.0

### Document Status
Active/In Development

## Project Overview
### Project Description
The SHE-037 Eyewash Station module is a critical safety component that manages and tracks emergency eyewash station inspections across various locations. It ensures proper maintenance and functionality of emergency eyewash equipment for workplace safety compliance.

### Project Scope
- Dashboard with inspection statistics
- Eyewash station inspection form
- Multi-level approval workflow
- PDF report generation
- Location-specific monitoring
- Monthly inspection tracking
- Equipment condition tracking

### Project Goals
- Ensure regular eyewash station inspections
- Track equipment functionality
- Monitor water quality and volume
- Generate inspection reports
- Support multi-level approvals
- Identify maintenance needs

### Target Users
- Safety Officers
- Hygiene Officers
- Supervisors
- Department Heads
- Maintenance Personnel
- Safety Managers

## Functional Requirements

### User Interface Requirements
- Dashboard with statistics display:
  - Total inspections counter
  - Monthly inspections counter
  - Location count
  - Maintenance alerts
- Advanced filtering capabilities:
  - Date range filter
  - Location filter
  - Document number search
  - Status filter
- Inspection form interface
- PDF export functionality
- Multi-level approval interface

### Form Validation Rules
- Required field validation for:
  - Document number (auto-generated)
  - Location
  - Inspection date
  - Tank condition
  - Water volume
  - Equipment functionality
- Date validation
- Status validation
- Approval workflow validation

### Data Processing Requirements
- Automatic document number generation
- PDF report generation
- Monthly statistics calculation
- Equipment status tracking
- Approval status tracking
- Maintenance alert generation

### Business Logic
- Multi-level approval workflow:
  - Hygiene Officer review
  - Supervisor approval
  - Department Head approval
  - Related Department Head approval
- Location-based tracking
- Monthly inspection requirements
- Equipment status monitoring
- Maintenance alerting

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
#### Table: she_eyewash
- id (Primary Key)
- doc_number (Unique)
- location
- inspection_date
- monthly_data (JSON)
  - tank_condition
  - water_volume
  - eyewash_function
- created_by
- created_at
- updated_at
- hygiene_name
- hygiene_nik
- hygiene_signed_at
- hygiene_status
- supervisor_name
- supervisor_nik
- supervisor_signed_at
- supervisor_status
- dh_name
- dh_nik
- dh_signed_at
- dh_status
- dh_terkait_name
- dh_terkait_nik
- dh_terkait_signed_at
- dh_terkait_status
- approval_status
- notes

### API Endpoints

#### 1. Dashboard View
- **Route**: GET `/she-037/eyewash`
- **Name**: `she-inspeksi.dashboard`
- **Description**: Main dashboard interface
- **Query Parameters**:
  - `start_date` (date, optional): Filter by start date
  - `end_date` (date, optional): Filter by end date
  - `location` (string, optional): Filter by location
  - `search` (string, optional): Search by doc number or location
- **Response**: View with statistics and filtered records

#### 2. Add Form
- **Route**: GET `/she-037/eyewash/add`
- **Name**: `she-inspeksi.add-form`
- **Description**: Display inspection form
- **Response**: Form view with inspection checklist

#### 3. Store Record
- **Route**: POST `/she-037/eyewash/store`
- **Name**: `she-inspeksi.store`
- **Description**: Save new inspection
- **Request Body**:
  ```json
  {
    "location": "string",
    "inspection_date": "date",
    "monthly_data": {
      "tank_condition": "string",
      "water_volume": "string",
      "eyewash_function": "string"
    },
    "notes": "string"
  }
  ```
- **Response**: JSON response with status

#### 4. Export PDF
- **Route**: GET `/she-037/eyewash/export/{id}`
- **Name**: `she-inspeksi.export`
- **Description**: Generate PDF report
- **Parameters**: 
  - `id` (integer): Record ID
- **Response**: PDF download

#### 5. Edit Form
- **Route**: GET `/she-037/eyewash/edit/{id}`
- **Name**: `she-inspeksi.edit-form`
- **Description**: Edit inspection form
- **Parameters**: Record ID
- **Response**: Form view with existing data

#### 6. Update Record
- **Route**: POST `/she-037/eyewash/update`
- **Name**: `she-inspeksi.update`
- **Description**: Update inspection record
- **Request Body**: Same as Store Record
- **Response**: JSON response with status

#### 7. Delete Record
- **Route**: DELETE `/she-037/eyewash/delete/{id}`
- **Name**: `she-inspeksi.delete`
- **Description**: Delete inspection record
- **Parameters**: Record ID
- **Response**: JSON response with status

#### 8. Approval Endpoints
- **Approve**:
  - **Route**: POST `/she-037/eyewash/approve/{id}`
  - **Name**: `she-inspeksi.approve`
  - **Description**: Approve inspection
  - **Request Body**:
    ```json
    {
      "role": "string",
      "notes": "string"
    }
    ```

- **Reject**:
  - **Route**: POST `/she-037/eyewash/reject/{id}`
  - **Name**: `she-inspeksi.reject`
  - **Description**: Reject inspection
  - **Request Body**: Same as Approve

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
4. Multi-level approval process
5. PDF generation

### Form Elements
- Text inputs
- Date pickers
- Location selectors
- Equipment condition checklist
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
- Equipment condition validation

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
3. Multi-level approval workflow
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
- Equipment condition tracking

### Acceptance Criteria
- Successful inspection record creation
- Accurate inspection data storage
- Proper PDF report generation
- Responsive UI
- Proper error handling
- Data integrity maintenance
- Working approval workflow
- Valid equipment status tracking
