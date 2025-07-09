# PPM Shantui DH24 Module Documentation

## Document Overview
### Document Purpose
This document provides comprehensive documentation for the PPM Shantui DH24 module, which manages preventive maintenance inspections for Shantui DH24 equipment.

### Project Name
PPM Shantui DH24 Management - Smart Form Module

### Version History
- v1.0.0 - Initial release
- Current Version: 1.0.0

### Document Status
Active/In Development

## Project Overview
### Project Description
The PPM Shantui DH24 module is a specialized component for managing preventive maintenance inspections of Shantui DH24 equipment. It handles detailed inspection records including engine checks, hydraulic systems, work orders, and final inspections.

### Project Scope
- Dashboard with statistical overview
- Equipment inspection form management
- Multi-level approval workflow
- PDF report generation
- Equipment tracking by model and serial number
- Site-specific monitoring
- Comprehensive inspection questionnaire

### Project Goals
- Streamline Shantui DH24 maintenance inspections
- Maintain detailed maintenance records
- Enable site-specific monitoring
- Facilitate PDF report generation
- Track equipment performance
- Ensure standardized inspection procedures

### Target Users
- Plant Maintenance Engineers
- Equipment Inspectors
- Site Supervisors
- Maintenance Managers
- Quality Control Personnel

## Functional Requirements

### User Interface Requirements
- Dashboard with statistics display:
  - Total records counter
  - Monthly records counter
  - Engine model counter
  - Job site counter
- Advanced filtering capabilities:
  - Document number search
  - Unit model search
  - Engine model filter
  - Job site filter
  - Approval status filter
- Paginated data tables (5 items per page)
- Detailed inspection forms
- PDF export functionality

### Form Validation Rules
- Required field validation for:
  - Document number
  - Unit model
  - Unit serial number
  - Engine model
  - Job site
  - Inspection details
- JSON data structure validation for inspection items
- Date and time validation

### Data Processing Requirements
- Automatic document number generation
- JSON data handling for inspection items
- PDF report generation
- Monthly statistics calculation
- Data filtering and pagination

### Business Logic
- Document number format: BSS-FRM-PLA-075-YYMM-XXX
- Multi-section inspection form:
  - Engine inspection
  - Hydraulic system inspection
  - Work order inspection
  - Final inspection
- Approval workflow system with dual validation
- Equipment data integration

### Error Handling
- Database query exception handling
- PDF generation error management
- JSON parsing error handling
- User-friendly error messages
- Logging system integration

## Technical Specifications

### Framework & Technologies
- Laravel Framework
- DomPDF for PDF generation
- MySQL Database
- Bootstrap UI
- JSON data storage

### Database Schema
#### Table: ppm_dh24
- id (Primary Key)
- doc_num (Unique)
- unit_model
- unit_sn
- engine_model
- engine_sn
- engine_hours
- job_site
- job_location
- at_inspection
- date
- note
- checked_by
- validated_by
- status (JSON)
- delete_status
- created_at
- updated_at

#### Table: detail_ppm_dh24
- id (Primary Key)
- doc_num_id (Foreign Key)
- eng_actual (JSON)
- eng_correction_made (JSON)
- eng_result (JSON)
- eng_pr (JSON)
- eng_taggal (JSON)
- eng_remark (Text)
- hyd_actual (JSON)
- hyd_correction_made (JSON)
- hyd_result (JSON)
- hyd_pr (JSON)
- hyd_taggal (JSON)
- hyd_remark (Text)
- wo_actual (JSON)
- wo_correction_made (JSON)
- wo_result (JSON)
- wo_pr (JSON)
- wo_taggal (JSON)
- wo_remark (Text)
- fin_actual (JSON)
- fin_correction_made (JSON)
- fin_result (JSON)
- fin_pr (JSON)
- fin_taggal (JSON)
- fin_remark (Text)
- created_at
- updated_at

### API Endpoints

#### 1. Dashboard View
- **Route**: GET `/ppm-dh24/dashboard`
- **Name**: `plant.ppm.dh24.dashboard`
- **Description**: Main dashboard interface
- **Query Parameters**:
  - `search` (string, optional): Search by doc number, unit model, engine model, or job site
  - `engine_model` (string, optional): Filter by engine model
  - `job_site` (string, optional): Filter by job site
  - `approval` (string, optional): Filter by approval status
- **Response**: View with statistics and filtered records
- **Response Data**:
  ```json
  {
    "record": "[Paginated records]",
    "statistics": {
      "total_records": "integer",
      "total_this_month": "integer",
      "engine_model": "integer",
      "job_site": "integer"
    },
    "session": "user_id",
    "user": "[Approval list]",
    "filters": {
      "search": "string",
      "engine_model": "string",
      "job_site": "string",
      "approval": "string"
    }
  }
  ```

#### 2. Add Form
- **Route**: GET `/ppm-dh24/add`
- **Name**: `plant.ppm.dh24.add`
- **Description**: Display form for creating new inspection
- **Response**: Form view with inspection checklist and approval list
- **Response Data**:
  ```json
  {
    "list": "[Inspection checklist JSON]",
    "approvalList": "[List of approvers]"
  }
  ```

#### 3. Store Record
- **Route**: POST `/ppm-dh24/store`
- **Name**: `plant.ppm.dh24.store`
- **Description**: Save new inspection record
- **Request Body**:
  ```json
  {
    "unit_model": "string",
    "unit_sn": "string",
    "engine_model": "string",
    "engine_sn": "string",
    "engine_hours": "integer",
    "job_site": "string",
    "job_location": "string",
    "at_inspection": "string",
    "date": "date",
    "note": "string",
    "checked_by": "string",
    "validated_by": "string",
    "eng_actual": "array",
    "eng_correction": "array",
    "eng_result": "array",
    "eng_pr": "array",
    "eng_taggal": "array",
    "eng_remark": "string",
    "hyd_actual": "array",
    "hyd_correction": "array",
    "hyd_result": "array",
    "hyd_pr": "array",
    "hyd_taggal": "array",
    "hyd_remark": "string",
    "wo_actual": "array",
    "wo_correction": "array",
    "wo_result": "array",
    "wo_pr": "array",
    "wo_taggal": "array",
    "wo_remark": "string",
    "fin_actual": "array",
    "fin_correction": "array",
    "fin_result": "array",
    "fin_pr": "array",
    "fin_taggal": "array",
    "fin_remark": "string"
  }
  ```
- **Response**: JSON response with status

#### 4. Update Record
- **Route**: POST `/ppm-dh24/update`
- **Name**: `plant.ppm.dh24.update`
- **Description**: Update existing record
- **Request Body**: Same as Store Record
- **Response**: JSON response with status

#### 5. Detail View
- **Route**: GET `/ppm-dh24/detail/{id}`
- **Name**: `plant.ppm.dh24.detail`
- **Description**: View detailed inspection record
- **Parameters**: 
  - `id` (integer): Record ID
- **Response**: Detailed inspection data with decoded JSON fields

#### 6. Show Record
- **Route**: GET `/ppm-dh24/show/{id}`
- **Name**: `plant.ppm.dh24.show`
- **Description**: Show inspection record details
- **Parameters**:
  - `id` (integer): Record ID
  - `request` (Request): Additional request data
- **Response**: View with detailed record data

#### 7. Export PDF
- **Route**: GET `/ppm-dh24/export/{id}`
- **Name**: `plant.ppm.dh24.export`
- **Description**: Generate PDF report
- **Parameters**: 
  - `id` (integer): Record ID
- **Response**: PDF download

#### 8. Delete Record
- **Route**: DELETE `/ppm-dh24/delete/{id}`
- **Name**: `plant.ppm.dh24.delete`
- **Description**: Soft delete inspection record
- **Parameters**:
  - `id` (string): Document number
- **Response**: JSON response with status

#### 9. Approval Endpoints
- **Approve**:
  - **Route**: POST `/ppm-dh24/approve`
  - **Name**: `plant.ppm.dh24.approve`
  - **Description**: Approve inspection record
  - **Request Body**: 
    ```json
    {
      "doc_num": "string",
      "checked": "string",
      "validated": "string"
    }
    ```
  - **Response**: JSON response with status

- **Reject**:
  - **Route**: POST `/ppm-dh24/reject`
  - **Name**: `plant.ppm.dh24.reject`
  - **Description**: Reject inspection record
  - **Request Body**: Same as Approve
  - **Response**: JSON response with status

- **Reset**:
  - **Route**: POST `/ppm-dh24/reset/{id}`
  - **Name**: `plant.ppm.dh24.reset`
  - **Description**: Reset approval status
  - **Parameters**: Document number
  - **Response**: JSON response with status

### Integration Points
- Equipment Database
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
2. Record creation/editing
3. Form submission
4. Approval process
5. PDF generation

### Form Elements
- Text inputs
- Dropdown selections
- Date pickers
- Checkbox groups
- Radio button sets
- JSON-based inspection forms

### Messages
- Success notifications
- Error alerts
- Validation messages
- Processing indicators

## Data Flow

### Data Input Process
1. Form submission
2. Data validation
3. JSON processing
4. Database storage
5. PDF generation

### Data Validation
- Required fields checking
- JSON structure validation
- Date format validation
- Business rule validation

### Data Storage
- Main record storage
- Detail record storage
- JSON data fields
- Document numbering
- Audit logging

### Data Retrieval
- Paginated queries
- Filtered searches
- PDF generation
- Statistical calculations

## Testing Requirements

### Test Cases
1. Form submission validation
2. PDF generation
3. JSON data handling
4. Filter functionality
5. CRUD operations
6. Approval workflow
7. Soft delete functionality

### Test Scenarios
- Complete inspection record creation
- Invalid data handling
- PDF report generation
- Search and filter operations
- Approval process testing
- Soft delete and restoration

### Acceptance Criteria
- Successful inspection record creation
- Accurate inspection data storage
- Proper PDF report generation
- Responsive UI
- Proper error handling
- Data integrity maintenance
- Working approval workflow
- Proper soft delete functionality
