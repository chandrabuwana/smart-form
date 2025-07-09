# SHE-036 APAR (Fire Extinguisher) Inspection Module Documentation

## Document Overview
### Document Purpose
This document provides comprehensive documentation for the SHE-036 APAR (Fire Extinguisher) inspection module, which manages fire extinguisher inspection records and compliance across different locations.

### Project Name
APAR Inspection Management - Smart Form Module SHE-036

### Version History
- v1.0.0 - Initial release
- Current Version: 1.0.0

### Document Status
Active/In Development

## Project Overview
### Project Description
The SHE-036 APAR module is a critical safety component that manages and tracks fire extinguisher inspections across various locations. It ensures regular inspection, maintenance documentation, and compliance with safety standards.

### Project Scope
- Dashboard with inspection statistics
- APAR inspection form management
- Multi-level approval workflow
- PDF report generation
- Location-specific monitoring
- Monthly inspection tracking
- Comprehensive inspection checklist

### Project Goals
- Ensure regular APAR inspections
- Maintain detailed inspection records
- Enable location-specific monitoring
- Track inspection compliance
- Generate inspection reports
- Support multi-level approvals

### Target Users
- Safety Officers
- Department Heads
- Site Supervisors
- Maintenance Personnel
- Safety Managers
- Compliance Officers

## Functional Requirements

### User Interface Requirements
- Dashboard with statistics display:
  - Total inspections counter
  - Monthly inspections counter
  - Location-wise inspection status
  - Approval status indicators
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
  - Document number
  - Inspection location
  - Inspection date
  - Inspector details
  - APAR conditions
- Date validation
- Status validation
- Approval workflow validation

### Data Processing Requirements
- Automatic document number generation
- PDF report generation
- Monthly statistics calculation
- Data filtering and search
- Approval status tracking
- Date formatting and validation

### Business Logic
- Multi-level approval workflow:
  - Initial inspection
  - Supervisor review
  - Manager approval
- Location-based inspection tracking
- Monthly inspection requirements
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
#### Table: FM_SHE_036_INSPEKSI_APAR
- id (Primary Key)
- no_dok (Unique)
- lokasi_inspeksi
- tanggal
- dibuat_oleh
- diperiksa_oleh
- diketahui_oleh
- disetujui_oleh
- status (JSON)
- created_at
- updated_at

### API Endpoints

#### 1. Dashboard View
- **Route**: GET `/she-036/inspeksi-apar`
- **Name**: `bss-form.she-036.inspeksi-apar.dashboard`
- **Description**: Main dashboard interface
- **Query Parameters**:
  - `start_date` (date, optional): Filter by start date
  - `work_location` (string, optional): Filter by location
  - `search` (string, optional): Search by doc number or location
- **Response**: View with statistics and filtered records

#### 2. List Inspections
- **Route**: GET `/she-036/list-inspeksi-apar`
- **Name**: `bss-form.she-036.list-inspeksi-apar`
- **Description**: Get paginated list of inspections
- **Query Parameters**:
  - `sort` (string, optional): Sort field
  - `order` (string, optional): Sort order
  - `offset` (integer, optional): Pagination offset
  - `limit` (integer, optional): Items per page
- **Response**: JSON with inspection records

#### 3. Add Form
- **Route**: GET `/she-036/form-inspeksi-apar`
- **Name**: `bss-form.she-036.form-inspeksi-apar`
- **Description**: Display inspection form
- **Response**: Form view with inspection checklist

#### 4. Submit Form
- **Route**: POST `/she-036/add-inspeksi-apar`
- **Name**: `bss-form.she-036.add-inspeksi-apar`
- **Description**: Save new inspection
- **Request Body**:
  ```json
  {
    "no_dok": "string",
    "lokasi_inspeksi": "string",
    "tanggal": "date",
    "kondisi_apar": "json",
    "catatan": "string",
    "dibuat_oleh": "string"
  }
  ```
- **Response**: JSON response with status

#### 5. Update Record
- **Route**: POST `/she-036/update-inspeksi-apar`
- **Name**: `bss-form.she-036.update-inspeksi-apar`
- **Description**: Update existing inspection
- **Request Body**: Same as Submit Form
- **Response**: JSON response with status

#### 6. Delete Record
- **Route**: POST `/she-036/delete-inspeksi-apar`
- **Name**: `bss-form.she-036.delete-inspeksi-apar`
- **Description**: Delete inspection record
- **Request Body**:
  ```json
  {
    "id": "integer"
  }
  ```
- **Response**: JSON response with status

#### 7. Export PDF
- **Route**: GET `/she-036/pdf-inspeksi-apar/{id}`
- **Name**: `bss-form.she-036.pdf-inspeksi-apar`
- **Description**: Generate PDF report
- **Parameters**: 
  - `id` (integer): Record ID
- **Response**: PDF download

#### 8. Approval Endpoints
- **Approve**:
  - **Route**: POST `/she-036/approve-inspeksi-apar`
  - **Name**: `bss-form.she-036.approve-inspeksi-apar`
  - **Description**: Approve inspection
  - **Request Body**:
    ```json
    {
      "id": "integer",
      "diperiksa": "boolean?",
      "diketahui": "boolean?",
      "disetujui": "boolean?"
    }
    ```

- **Reject**:
  - **Route**: POST `/she-036/reject-inspeksi-apar`
  - **Name**: `bss-form.she-036.reject-inspeksi-apar`
  - **Description**: Reject inspection
  - **Request Body**: Same as Approve

- **Reset**:
  - **Route**: POST `/she-036/reset-inspeksi-apar/{id}`
  - **Name**: `bss-form.she-036.reset-inspeksi-apar`
  - **Description**: Reset approval status
  - **Parameters**: Record ID

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
4. Approval process
5. PDF generation

### Form Elements
- Text inputs
- Date pickers
- Location selectors
- Inspection checklists
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
- Business rule validation

### Data Storage
- Main record storage
- Status tracking
- Document numbering
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
7. Location filtering

### Test Scenarios
- Complete inspection record creation
- Invalid data handling
- PDF report generation
- Search and filter operations
- Approval process testing
- Status reset functionality
- Document number generation

### Acceptance Criteria
- Successful inspection record creation
- Accurate inspection data storage
- Proper PDF report generation
- Responsive UI
- Proper error handling
- Data integrity maintenance
- Working approval workflow
- Valid document number generation
