# SHE-048 Catering Inspection Module Documentation

## Document Overview
### Document Purpose
This document provides comprehensive documentation for the SHE-048 Catering Inspection module, which manages food safety and hygiene inspections for catering facilities across different sites.

### Project Name
Catering Inspection Management - Smart Form Module SHE-048

### Version History
- v1.0.0 - Initial release
- Current Version: 1.0.0

### Document Status
Active/In Development

## Project Overview
### Project Description
The SHE-048 Catering Inspection module is a critical health and safety component that manages and tracks catering facility inspections across various work locations. It ensures compliance with food safety standards and hygiene regulations.

### Project Scope
- Dashboard with inspection statistics
- Catering inspection form management
- Multi-inspector approval workflow
- PDF report generation
- Site-specific monitoring
- Monthly inspection tracking
- Comprehensive inspection checklist

### Project Goals
- Ensure regular catering inspections
- Maintain food safety standards
- Enable site-specific monitoring
- Track inspection compliance
- Generate inspection reports
- Support multi-inspector approvals

### Target Users
- Safety Officers
- Health Inspectors
- Site Supervisors
- Catering Managers
- Safety Managers
- Compliance Officers

## Functional Requirements

### User Interface Requirements
- Dashboard with statistics display:
  - Total inspections counter
  - Monthly inspections counter
  - Site-wise inspection status
  - Approval status indicators
- Advanced filtering capabilities:
  - Date range filter
  - Work location filter
  - Site name search
  - Status filter
- Inspection form interface
- PDF export functionality
- Multi-inspector approval interface

### Form Validation Rules
- Required field validation for:
  - Site name
  - Work location
  - Inspection date
  - Inspector details
  - Inspection checklist items
- Date validation
- Status validation
- Multi-inspector workflow validation

### Data Processing Requirements
- Automatic document number generation
- PDF report generation
- Monthly statistics calculation
- Data filtering and search
- Approval status tracking
- Inspector assignment tracking

### Business Logic
- Three-level inspector approval workflow:
  - Initial inspection
  - Secondary review
  - Final verification
- Site-based inspection tracking
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
#### Table: FM_SHE_048_INSPEKSI_CATERING
- id (Primary Key)
- nama_site
- lokasi_kerja
- tanggal_form
- diinspeksi_oleh_1
- diinspeksi_oleh_2
- diinspeksi_oleh_3
- status (JSON)
- created_at
- updated_at

### API Endpoints

#### 1. Dashboard View
- **Route**: GET `/she-048/inspeksi-catering`
- **Name**: `bss-form.she-048.inspeksi-catering.dashboard`
- **Description**: Main dashboard interface
- **Query Parameters**:
  - `start_date` (date, optional): Filter by start date
  - `work_location` (string, optional): Filter by location
  - `search` (string, optional): Search by site name or location
- **Response**: View with statistics and filtered records

#### 2. List Inspections
- **Route**: GET `/she-048/list-inspeksi-catering`
- **Name**: `bss-form.she-048.list-inspeksi-catering`
- **Description**: Get paginated list of inspections
- **Query Parameters**:
  - `sort` (string, optional): Sort field
  - `order` (string, optional): Sort order
  - `offset` (integer, optional): Pagination offset
  - `limit` (integer, optional): Items per page
- **Response**: JSON with inspection records

#### 3. Add Form
- **Route**: GET `/she-048/form-inspeksi-catering`
- **Name**: `bss-form.she-048.form-inspeksi-catering`
- **Description**: Display inspection form
- **Response**: Form view with inspection checklist

#### 4. Submit Form
- **Route**: POST `/she-048/create-inspeksi-catering`
- **Name**: `bss-form.she-048.create-inspeksi-catering`
- **Description**: Save new inspection
- **Request Body**:
  ```json
  {
    "nama_site": "string",
    "lokasi_kerja": "string",
    "tanggal_form": "date",
    "checklist_items": "json",
    "catatan": "string",
    "diinspeksi_oleh_1": "string"
  }
  ```
- **Response**: JSON response with status

#### 5. Update Record
- **Route**: POST `/she-048/update-inspeksi-catering`
- **Name**: `bss-form.she-048.update-inspeksi-catering`
- **Description**: Update existing inspection
- **Request Body**: Same as Submit Form
- **Response**: JSON response with status

#### 6. Delete Record
- **Route**: POST `/she-048/delete-inspeksi-catering`
- **Name**: `bss-form.she-048.delete-inspeksi-catering`
- **Description**: Delete inspection record
- **Request Body**:
  ```json
  {
    "id": "integer"
  }
  ```
- **Response**: JSON response with status

#### 7. Export PDF
- **Route**: GET `/she-048/pdf-inspeksi-catering/{id}`
- **Name**: `bss-form.she-048.pdf-inspeksi-catering`
- **Description**: Generate PDF report
- **Parameters**: 
  - `id` (integer): Record ID
- **Response**: PDF download

#### 8. Approval Endpoints
- **Approve**:
  - **Route**: POST `/she-048/approve-inspeksi-catering`
  - **Name**: `bss-form.she-048.approve-inspeksi-catering`
  - **Description**: Approve inspection
  - **Request Body**:
    ```json
    {
      "id": "integer",
      "position": "integer",
      "nik": "string"
    }
    ```

- **Reject**:
  - **Route**: POST `/she-048/reject-inspeksi-catering`
  - **Name**: `bss-form.she-048.reject-inspeksi-catering`
  - **Description**: Reject inspection
  - **Request Body**: Same as Approve

- **Reset**:
  - **Route**: POST `/she-048/reset-inspeksi-catering/{id}`
  - **Name**: `bss-form.she-048.reset-inspeksi-catering`
  - **Description**: Reset approval status
  - **Parameters**: Record ID

### Integration Points
- HRD System for user validation
- Site Management System
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
- Site selectors
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
- Inspector tracking
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
7. Site filtering

### Test Scenarios
- Complete inspection record creation
- Invalid data handling
- PDF report generation
- Search and filter operations
- Multi-inspector approval process
- Status reset functionality
- Site-specific validation

### Acceptance Criteria
- Successful inspection record creation
- Accurate inspection data storage
- Proper PDF report generation
- Responsive UI
- Proper error handling
- Data integrity maintenance
- Working multi-inspector workflow
- Valid site and location tracking
