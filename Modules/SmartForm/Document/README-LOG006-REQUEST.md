# LOG-006 Request Master Module Documentation

## Document Overview
### Document Purpose
This document provides comprehensive documentation for the LOG-006 Request Master module, which manages material requests and master data for logistics operations.

### Project Name
Request Master - Smart Form Module LOG-006

### Version History
- v1.0.0 - Initial release
- Current Version: 1.0.0

### Document Status
Active/In Development

## Project Overview
### Project Description
The LOG-006 Request Master module is a critical logistics component that manages material requests, tracks master data, and maintains standardized information for logistics operations across different plants and material types.

### Project Scope
- Dashboard with request statistics
- Material request management
- Master data maintenance
- PDF report generation
- Multi-level approval workflow
- Material tracking
- Plant management

### Project Goals
- Track material requests
- Maintain master data
- Document requests
- Generate reports
- Support material analysis
- Track operational requests
- Maintain data standards

### Target Users
- Material Planners
- Logistics Staff
- Plant Managers
- Purchase Managers
- Inventory Controllers
- Site Managers

## Functional Requirements

### User Interface Requirements
- Dashboard with statistics display:
  - Total requests counter
  - Monthly requests counter
  - Plant-based tracking
  - Status monitoring
- Advanced filtering capabilities:
  - Plant filter
  - Material type filter
  - Material group filter
  - Status filter
- Request form interface
- PDF export functionality
- Approval workflow interface
- Catalog view interface

### Form Validation Rules
- Required field validation for:
  - Document number (auto-generated)
  - Plant code
  - Material type
  - Material group
  - UOM (Unit of Measure)
  - Valuation class
  - Requestor information
  - Material details
- Material validation
- Plant validation

### Data Processing Requirements
- Document number generation
- PDF report generation
- Monthly statistics calculation
- Material validation
- Plant validation
- Request verification
- Catalog management

### Business Logic
- Request workflow:
  - Request creation
  - Material specification
  - Plant allocation
  - Approval process
  - Status tracking
  - Report generation
- Multi-level approval
- Status management
- Material tracking
- Request monitoring

### Error Handling
- Database query exception handling
- PDF generation error management
- Validation error handling
- User-friendly error messages
- Logging system integration

## Technical Specifications

### Framework & Technologies
- Laravel Framework
- MySQL Database
- Bootstrap UI
- DomPDF for PDF generation
- jQuery for AJAX

### Database Schema
#### Table: FM_LOG_002_REQUESTER_MASTER
- id (Primary Key)
- doc_num (Unique)
- plant
- material_type
- material_group
- uom
- valuation_class
- dibuat_oleh
- disetujui_oleh
- status_req
- remark
- created_at
- updated_at
- deleted_at
- created_by
- updated_by
- deleted_by

#### Table: FM_LOG_002_REQUESTER_MASTER_DETAIL
- id (Primary Key)
- doc_num_id (Foreign Key)
- material_code
- material_desc
- quantity
- created_at
- updated_at

### API Endpoints

#### 1. Dashboard View
- **Route**: GET `/log-006/request`
- **Name**: `request.dashboard`
- **Description**: Main dashboard interface
- **Response**: View with statistics and filtered records

#### 2. Get List
- **Route**: GET `/log-006/request/list`
- **Name**: `request.list`
- **Description**: Get list of material requests
- **Query Parameters**:
  - `search` (string, optional): Search by doc number or material
  - `plant` (string, optional): Filter by plant
  - `material_type` (string, optional): Filter by material type
  - `status` (string, optional): Filter by status
- **Response**: JSON with records

#### 3. Form View
- **Route**: GET `/log-006/request/form`
- **Name**: `request.form`
- **Description**: Display request form
- **Response**: Form view with dropdowns

#### 4. Submit Form
- **Route**: POST `/log-006/request/submit`
- **Name**: `request.submit`
- **Description**: Save new request
- **Request Body**:
  ```json
  {
    "plant": "string",
    "material_type": "string",
    "material_group": "string",
    "uom": "string",
    "valuation_class": "string",
    "dibuat_oleh": "string",
    "disetujui_oleh": "string",
    "details": [
      {
        "material_code": "string",
        "material_desc": "string",
        "quantity": "number"
      }
    ]
  }
  ```
- **Response**: JSON response with status

#### 5. Edit Form
- **Route**: GET `/log-006/request/edit`
- **Name**: `request.edit`
- **Description**: Edit request record
- **Query Parameters**: Record ID
- **Response**: Form view with data

#### 6. Catalog View
- **Route**: GET `/log-006/request/catalog`
- **Name**: `request.catalog`
- **Description**: View material catalog
- **Query Parameters**: Material filters
- **Response**: Catalog view with materials

#### 7. Update Record
- **Route**: PUT `/log-006/request/update`
- **Name**: `request.update`
- **Description**: Update request record
- **Request Body**: Same as Submit Form
- **Response**: JSON response with status

#### 8. Detail View
- **Route**: GET `/log-006/request/detail`
- **Name**: `request.detail`
- **Description**: View detailed record
- **Query Parameters**: Record ID
- **Response**: Detailed view with all data

#### 9. Approve/Reject
- **Route**: POST `/log-006/request/approve-reject`
- **Name**: `request.approve-reject`
- **Description**: Approve or reject record
- **Request Body**:
  ```json
  {
    "id": "number",
    "noDoc": "string",
    "disetujuiOleh": "number",
    "action": "string",
    "remark": "string"
  }
  ```
- **Response**: JSON response with status

#### 10. Delete Record
- **Route**: DELETE `/log-006/request/delete`
- **Name**: `request.delete`
- **Description**: Soft delete record
- **Request Body**: Record ID
- **Response**: JSON response with status

#### 11. Download
- **Route**: GET `/log-006/request/download`
- **Name**: `request.download`
- **Description**: Download material templates
- **Response**: File download

### Integration Points
- Material master system
- Plant management system
- Inventory system
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
- Request form
- Material selector
- Plant selector
- PDF preview
- Catalog browser

### Navigation Flow
1. Dashboard view
2. Form creation
3. Material selection
4. Plant selection
5. Request submission
6. Approval workflow
7. PDF generation

### Form Elements
- Text inputs
- Number inputs
- Date/time pickers
- Material selectors
- Plant selectors
- UOM selectors
- Status indicators
- Approval buttons

### Messages
- Success notifications
- Error alerts
- Validation messages
- Processing indicators

## Data Flow

### Data Input Process
1. Form submission
2. Material validation
3. Plant verification
4. Request processing
5. Database storage
6. PDF generation

### Data Validation
- Required fields checking
- Material validation
- Plant validation
- UOM validation

### Data Storage
- Main record storage
- Material details
- Plant records
- Request tracking
- Approval records

### Data Retrieval
- Filtered queries
- Request statistics
- Material details
- Plant analysis

## Testing Requirements

### Test Cases
1. Form submission validation
2. Material verification
3. Plant validation
4. Filter functionality
5. CRUD operations
6. Approval workflow
7. PDF generation

### Test Scenarios
- Complete request creation
- Invalid data handling
- PDF report generation
- Search and filter operations
- Approval process testing
- Material selection
- Plant selection

### Acceptance Criteria
- Successful request creation
- Accurate materials
- Proper PDF generation
- Responsive UI
- Proper error handling
- Data integrity maintenance
- Working approval workflow
- Valid material tracking

### Master Data Categories
1. Plant Codes:
   - PL1 to PL27

2. Material Types:
   - SPRT (Spare Parts)
   - FOGC (Fuel, Oil, Gas, Chemical)
   - TIRE (Tires)
   - CONS (Consumables)
   - GENS (General Supplies)
   - ASET (Assets)
   - SEJA (Services)
   - MDLE (Modules)
   - BOMM (Bill of Materials)
   - FFF (Finished Products)

3. Material Groups:
   - S001-S006 (Spare Parts)
   - F001-F004 (Fuel & Oil)
   - T001 (Tires)
   - G001-G002 (General)
   - C001-C007 (Consumables)
   - A001-A006 (Assets)
   - J001-J014 (Services)
   - M001 (Modules)

4. Units of Measure:
   - BTG (Batang)
   - BUK (Buku)
   - PC (Piece)
   - SET (Set)
   - KG (Kilogram)
   - LBR (Lembar)
   - M (Meter)
   - BOX (Box)
   - L (Liter)
   - And many others

### Required Metrics
1. Total requests
2. Monthly requests
3. Plant distribution
4. Material type distribution
5. Approval cycle time
6. Request patterns
7. Processing efficiency
