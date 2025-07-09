# LOG-004 SAP Request Module Documentation

## Document Overview
### Document Purpose
This document provides comprehensive documentation for the LOG-004 SAP Request module, which manages purchase requisitions and material requests through SAP integration.

### Project Name
SAP Request - Smart Form Module LOG-004

### Version History
- v1.0.0 - Initial release
- Current Version: 1.0.0

### Document Status
Active/In Development

## Project Overview
### Project Description
The LOG-004 SAP Request module is a critical logistics component that manages purchase requisitions and material requests through SAP integration. It handles the creation, tracking, and approval of purchase requests while maintaining proper documentation and workflow.

### Project Scope
- Dashboard with request statistics
- Purchase requisition management
- Material request tracking
- PDF report generation
- Multi-level approval workflow
- SAP integration
- Cost tracking

### Project Goals
- Track purchase requests
- Monitor material requisitions
- Document approvals
- Generate request reports
- Support cost analysis
- Track operational requests
- Maintain audit trails

### Target Users
- Requisitioners
- Department Heads
- Logistics Staff
- Purchase Managers
- Cost Controllers
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
  - Approval filter
  - Date filter
  - Status filter
- Request form interface
- PDF export functionality
- Approval workflow interface

### Form Validation Rules
- Required field validation for:
  - Document number (auto-generated)
  - Plant/Site
  - Date
  - Creator information
  - Item requisitions
  - Quantities
  - Cost centers
  - GL accounts
- Item validation
- Cost validation

### Data Processing Requirements
- Document number generation
- PDF report generation
- Monthly statistics calculation
- Cost calculation
- Plant validation
- Item verification
- Price calculation

### Business Logic
- Request workflow:
  - Request creation
  - Item specification
  - Cost allocation
  - Approval process
  - Status tracking
  - Report generation
- Multi-level approval
- Status management
- Cost tracking
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
#### Table: pengajuan_pr_003sap
- id (Primary Key)
- doc_num (Unique)
- plant
- tanggal
- dibuat_oleh
- checked_by
- creator
- status (JSON)
- delete_status
- created_at
- updated_at

#### Table: pengajuan_pr_003sap_detail
- id (Primary Key)
- pengajuan_pr_003sap_id (Foreign Key)
- item_of_requisition
- qty_requested
- storage
- requisitioner
- req_tracking_number
- purchasing_group
- valuation_price
- release_date
- cost_center
- gl_account
- created_at
- updated_at

### API Endpoints

#### 1. Dashboard View
- **Route**: GET `/log-004/sap`
- **Name**: `dashboard-003-sap`
- **Description**: Main dashboard interface
- **Query Parameters**:
  - `search` (string, optional): Search by doc number or plant
  - `plant` (string, optional): Filter by plant
  - `approval` (string, optional): Filter by approver
- **Response**: View with statistics and filtered records

#### 2. Create Form
- **Route**: GET `/log-004/sap/create`
- **Name**: `create-003-sap`
- **Description**: Display request form
- **Response**: Form view with approval list

#### 3. Store Form
- **Route**: POST `/log-004/sap/store`
- **Name**: `store-003-sap`
- **Description**: Save new request
- **Request Body**:
  ```json
  {
    "job_site": "string",
    "date": "date",
    "dibuat_oleh": "string",
    "checked_by": "string",
    "item_of_requisition_": ["string"],
    "qty_requested_": ["number"],
    "storage_": ["string"],
    "requisitioner_": ["string"],
    "req_tracking_number_": ["string"],
    "purchasing_group_": ["string"],
    "valuation_price_": ["number"],
    "release_date_": ["date"],
    "cost_center_": ["string"],
    "gl_account_": ["string"]
  }
  ```
- **Response**: Redirect with status

#### 4. Show Record
- **Route**: GET `/log-004/sap/show/{id}`
- **Name**: `show-003-sap`
- **Description**: View request details
- **Parameters**: Record ID
- **Response**: Detailed view with all data

#### 5. Approve Request
- **Route**: POST `/log-004/sap/approve`
- **Name**: `approve-003-sap`
- **Description**: Approve request
- **Request Body**:
  ```json
  {
    "doc_num": "string",
    "dibuat_oleh": "string",
    "checked_by": "string"
  }
  ```
- **Response**: JSON response with status

#### 6. Reset Approval
- **Route**: POST `/log-004/sap/reset/{id}`
- **Name**: `reset-003-sap`
- **Description**: Reset approval status
- **Parameters**: Document number
- **Response**: JSON response with status

#### 7. Reject Request
- **Route**: POST `/log-004/sap/reject`
- **Name**: `reject-003-sap`
- **Description**: Reject request
- **Request Body**: Same as Approve Request
- **Response**: JSON response with status

### Integration Points
- SAP system
- Cost center management
- GL account system
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
- Item details section
- Cost inputs
- PDF preview

### Navigation Flow
1. Dashboard view
2. Form creation
3. Item specification
4. Cost allocation
5. Request submission
6. Approval workflow
7. PDF generation

### Form Elements
- Text inputs
- Number inputs
- Date pickers
- Item selectors
- Cost center inputs
- GL account inputs
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
2. Item validation
3. Cost verification
4. Status tracking
5. Database storage
6. PDF generation

### Data Validation
- Required fields checking
- Cost validation
- Item validation
- Plant validation

### Data Storage
- Main record storage
- Item details
- Cost information
- Approval records
- Status tracking

### Data Retrieval
- Filtered queries
- Request statistics
- Item details
- Cost analysis

## Testing Requirements

### Test Cases
1. Form submission validation
2. Item specification
3. Cost allocation
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
- Cost calculation
- Status tracking

### Acceptance Criteria
- Successful request creation
- Accurate items
- Proper PDF generation
- Responsive UI
- Proper error handling
- Data integrity maintenance
- Working approval workflow
- Valid cost tracking

### Required Metrics
1. Total requests
2. Monthly requests
3. Plant distribution
4. Approval cycle time
5. Cost analysis
6. Request patterns
7. Processing efficiency
