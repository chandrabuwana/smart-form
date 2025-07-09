# General Inspection Dongfeng Module Documentation

## Document Overview
### Document Purpose
This document provides comprehensive documentation for the General Inspection Dongfeng module, which manages Dongfeng equipment inspections across multiple sites.

### Project Name
General Inspection Dongfeng Management - Smart Form Module

### Version History
- v1.0.0 - Initial release
- Current Version: 1.0.0

### Document Status
Active/In Development

## Project Overview
### Project Description
The General Inspection Dongfeng module is a specialized component for managing Dongfeng equipment inspections across multiple sites. It handles detailed inspection records with activity checklists, inspection results, and a multi-level approval workflow.

### Project Scope
- Dashboard with statistical overview
- Activity checklist management
- Inspection result tracking
- Multi-level approval workflow
- PDF report generation
- Site-specific monitoring
- Equipment performance tracking

### Project Goals
- Standardize Dongfeng equipment inspections
- Track equipment performance
- Enable site-specific monitoring
- Maintain detailed inspection records
- Facilitate PDF report generation
- Ensure quality control compliance

### Target Users
- Equipment Inspectors
- Site Supervisors
- Quality Control Personnel
- Plant Maintenance Engineers
- Site Managers

## Functional Requirements

### User Interface Requirements
- Dashboard with statistics display:
  - Total records counter
  - Monthly records counter
  - Model unit counter
- Advanced filtering capabilities:
  - Site filter (PMSS, MAS, MME, BRAM, TAJ, AGM, MSJ, TDM, BSSR, MBLM, MBLH, others)
  - Status filter
  - Date filter
  - Model filter
  - Search functionality
- Paginated data tables (10 items per page)
- Detailed inspection forms
- PDF export functionality
- Approval interface

### Form Validation Rules
- Required field validation for:
  - Site
  - Model unit
  - CN (Unit number)
  - HM (Hour meter)
  - Activity checklist
  - Inspection results
- Status validation
- Date and time validation

### Data Processing Requirements
- JSON data handling for:
  - Activity checklists
  - Inspection results
  - Status tracking
- PDF report generation
- Statistics calculation
- Data filtering and pagination

### Business Logic
- Multi-level approval workflow:
  - Creator
  - Inspector (Diperiksa)
  - Supervisor (Diketahui)
- Status tracking:
  - Draft
  - Approved
  - Rejected
- Three-phase inspection:
  - Pre-inspection
  - Final inspection
  - Delivery inspection
- Site-based access control

### Error Handling
- Database transaction management
- JSON parsing error handling
- User-friendly error messages
- Logging system integration
- Permission validation

## Technical Specifications

### Framework & Technologies
- Laravel Framework
- DomPDF for PDF generation
- MySQL Database
- JSON data storage
- Bootstrap UI

### Database Schema
#### Table: plant_general_inspection_dongfeng
- id (Primary Key)
- creator
- diperiksa (Inspector)
- diketahui (Supervisor)
- status (JSON)
- status_form
- site
- model_unit
- cn (Unit number)
- hm (Hour meter)
- date_sign2
- date_sign3
- created_at
- updated_at

#### Table: plant_general_inspection_dongfeng_activity
- id (Primary Key)
- dongfeng_id (Foreign Key)
- category
- activity
- pre_inspect
- final_inspect
- delivery_inspect
- created_at
- updated_at

#### Table: plant_general_inspection_dongfeng_result
- id (Primary Key)
- dongfeng_id (Foreign Key)
- component
- performance
- remark
- created_at
- updated_at

### API Endpoints

#### 1. Dashboard View
- **Route**: GET `/plant/general-inspection/dongfeng`
- **Name**: `bss-form.plant.general-inspection.dongfeng.index`
- **Description**: Main dashboard interface
- **Response**: View with statistics and filters
- **Response Data**:
  ```json
  {
    "statistics": {
      "total_records": "integer",
      "total_this_month": "integer",
      "model_unit": "integer"
    },
    "sites": ["PMSS", "MAS", "MME", "BRAM", "TAJ", "AGM", "MSJ", "TDM", "BSSR", "MBLM", "MBLH", "others"],
    "approvalList": "[List of approvers]",
    "session": "user_id"
  }
  ```

#### 2. Get Data
- **Route**: GET `/plant/general-inspection/dongfeng/data`
- **Name**: `bss-form.plant.general-inspection.dongfeng.data`
- **Description**: Get filtered and paginated data
- **Query Parameters**:
  - `search` (string, optional)
  - `sort` (string, default: created_at)
  - `order` (string, default: desc)
  - `site` (string, optional)
  - `status` (string, optional)
  - `date` (date, optional)
  - `model` (string, optional)
- **Response**: Paginated inspection records

#### 3. Create Form
- **Route**: GET `/plant/general-inspection/dongfeng/create`
- **Name**: `bss-form.plant.general-inspection.dongfeng.create`
- **Description**: Display form for creating new inspection
- **Response**: Form view with activity checklist and inspection result templates

#### 4. Store Record
- **Route**: POST `/plant/general-inspection/dongfeng`
- **Name**: `bss-form.plant.general-inspection.dongfeng.store`
- **Description**: Save new inspection record
- **Request Body**:
  ```json
  {
    "site": "string",
    "model_unit": "string",
    "cn": "string",
    "hm": "string",
    "activities": [{
      "category": "string",
      "activity": "string",
      "pre_inspect": "boolean",
      "final_inspect": "boolean",
      "delivery_inspect": "boolean"
    }],
    "results": [{
      "component": "string",
      "performance": "string",
      "remark": "string"
    }]
  }
  ```
- **Response**: Redirect with status

#### 5. Show Record
- **Route**: GET `/plant/general-inspection/dongfeng/{id}`
- **Name**: `bss-form.plant.general-inspection.dongfeng.show`
- **Description**: Show inspection record details
- **Parameters**: Record ID
- **Response**: View with detailed record data

#### 6. Edit Form
- **Route**: GET `/plant/general-inspection/dongfeng/{id}/edit`
- **Name**: `bss-form.plant.general-inspection.dongfeng.edit`
- **Description**: Display form for editing inspection
- **Parameters**: Record ID
- **Response**: Form view with existing data

#### 7. Update Record
- **Route**: PUT `/plant/general-inspection/dongfeng/{id}`
- **Name**: `bss-form.plant.general-inspection.dongfeng.update`
- **Description**: Update existing record
- **Parameters**: Record ID
- **Request Body**: Same as Store Record
- **Response**: Redirect with status

#### 8. Delete Record
- **Route**: DELETE `/plant/general-inspection/dongfeng/{id}`
- **Name**: `bss-form.plant.general-inspection.dongfeng.destroy`
- **Description**: Delete inspection record and related data
- **Parameters**: Record ID
- **Response**: Redirect with status

#### 9. Print Record
- **Route**: GET `/plant/general-inspection/dongfeng/{id}/print`
- **Name**: `bss-form.plant.general-inspection.dongfeng.print`
- **Description**: Generate printable view
- **Parameters**: Record ID
- **Response**: Print template view

#### 10. Approval Endpoints
- **Approve**:
  - **Route**: POST `/plant/general-inspection/dongfeng/approve`
  - **Description**: Approve inspection record
  - **Request Body**:
    ```json
    {
      "id": "integer",
      "diketahui": "string",
      "diperiksa": "string",
      "date2": "boolean",
      "date3": "boolean"
    }
    ```
  - **Response**: JSON response with status

- **Reset**:
  - **Route**: POST `/plant/general-inspection/dongfeng/reset/{id}`
  - **Description**: Reset approval status
  - **Parameters**: Record ID
  - **Response**: JSON response with status

- **Reject**:
  - **Route**: POST `/plant/general-inspection/dongfeng/reject`
  - **Description**: Reject inspection record
  - **Request Body**: Same as Approve
  - **Response**: JSON response with status

### Integration Points
- HRD System for approval lists
- JSON activity checklist template
- JSON inspection result template
- PDF Generation System
- Frontend UI

### Security Requirements
- Authentication required
- Role-based access control
- CSRF protection
- Input validation
- Secure file handling
- Site-based permissions

## User Interface Design

### Layout Specifications
- Responsive dashboard
- Statistical widgets
- Filter form section
- Data table component
- Inspection form layout
- Print template

### Navigation Flow
1. Dashboard view
2. Record creation/editing
3. Activity checklist
4. Inspection results
5. Approval process
6. Print generation

### Form Elements
- Text inputs
- Dropdown selections
- Date pickers
- Checkbox groups
- Status indicators
- Approval buttons

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
3. Activity checklist processing
4. Inspection result processing
5. Status tracking
6. Database storage

### Data Validation
- Required fields checking
- Status validation
- Permission validation
- Date format validation
- Business rule validation

### Data Storage
- Main record storage
- Activity checklist records
- Inspection result records
- Status tracking
- Audit logging

### Data Retrieval
- Filtered queries
- Pagination handling
- Print template generation
- Status calculations

## Testing Requirements

### Test Cases
1. Form submission validation
2. Activity checklist processing
3. Inspection result storage
4. Filter functionality
5. CRUD operations
6. Approval workflow
7. Print template generation

### Test Scenarios
- Complete inspection record creation
- Invalid data handling
- Print template generation
- Search and filter operations
- Approval process testing
- Permission validation
- Status calculation verification

### Acceptance Criteria
- Successful inspection record creation
- Accurate activity checklist storage
- Proper inspection result storage
- Responsive UI
- Proper error handling
- Data integrity maintenance
- Working approval workflow
- Correct status calculation
- Proper permission enforcement
- Valid print template generation
