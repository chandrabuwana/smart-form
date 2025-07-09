# PPU XCMG XE1250 Module Documentation

## Document Overview
### Document Purpose
This document provides comprehensive documentation for the PPU XCMG XE1250 module, which manages periodic part usage inspections for XCMG XE1250 excavators.

### Project Name
PPU XCMG XE1250 Management - Smart Form Module

### Version History
- v1.0.0 - Initial release
- Current Version: 1.0.0

### Document Status
Active/In Development

## Project Overview
### Project Description
The PPU XCMG XE1250 module is a specialized component for managing periodic part usage inspections of XCMG XE1250 excavators. It handles detailed measurements and inspections of undercarriage components including link pitch, grouser height, rollers, and sprockets.

### Project Scope
- Dashboard with statistical overview
- Equipment inspection form management
- Multi-level approval workflow
- PDF report generation
- Equipment tracking by CN unit
- Site-specific monitoring
- Comprehensive measurement tracking

### Project Goals
- Streamline XCMG XE1250 part usage inspections
- Track component measurements over time
- Enable site-specific monitoring
- Facilitate PDF report generation
- Monitor equipment performance
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
- Advanced filtering capabilities:
  - Document number search
  - CN unit filter
  - SMR/HM filter
  - Job site filter
  - Validation status filter
- Paginated data tables (5 items per page)
- Detailed inspection forms
- PDF export functionality

### Form Validation Rules
- Required field validation for:
  - Document number
  - CN unit
  - Job site
  - SMR/HM
  - Work operation
  - Ground condition
  - Inspection measurements
- JSON data structure validation for measurement items
- Date and time validation

### Data Processing Requirements
- Automatic document number generation
- JSON data handling for measurement items
- PDF report generation
- Monthly statistics calculation
- Data filtering and pagination

### Business Logic
- Document number format: BSS-FRM-PLA-083-YYMM-XXX
- Multi-section measurement form:
  - Link measurements (pitch, height, bushing)
  - Grouser height measurements
  - Idler measurements
  - Sprocket measurements
  - Carrier roller measurements
  - Track roller measurements
- Approval workflow system
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
#### Table: ppu_xe1250
- id (Primary Key)
- doc_number (Unique)
- unit_model (Fixed: 'XCMG XE1250')
- inspection_date
- cn_unit
- job_site
- smr_hm
- work_operation
- ground_condition
- condition_area
- content_summary
- checked_1
- checked_2
- validated
- creator
- status
- date_checked
- date_validated
- created_at
- updated_at

#### Table: detail_ppu_xe1250
- id (Primary Key)
- doc_number_id (Foreign Key)
- link_pitch (JSON)
- link_height (JSON)
- link_bushing (JSON)
- grouser_height (JSON)
- idler (JSON)
- sprocket (JSON)
- carrier_roller1 (JSON)
- carrier_roller2 (JSON)
- carrier_roller3 (JSON)
- track_roller (JSON)
- tem_link_pitch (JSON)
- tem_link_height (JSON)
- tem_link_bushing (JSON)
- tem_grouser_height (JSON)
- tem_idler (JSON)
- tem_sprocket (JSON)
- tem_carrier_roller (JSON)
- tem_track_roller (JSON)
- created_at
- updated_at

### API Endpoints

#### 1. Dashboard View
- **Route**: GET `/ppu-xe1250/dashboard`
- **Name**: `plant.ppu.xe1250.dashboard`
- **Description**: Main dashboard interface
- **Query Parameters**:
  - `search` (string, optional): Search by doc number, CN unit, or SMR/HM
  - `cn_unit` (string, optional): Filter by CN unit
  - `job_site` (string, optional): Filter by job site
  - `validated` (string, optional): Filter by validation status
- **Response**: View with statistics and filtered records
- **Response Data**:
  ```json
  {
    "cn": "[Equipment data array]",
    "record": "[Paginated records]",
    "statistics": {
      "total_records": "integer",
      "total_this_month": "integer"
    },
    "session": "user_id",
    "user": "[Approval list]",
    "filters": {
      "search": "string",
      "cn_unit": "string",
      "job_site": "string",
      "approval": "string"
    }
  }
  ```

#### 2. Add Form
- **Route**: GET `/ppu-xe1250/add`
- **Name**: `plant.ppu.xe1250.add`
- **Description**: Display form for creating new inspection
- **Response**: Form view with equipment data and approval list
- **Response Data**:
  ```json
  {
    "cn": "[Equipment data array]",
    "nik": "user_id",
    "approvalList": "[List of approvers]"
  }
  ```

#### 3. Store Record
- **Route**: POST `/ppu-xe1250/store`
- **Name**: `plant.ppu.xe1250.store`
- **Description**: Save new inspection record
- **Request Body**:
  ```json
  {
    "ins_date": "date",
    "cn_unit": "string",
    "job_site": "string",
    "smr": "string",
    "work_op": "string",
    "ground_condition": "string",
    "condition_area": "string",
    "summary": "string",
    "checked1": "string",
    "checked2": "string",
    "validated": "string",
    "link_pitch": "array",
    "link_Height": "array",
    "link_bushing": "array",
    "grouser_height": "array",
    "idler": "array",
    "sprocket": "array",
    "carrier_roller1": "array",
    "carrier_roller2": "array",
    "carrier_roller3": "array",
    "track_roller": "array",
    "tem_link_pitch": "array",
    "tem_link_height": "array",
    "tem_link_bushing": "array",
    "tem_grouser_height": "array",
    "tem_idler": "array",
    "tem_sprocket": "array",
    "tem_carrier_roller": "array",
    "tem_track_roller": "array"
  }
  ```
- **Response**: JSON response with status

#### 4. Detail View
- **Route**: GET `/ppu-xe1250/detail/{id}`
- **Name**: `plant.ppu.xe1250.detail`
- **Description**: View detailed inspection record
- **Parameters**: 
  - `id` (integer): Record ID
- **Response**: Detailed inspection data with decoded JSON fields

#### 5. Show Record
- **Route**: GET `/ppu-xe1250/show/{id}`
- **Name**: `plant.ppu.xe1250.show`
- **Description**: Show inspection record details
- **Parameters**:
  - `id` (integer): Record ID
  - `request` (Request): Additional request data
- **Response**: View with detailed record data

#### 6. Update Record
- **Route**: POST `/ppu-xe1250/update`
- **Name**: `plant.ppu.xe1250.update`
- **Description**: Update existing record
- **Request Body**: Same as Store Record
- **Response**: JSON response with status

#### 7. Delete Record
- **Route**: DELETE `/ppu-xe1250/delete/{id}`
- **Name**: `plant.ppu.xe1250.delete`
- **Description**: Remove inspection record
- **Parameters**:
  - `id` (string): Document number
- **Response**: JSON response with status

#### 8. Export PDF
- **Route**: GET `/ppu-xe1250/export/{id}`
- **Name**: `plant.ppu.xe1250.export`
- **Description**: Generate PDF report
- **Parameters**: 
  - `id` (integer): Record ID
- **Response**: PDF download

#### 9. Approval Endpoints
- **Approve**:
  - **Route**: POST `/ppu-xe1250/approve`
  - **Name**: `plant.ppu.xe1250.approve`
  - **Description**: Approve inspection record
  - **Request Body**: Document number and approver details
  - **Response**: JSON response with status

- **Reject**:
  - **Route**: POST `/ppu-xe1250/reject`
  - **Name**: `plant.ppu.xe1250.reject`
  - **Description**: Reject inspection record
  - **Request Body**: Document number and rejection reason
  - **Response**: JSON response with status

- **Reset**:
  - **Route**: POST `/ppu-xe1250/reset/{id}`
  - **Name**: `plant.ppu.xe1250.reset`
  - **Description**: Reset approval status
  - **Parameters**: Document number
  - **Response**: JSON response with status

### Integration Points
- Equipment Database (alat_angkut_data)
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
- Measurement form layout
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
- Numeric inputs for measurements
- Multiple measurement sets
- Approval checkboxes

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
- Measurement range validation
- Date format validation
- Business rule validation

### Data Storage
- Main record storage
- Detail record storage with JSON measurements
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
2. Measurement data validation
3. PDF generation
4. Filter functionality
5. CRUD operations
6. Approval workflow

### Test Scenarios
- Complete inspection record creation
- Invalid measurement handling
- PDF report generation
- Search and filter operations
- Approval process testing

### Acceptance Criteria
- Successful inspection record creation
- Accurate measurement storage
- Proper PDF report generation
- Responsive UI
- Proper error handling
- Data integrity maintenance
- Working approval workflow
