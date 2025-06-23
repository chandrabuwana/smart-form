# LOG-001 Fuel Request Module Documentation

## Document Overview
### Document Purpose
This document provides comprehensive documentation for the LOG-001 Fuel Request module, which manages and tracks fuel requests and consumption for equipment and vehicles across different sites.

### Project Name
Fuel Request - Smart Form Module LOG-001

### Version History
- v1.0.0 - Initial release
- Current Version: 1.0.0

### Document Status
Active/In Development

## Project Overview
### Project Description
The LOG-001 Fuel Request module is a critical logistics component that manages fuel requests, tracks consumption, and monitors fuel distribution across different sites and equipment. It ensures proper documentation of fuel usage and maintains accurate records for operational efficiency.

### Project Scope
- Dashboard with fuel request statistics
- Site-based fuel management
- Equipment fuel tracking
- PDF report generation
- Approval workflow
- Usage monitoring
- Equipment validation

### Project Goals
- Track fuel requests
- Monitor fuel consumption
- Document equipment usage
- Generate usage reports
- Support efficiency analysis
- Track operational costs
- Maintain fuel records

### Target Users
- Equipment Operators
- Site Supervisors
- Logistics Staff
- Operations Managers
- Fleet Managers
- Site Managers

## Functional Requirements

### User Interface Requirements
- Dashboard with statistics display:
  - Total requests counter
  - Monthly requests counter
  - Site-based tracking
  - Status monitoring
- Advanced filtering capabilities:
  - Site filter
  - Equipment number filter
  - Date filter
  - Status filter
- Request form interface
- PDF export functionality
- Approval workflow interface

### Form Validation Rules
- Required field validation for:
  - Document number (auto-generated)
  - Operator name and position
  - Department
  - Site location
  - Equipment number
  - Equipment type
  - Shift information
  - Hour meter/KM readings
  - Fuel readings
- Reading validation
- Equipment validation

### Data Processing Requirements
- Automatic document number generation
- PDF report generation
- Monthly statistics calculation
- Equipment validation
- Site validation
- Reading verification
- Usage calculation

### Business Logic
- Fuel request workflow:
  - Request submission
  - Equipment validation
  - Reading verification
  - Approval process
  - Fuel dispensing
  - Usage recording
- Status management
- Equipment tracking
- Site management
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
#### Table: FM_LOG_022_PERMINTAAN_PENGISIAN_FUEL
- id (Primary Key)
- doc_num (Unique)
- nama
- jabatan
- departemen
- site
- no_lambung
- jenis_kendaraan
- jam
- shift
- hm
- km
- awal
- akhir
- total_liter
- diserahkan_oleh
- diterima_oleh
- dibuat_oleh
- status
- is_active
- created_at
- updated_at

### API Endpoints

#### 1. Dashboard View
- **Route**: GET `/log-001/fuel`
- **Name**: `bss-form.log.fuel.dashboard`
- **Description**: Main dashboard interface
- **Query Parameters**:
  - `search` (string, optional): Search by doc number, equipment, or operator
  - `site` (string, optional): Filter by site
  - `nik` (string, optional): Filter by operator
  - `status` (string, optional): Filter by status
- **Response**: View with statistics and filtered records

#### 2. Add Form
- **Route**: GET `/log-001/fuel/form`
- **Name**: `bss-form.log.fuel.form`
- **Description**: Display fuel request form
- **Response**: Form view with site options

#### 3. Store Request
- **Route**: POST `/log-001/fuel/store`
- **Name**: `bss-form.log.fuel.store`
- **Description**: Save new fuel request
- **Request Body**:
  ```json
  {
    "i_jabatan": "string",
    "i_departemen": "string",
    "site": "string",
    "i_no_lambung": "string",
    "i_jenis_kendaraan": "string",
    "iJam": "string",
    "i_shift": "string",
    "i_hm": "number",
    "i_km": "number",
    "i_awal": "number",
    "i_akhir": "number",
    "i_total_liter": "number",
    "dDiserahkan": "string",
    "dDiterima": "string"
  }
  ```
- **Response**: JSON response with status

#### 4. Delete Request
- **Route**: POST `/log-001/fuel/delete`
- **Name**: `bss-form.log.fuel.delete`
- **Description**: Soft delete fuel request
- **Request Body**: Record ID
- **Response**: Redirect to dashboard

#### 5. Detail View
- **Route**: GET `/log-001/fuel/detail/{id}`
- **Name**: `bss-form.log.fuel.detail`
- **Description**: View detailed request
- **Parameters**: Record ID
- **Response**: Detailed view with all data

#### 6. Update Request
- **Route**: PUT `/log-001/fuel/update`
- **Name**: `bss-form.log.fuel.update`
- **Description**: Update fuel request
- **Request Body**: Same as Store Request
- **Response**: Redirect to dashboard

#### 7. Export PDF
- **Route**: GET `/log-001/fuel/export/{id}`
- **Name**: `bss-form.log.fuel.export`
- **Description**: Generate PDF report
- **Parameters**: Record ID
- **Response**: PDF download

#### 8. Get Equipment by Site
- **Route**: GET `/log-001/fuel/equipment`
- **Name**: `bss-form.log.fuel.equipment`
- **Description**: Get equipment list by site
- **Query Parameters**: Site ID
- **Response**: JSON with equipment list

#### 9. Get Equipment Model
- **Route**: GET `/log-001/fuel/model`
- **Name**: `bss-form.log.fuel.model`
- **Description**: Get equipment model details
- **Query Parameters**: Equipment number
- **Response**: JSON with model details

### Integration Points
- Equipment management system
- Site management system
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
- Equipment selector
- Reading inputs
- PDF preview

### Navigation Flow
1. Dashboard view
2. Form creation
3. Equipment selection
4. Reading entry
5. Request submission
6. Status tracking
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
4. Request processing
5. Database storage
6. PDF generation

### Data Validation
- Required fields checking
- Reading validation
- Equipment validation
- Site validation

### Data Storage
- Main record storage
- Equipment details
- Reading records
- Site information
- Usage tracking

### Data Retrieval
- Filtered queries
- Equipment details
- Site information
- Usage statistics

## Testing Requirements

### Test Cases
1. Form submission validation
2. Reading accuracy verification
3. Equipment validation
4. Filter functionality
5. CRUD operations
6. PDF generation
7. Site validation

### Test Scenarios
- Complete request creation
- Invalid data handling
- PDF report generation
- Search and filter operations
- Equipment validation
- Reading verification
- Site validation

### Acceptance Criteria
- Successful request creation
- Accurate readings
- Proper PDF generation
- Responsive UI
- Proper error handling
- Data integrity maintenance
- Valid equipment tracking
- Accurate site management

### Required Metrics
1. Total fuel requests
2. Monthly consumption
3. Equipment usage
4. Site consumption
5. Average consumption
6. Request trends
7. Equipment efficiency
