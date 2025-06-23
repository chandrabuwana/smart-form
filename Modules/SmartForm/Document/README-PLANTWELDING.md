# Plant Welding Module Documentation

## Document Overview
### Document Purpose
This document provides comprehensive documentation for the Plant Welding module, which manages welding inspections and standards across different sites and locations.

### Project Name
Plant Welding Management - Smart Form Module

### Version History
- v1.0.0 - Initial release
- Current Version: 1.0.0

### Document Status
Active/In Development

## Project Overview
### Project Description
The Plant Welding module is a specialized component for managing welding inspections and standards compliance. It handles detailed inspection records with a comprehensive 20-point questionnaire system, multi-level approval workflow, and site-specific monitoring.

### Project Scope
- Dashboard with advanced filtering
- Welding inspection form management
- Multi-level approval workflow (Pemeriksa & Atasan)
- PDF report generation
- Site and location tracking
- Installation type monitoring
- 20-point questionnaire system

### Project Goals
- Standardize welding inspections
- Maintain detailed inspection records
- Enable site and location-specific monitoring
- Facilitate PDF report generation
- Track inspection status
- Ensure compliance with welding standards

### Target Users
- Plant Inspectors (Pemeriksa)
- Supervisors (Atasan)
- Site Managers
- Quality Control Personnel
- Plant Maintenance Engineers

## Functional Requirements

### User Interface Requirements
- Dashboard with advanced filtering:
  - Document number search
  - Site name filter
  - Location filter
  - Installation type filter
  - Status filter (Approved, Rejected, Pending)
  - Date filter
  - Inspector filter
  - Supervisor filter
- Paginated data tables (10 items per page)
- Detailed inspection forms
- PDF export functionality
- Approval interface

### Form Validation Rules
- Required field validation for:
  - Document number
  - Site name
  - Location
  - Installation type
  - Inspector
  - Supervisor
  - Questionnaire responses
- Status validation
- Date and time validation

### Data Processing Requirements
- Automatic document number generation
- JSON data handling for questionnaires
- PDF report generation
- Complex status calculations
- Data filtering and pagination
- Manual pagination for filtered results

### Business Logic
- Document number format: BSS-FRM-PLA-045-YYMM-XXX
- Multi-level approval workflow:
  - Inspector (Pemeriksa) approval
  - Supervisor (Atasan) approval
- Final status calculation:
  - Both Approve = Approved
  - Both Reject = Rejected
  - Any Pending = Pending
  - Mixed Approve/Reject = Rejected
- 20-point questionnaire system

### Error Handling
- Database query exception handling
- PDF generation error management
- JSON parsing error handling
- User-friendly error messages
- Logging system integration
- Permission validation

## Technical Specifications

### Framework & Technologies
- Laravel Framework
- DomPDF for PDF generation
- MySQL Database
- Bootstrap UI
- JSON data storage
- LengthAwarePaginator for manual pagination

### Database Schema
#### Table: plant_welding
- id (Primary Key)
- doc_number (Unique)
- site_name
- location
- jenis_instalasi
- pemeriksa
- atasan
- status_pemeriksa
- status_atasan
- question1 (JSON)
- question2 (JSON)
- question3 (JSON)
- question4 (JSON)
- question5 (JSON)
- question6 (JSON)
- question7 (JSON)
- question8 (JSON)
- question9 (JSON)
- question10 (JSON)
- question11 (JSON)
- question12 (JSON)
- question13 (JSON)
- question14 (JSON)
- question15 (JSON)
- question16 (JSON)
- question17 (JSON)
- question18 (JSON)
- question19 (JSON)
- question20 (JSON)
- created_at
- updated_at

### API Endpoints

#### 1. Dashboard View
- **Route**: GET `/plant-welding/dashboard`
- **Name**: `plant.welding.dashboard`
- **Description**: Main dashboard interface
- **Query Parameters**:
  - `search` (string, optional): Search by doc number, site name, location, or installation type
  - `location` (string, optional): Filter by location
  - `site_name` (string, optional): Filter by site name
  - `date` (date, optional): Filter by date
  - `pemeriksa` (string, optional): Filter by inspector
  - `atasan` (string, optional): Filter by supervisor
  - `status` (string, optional): Filter by final status
- **Response**: View with paginated and filtered records

#### 2. Add Form
- **Route**: GET `/plant-welding/add`
- **Name**: `plant.welding.add`
- **Description**: Display form for creating new inspection
- **Response**: Form view with questionnaire

#### 3. Store Record
- **Route**: POST `/plant-welding/store`
- **Name**: `plant.welding.store`
- **Description**: Save new inspection record
- **Request Body**:
  ```json
  {
    "site_name": "string",
    "location": "string",
    "jenis_instalasi": "string",
    "pemeriksa": "string",
    "atasan": "string",
    "question1": "array",
    "question2": "array",
    "question3": "array",
    "question4": "array",
    "question5": "array",
    "question6": "array",
    "question7": "array",
    "question8": "array",
    "question9": "array",
    "question10": "array",
    "question11": "array",
    "question12": "array",
    "question13": "array",
    "question14": "array",
    "question15": "array",
    "question16": "array",
    "question17": "array",
    "question18": "array",
    "question19": "array",
    "question20": "array"
  }
  ```
- **Response**: JSON response with status

#### 4. Edit Form
- **Route**: GET `/plant-welding/edit/{id}`
- **Name**: `plant.welding.edit`
- **Description**: Display form for editing inspection
- **Parameters**: 
  - `id` (integer): Record ID
- **Response**: Form view with existing data

#### 5. Update Record
- **Route**: PUT `/plant-welding/update/{id}`
- **Name**: `plant.welding.update`
- **Description**: Update existing record
- **Parameters**: 
  - `id` (integer): Record ID
- **Request Body**: Same as Store Record
- **Response**: JSON response with status

#### 6. Delete Record
- **Route**: DELETE `/plant-welding/delete/{id}`
- **Name**: `plant.welding.delete`
- **Description**: Delete inspection record
- **Parameters**:
  - `id` (integer): Record ID
- **Response**: JSON response with status

#### 7. Export PDF
- **Route**: GET `/plant-welding/export/{id}`
- **Name**: `plant.welding.export`
- **Description**: Generate PDF report
- **Parameters**: 
  - `id` (integer): Record ID
- **Response**: PDF download (Portrait orientation)

#### 8. Approval Endpoints
- **View Approval**:
  - **Route**: GET `/plant-welding/approval/{id}`
  - **Name**: `plant.welding.approval`
  - **Description**: View approval page
  - **Parameters**: Record ID
  - **Response**: Approval view with record details

- **Approve**:
  - **Route**: POST `/plant-welding/approve/{id}`
  - **Name**: `plant.welding.approve`
  - **Description**: Approve inspection record
  - **Parameters**: Record ID
  - **Response**: JSON response with status

- **Reject**:
  - **Route**: POST `/plant-welding/reject/{id}`
  - **Name**: `plant.welding.reject`
  - **Description**: Reject inspection record
  - **Parameters**: Record ID
  - **Response**: JSON response with status

### Integration Points
- HRD System for approval lists
- PDF Generation System
- Logging System
- Frontend UI

### Security Requirements
- Authentication required
- Role-based access control
- CSRF protection
- Input validation
- Secure file handling
- Permission-based approval system

## User Interface Design

### Layout Specifications
- Responsive dashboard
- Advanced filter section
- Data table component
- Questionnaire form layout
- PDF preview
- Approval interface

### Navigation Flow
1. Dashboard view
2. Record creation/editing
3. Form submission
4. Approval process
5. PDF generation

### Form Elements
- Text inputs
- Dropdown selections
- Date pickers
- 20-point questionnaire
- Approval buttons
- Status indicators

### Messages
- Success notifications
- Error alerts
- Validation messages
- Processing indicators
- Permission warnings

## Data Flow

### Data Input Process
1. Form submission
2. Data validation
3. JSON processing
4. Status calculation
5. Database storage
6. PDF generation

### Data Validation
- Required fields checking
- Status validation
- Permission validation
- Date format validation
- Business rule validation

### Data Storage
- Main record storage
- JSON questionnaire data
- Document numbering
- Status tracking
- Audit logging

### Data Retrieval
- Complex filtered queries
- Manual pagination
- PDF generation
- Status calculations

## Testing Requirements

### Test Cases
1. Form submission validation
2. Status calculation logic
3. PDF generation
4. Filter functionality
5. CRUD operations
6. Approval workflow
7. Permission system

### Test Scenarios
- Complete inspection record creation
- Invalid data handling
- PDF report generation
- Search and filter operations
- Approval process testing
- Permission validation
- Status calculation verification

### Acceptance Criteria
- Successful inspection record creation
- Accurate questionnaire storage
- Proper PDF report generation
- Responsive UI
- Proper error handling
- Data integrity maintenance
- Working approval workflow
- Correct status calculation
- Proper permission enforcement
