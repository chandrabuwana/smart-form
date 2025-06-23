# LOG-003 Solar Usage Module Documentation

## Document Overview
### Document Purpose
This document provides comprehensive documentation for the LOG-003 Solar Usage module, which manages and tracks solar fuel consumption across different sites and equipment.

### Project Name
Solar Usage - Smart Form Module LOG-003

### Version History
- v1.0.0 - Initial release
- Current Version: 1.0.0

### Document Status
Active/In Development

## Project Overview
### Project Description
The LOG-003 Solar Usage module is a critical logistics component that manages solar fuel consumption tracking, monitors usage patterns, and maintains detailed records of fuel distribution across different sites and equipment.

### Project Scope
- Dashboard with usage statistics
- Site-based consumption tracking
- Equipment usage monitoring
- PDF report generation
- Multi-level approval workflow
- Usage analysis
- Cost tracking

### Project Goals
- Track solar consumption
- Monitor usage patterns
- Document distribution
- Generate usage reports
- Support efficiency analysis
- Track operational costs
- Maintain audit trails

### Target Users
- Site Supervisors
- Equipment Operators
- Logistics Staff
- Operations Managers
- Cost Controllers
- Site Managers

## Functional Requirements

### User Interface Requirements
- Dashboard with statistics display:
  - Total consumption counter
  - Monthly usage tracker
  - Site-based analytics
  - Status monitoring
- Advanced filtering capabilities:
  - Site filter
  - Equipment filter
  - Date range filter
  - Status filter
- Usage form interface
- PDF export functionality
- Approval workflow interface

### Form Validation Rules
- Required field validation for:
  - Document number
  - Fuel station number
  - Site location
  - Equipment details
  - Usage readings
  - Operator information
  - Supervisor details
  - Shift information
- Reading validation
- Equipment validation

### Data Processing Requirements
- Usage calculation
- PDF report generation
- Monthly statistics calculation
- Equipment tracking
- Site validation
- Reading verification
- Cost calculation

### Business Logic
- Solar usage workflow:
  - Usage recording
  - Equipment validation
  - Reading verification
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
#### Table: FM_LOG_037_PEMAKAIAN_SOLAR
- id (Primary Key)
- no_doc (Unique)
- created_date
- dibuat_oleh
- no_fuel_station
- total_pemakaian
- disetujui_oleh
- status
- is_active
- created_at
- updated_at

#### Table: FM_LOG_037_PEMAKAIAN_SOLAR_DETAIL
- id (Primary Key)
- no_doc (Foreign Key)
- equipment_id
- reading_start
- reading_end
- consumption
- operator
- shift
- created_at
- updated_at

### API Endpoints

#### 1. Dashboard View
- **Route**: GET `/log-003/solar`
- **Name**: `solar.dashboard`
- **Description**: Main dashboard interface
- **Query Parameters**:
  - `search` (string, optional): Search by doc number or equipment
  - `nik` (string, optional): Filter by operator
  - `status` (string, optional): Filter by status
- **Response**: View with statistics and filtered records

#### 2. Get List
- **Route**: GET `/log-003/solar/list`
- **Name**: `solar.list`
- **Description**: Get list of solar usage records
- **Query Parameters**: Filters
- **Response**: JSON with records

#### 3. Form View
- **Route**: GET `/log-003/solar/form`
- **Name**: `solar.form`
- **Description**: Display solar usage form
- **Response**: Form view

#### 4. Submit Form
- **Route**: POST `/log-003/solar/submit`
- **Name**: `solar.submit`
- **Description**: Save new usage record
- **Request Body**:
  ```json
  {
    "no_doc": "string",
    "no_fuel_station": "string",
    "total_pemakaian": "number",
    "details": [
      {
        "equipment_id": "string",
        "reading_start": "number",
        "reading_end": "number",
        "consumption": "number",
        "operator": "string",
        "shift": "string"
      }
    ]
  }
  ```
- **Response**: JSON response with status

#### 5. Edit Form
- **Route**: GET `/log-003/solar/edit`
- **Name**: `solar.edit`
- **Description**: Edit usage record
- **Query Parameters**: Record ID
- **Response**: Form view with data

#### 6. Update Record
- **Route**: PUT `/log-003/solar/update`
- **Name**: `solar.update`
- **Description**: Update usage record
- **Request Body**: Same as Submit Form
- **Response**: JSON response with status

#### 7. Detail View
- **Route**: GET `/log-003/solar/detail`
- **Name**: `solar.detail`
- **Description**: View detailed record
- **Query Parameters**: Record ID
- **Response**: Detailed view with all data

#### 8. Approve Record
- **Route**: POST `/log-003/solar/approve`
- **Name**: `solar.approve`
- **Description**: Approve usage record
- **Request Body**:
  ```json
  {
    "no_doc": "string",
    "status": "string",
    "item": "json"
  }
  ```
- **Response**: JSON response with status

#### 9. Reject Record
- **Route**: POST `/log-003/solar/reject`
- **Name**: `solar.reject`
- **Description**: Reject usage record
- **Request Body**: Same as Approve Record
- **Response**: JSON response with status

#### 10. Delete Record
- **Route**: DELETE `/log-003/solar/delete`
- **Name**: `solar.delete`
- **Description**: Soft delete record
- **Request Body**: Document number
- **Response**: Redirect to dashboard

#### 11. Export PDF
- **Route**: GET `/log-003/solar/pdf`
- **Name**: `solar.pdf`
- **Description**: Generate PDF report
- **Query Parameters**: Record ID
- **Response**: PDF download

### Integration Points
- Equipment management system
- Site management system
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
- Usage form
- Equipment selector
- Reading inputs
- PDF preview

### Navigation Flow
1. Dashboard view
2. Form creation
3. Equipment selection
4. Reading entry
5. Usage calculation
6. Approval workflow
7. PDF generation

### Form Elements
- Text inputs
- Number inputs
- Date/time pickers
- Equipment selectors
- Site selectors
- Status indicators
- Reading fields

### Messages
- Success notifications
- Error alerts
- Validation messages
- Processing indicators

## Data Flow

### Data Input Process
1. Form submission
2. Equipment validation
3. Reading verification
4. Usage calculation
5. Database storage
6. PDF generation

### Data Validation
- Required fields checking
- Reading validation
- Equipment validation
- Usage calculation

### Data Storage
- Main record storage
- Usage details
- Equipment records
- Reading history
- Approval tracking

### Data Retrieval
- Filtered queries
- Usage statistics
- Equipment details
- Cost analysis

## Testing Requirements

### Test Cases
1. Form submission validation
2. Reading accuracy verification
3. Usage calculation
4. Filter functionality
5. CRUD operations
6. Approval workflow
7. PDF generation

### Test Scenarios
- Complete usage record creation
- Invalid data handling
- PDF report generation
- Search and filter operations
- Approval process testing
- Usage calculation
- Cost tracking

### Acceptance Criteria
- Successful record creation
- Accurate readings
- Proper PDF generation
- Responsive UI
- Proper error handling
- Data integrity maintenance
- Working approval workflow
- Valid usage tracking

### Required Metrics
1. Total consumption
2. Monthly usage
3. Equipment efficiency
4. Site consumption
5. Cost analysis
6. Usage patterns
7. Equipment performance
