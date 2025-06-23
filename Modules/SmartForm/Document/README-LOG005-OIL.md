# LOG-005 Oil Consumption Module Documentation

## Document Overview
### Document Purpose
This document provides comprehensive documentation for the LOG-005 Oil Consumption module, which manages and tracks oil consumption and distribution across different equipment and components.

### Project Name
Oil Consumption - Smart Form Module LOG-005

### Version History
- v1.0.0 - Initial release
- Current Version: 1.0.0

### Document Status
Active/In Development

## Project Overview
### Project Description
The LOG-005 Oil Consumption module is a critical logistics component that manages oil consumption tracking, monitors usage patterns, and maintains detailed records of oil distribution across different equipment components and types.

### Project Scope
- Dashboard with consumption statistics
- Equipment-based oil tracking
- Component-wise monitoring
- PDF report generation
- Multi-level approval workflow
- Usage analysis
- Cost tracking

### Project Goals
- Track oil consumption
- Monitor usage patterns
- Document distribution
- Generate usage reports
- Support efficiency analysis
- Track operational costs
- Maintain audit trails

### Target Users
- Equipment Operators
- Maintenance Staff
- Logistics Staff
- Operations Managers
- Cost Controllers
- Site Managers

## Functional Requirements

### User Interface Requirements
- Dashboard with statistics display:
  - Total consumption counter
  - Monthly usage tracker
  - Equipment-based analytics
  - Status monitoring
- Advanced filtering capabilities:
  - Oil type filter
  - Equipment filter
  - Component filter
  - Status filter
- Consumption form interface
- PDF export functionality
- Approval workflow interface

### Form Validation Rules
- Required field validation for:
  - Document number (auto-generated)
  - Oil type
  - Equipment details
  - Component information
  - Usage readings
  - Operator information
  - Shift information
  - Consumption details
- Reading validation
- Equipment validation

### Data Processing Requirements
- Consumption calculation
- PDF report generation
- Monthly statistics calculation
- Equipment tracking
- Component validation
- Reading verification
- Cost calculation

### Business Logic
- Oil consumption workflow:
  - Usage recording
  - Equipment validation
  - Component verification
  - Approval process
  - Cost calculation
  - Report generation
- Multi-level approval
- Status management
- Cost tracking
- Usage monitoring

### Error Handling
- Database query exception handling
- PDF generation error management
- Reading validation error handling
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
#### Table: FM_LOG_034_PENGELUARAN_OLI
- id (Primary Key)
- doc_num (Unique)
- tanggal
- shift
- equipment_id
- dibuat_oleh
- diketahui_oleh
- status_req
- remark
- created_at
- updated_at
- deleted_at
- created_by
- updated_by
- deleted_by

#### Table: FM_LOG_034_PENGELUARAN_OLI_DETAIL
- id (Primary Key)
- doc_num_id (Foreign Key)
- jenis
- merk
- component
- qty
- created_at
- updated_at

### API Endpoints

#### 1. Dashboard View
- **Route**: GET `/log-005/oil`
- **Name**: `oil.dashboard`
- **Description**: Main dashboard interface
- **Response**: View with statistics and filtered records

#### 2. Get List
- **Route**: GET `/log-005/oil/list`
- **Name**: `oil.list`
- **Description**: Get list of oil consumption records
- **Query Parameters**:
  - `search` (string, optional): Search by doc number or equipment
  - `equipment` (string, optional): Filter by equipment
  - `shift` (string, optional): Filter by shift
  - `status` (string, optional): Filter by status
- **Response**: JSON with records

#### 3. Form View
- **Route**: GET `/log-005/oil/form`
- **Name**: `oil.form`
- **Description**: Display consumption form
- **Response**: Form view with dropdowns

#### 4. Submit Form
- **Route**: POST `/log-005/oil/submit`
- **Name**: `oil.submit`
- **Description**: Save new consumption record
- **Request Body**:
  ```json
  {
    "tanggal": "date",
    "shift": "string",
    "equipment_id": "string",
    "dibuat_oleh": "string",
    "diketahui_oleh": "string",
    "details": [
      {
        "jenis": "string",
        "merk": "string",
        "component": "string",
        "qty": "number"
      }
    ]
  }
  ```
- **Response**: JSON response with status

#### 5. Edit Form
- **Route**: GET `/log-005/oil/edit`
- **Name**: `oil.edit`
- **Description**: Edit consumption record
- **Query Parameters**: Record ID
- **Response**: Form view with data

#### 6. Update Record
- **Route**: PUT `/log-005/oil/update`
- **Name**: `oil.update`
- **Description**: Update consumption record
- **Request Body**: Same as Submit Form
- **Response**: JSON response with status

#### 7. Detail View
- **Route**: GET `/log-005/oil/detail`
- **Name**: `oil.detail`
- **Description**: View detailed record
- **Query Parameters**: Record ID
- **Response**: Detailed view with all data

#### 8. Approve/Reject
- **Route**: POST `/log-005/oil/approve-reject`
- **Name**: `oil.approve-reject`
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

#### 9. Delete Record
- **Route**: DELETE `/log-005/oil/delete`
- **Name**: `oil.delete`
- **Description**: Soft delete record
- **Request Body**: Record ID
- **Response**: JSON response with status

### Integration Points
- Equipment management system
- Component database
- Cost tracking system
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
- Consumption form
- Equipment selector
- Component selector
- PDF preview

### Navigation Flow
1. Dashboard view
2. Form creation
3. Equipment selection
4. Component selection
5. Usage recording
6. Approval workflow
7. PDF generation

### Form Elements
- Text inputs
- Number inputs
- Date/time pickers
- Equipment selectors
- Component selectors
- Oil type selectors
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
2. Equipment validation
3. Component verification
4. Usage calculation
5. Database storage
6. PDF generation

### Data Validation
- Required fields checking
- Usage validation
- Equipment validation
- Component validation

### Data Storage
- Main record storage
- Usage details
- Equipment records
- Component records
- Approval tracking

### Data Retrieval
- Filtered queries
- Usage statistics
- Equipment details
- Component analysis

## Testing Requirements

### Test Cases
1. Form submission validation
2. Equipment verification
3. Component validation
4. Filter functionality
5. CRUD operations
6. Approval workflow
7. PDF generation

### Test Scenarios
- Complete consumption record
- Invalid data handling
- PDF report generation
- Search and filter operations
- Approval process testing
- Usage calculation
- Component tracking

### Acceptance Criteria
- Successful record creation
- Accurate readings
- Proper PDF generation
- Responsive UI
- Proper error handling
- Data integrity maintenance
- Working approval workflow
- Valid usage tracking

### Oil Types and Components
1. Oil Types:
   - Coolant
   - Grease
   - Oil

2. Components:
   - Engine
   - Transmission
   - Final Drive (LH/RH)
   - Hydraulic
   - PTO
   - Swing
   - Radiator
   - Damper
   - Differential (Front/Center/Rear)
   - Transfer
   - Brake Cooling
   - Gear Box
   - Transfer Case
   - Tandem (RH/LH)
   - Front Hub (LH/RH)
   - Lubrication Line
   - Brake
   - Pivot
   - Suspension
   - Track Adjuster
   - Circle
   - Rotary

### Required Metrics
1. Total consumption
2. Monthly usage
3. Equipment efficiency
4. Component consumption
5. Cost analysis
6. Usage patterns
7. Equipment performance
