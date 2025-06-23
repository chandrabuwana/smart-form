# PROD-045 Cycle Time Calibration Module Documentation

## Document Overview
### Document Purpose
This document provides comprehensive documentation for the PROD-045 Cycle Time Calibration module, which manages and tracks calibration of cycle times for haulers, loaders, and dozers in production operations.

### Project Name
Cycle Time Calibration - Smart Form Module PROD-045

### Version History
- v1.0.0 - Initial release
- Current Version: 1.0.0

### Document Status
Active/In Development

## Project Overview
### Project Description
The PROD-045 Cycle Time Calibration module is a critical production operations component that manages and tracks cycle time calibrations for different types of heavy equipment. It ensures proper documentation of equipment performance metrics, timing measurements, and operational efficiency.

### Project Scope
- Dashboard with calibration statistics
- Equipment-specific calibration forms
- Multi-level approval workflow
- PDF report generation
- Performance metrics tracking
- Cycle time measurements
- Equipment efficiency monitoring

### Project Goals
- Track equipment cycle times
- Monitor operational efficiency
- Document calibration results
- Generate detailed reports
- Support performance analysis
- Track timing variations
- Maintain equipment standards

### Target Users
- Equipment Operators
- Production Supervisors
- Equipment Managers
- Operations Managers
- Quality Control Staff
- Maintenance Teams

## Functional Requirements

### User Interface Requirements
- Dashboard with statistics display:
  - Total calibrations counter
  - Equipment type counters
  - Approval status tracker
  - Performance metrics
- Advanced filtering capabilities:
  - Equipment type filter
  - Approval status filter
  - Document number search
  - Supervisor search
- Calibration form interface
- PDF export functionality
- Approval workflow interface

### Form Validation Rules
- Required field validation for:
  - Document number (auto-generated)
  - Equipment numbers
  - Shift information
  - Timing measurements
  - Material types
  - Supervisor details
  - Approval statuses
- Time measurement validation
- Equipment validation

### Data Processing Requirements
- Automatic document number generation
- PDF report generation
- Cycle time calculations
- Performance metrics
- Approval tracking
- Equipment tracking
- Issue documentation

### Business Logic
- Equipment-specific measurements:
  - Hauler metrics
  - Loader metrics
  - Dozer metrics
- Multi-level approval workflow
- Shift-based tracking
- Performance calculations
- Status management
- Equipment efficiency analysis

### Error Handling
- Database query exception handling
- PDF generation error management
- Time calculation error handling
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
#### Table: prod_kalibrasi_ct
- id (Primary Key)
- doc_number (Unique)
- shift_hauler
- shift_loader
- shift_dozer
- mengetahui_hauler
- mengetahui_loader
- mengetahui_dozer
- status_dibuat_hauler
- status_mengetahui_hauler
- status_dibuat_loader
- status_mengetahui_loader
- status_dibuat_dozer
- status_mengetahui_dozer
- jarak_hauling_hauler (JSON)
- waktu_antri_hauler (JSON)
- meninggalkan_front_hauler (JSON)
- cycle_timer_hauler (JSON)
- jumlah_bucket_hauler (JSON)
- no_loader (JSON)
- jenis_material_loader (JSON)
- nomor_cmtdt_loader (JSON)
- digging_loader (JSON)
- swing_isi_loader (JSON)
- load_loader (JSON)
- swing_kosong_loader (JSON)
- total_pengisian_loader (JSON)
- durasi_loader (JSON)
- reason_loader (JSON)
- no_dozer (JSON)
- dozing_dozer (JSON)
- reverse_dozer (JSON)
- gear_shifting_dozer (JSON)
- total_dozer (JSON)
- cm_dozer (JSON)
- jarak_dozer (JSON)
- durasi_dozer (JSON)
- reason_dozer (JSON)
- created_at
- updated_at

### API Endpoints

#### 1. Dashboard View
- **Route**: GET `/prod-045/kalibrasi-ct`
- **Name**: `prod.kalibrasi-ct.dashboard`
- **Description**: Main dashboard interface
- **Query Parameters**:
  - `search` (string, optional): Search by doc number or supervisor
  - `mengetahui_hauler` (string, optional): Filter by hauler supervisor
  - `mengetahui_loader` (string, optional): Filter by loader supervisor
  - `mengetahui_dozer` (string, optional): Filter by dozer supervisor
  - `status` (string, optional): Filter by approval status
- **Response**: View with statistics and filtered records

#### 2. Add Form
- **Route**: GET `/prod-045/kalibrasi-ct/add`
- **Name**: `prod.kalibrasi-ct.add`
- **Description**: Display calibration form
- **Response**: Form view with equipment sections

#### 3. Store Record
- **Route**: POST `/prod-045/kalibrasi-ct/store`
- **Name**: `prod.kalibrasi-ct.store`
- **Description**: Save new calibration
- **Request Body**: Complete calibration data
- **Response**: JSON response with status

#### 4. Delete Record
- **Route**: DELETE `/prod-045/kalibrasi-ct/delete/{id}`
- **Name**: `prod.kalibrasi-ct.delete`
- **Description**: Delete calibration record
- **Parameters**: Record ID
- **Response**: JSON response with status

#### 5. Edit Form
- **Route**: GET `/prod-045/kalibrasi-ct/edit/{id}`
- **Name**: `prod.kalibrasi-ct.edit`
- **Description**: Edit calibration form
- **Parameters**: Record ID
- **Response**: Form view with existing data

#### 6. Update Record
- **Route**: PUT `/prod-045/kalibrasi-ct/update/{id}`
- **Name**: `prod.kalibrasi-ct.update`
- **Description**: Update calibration record
- **Parameters**: Record ID
- **Request Body**: Updated calibration data
- **Response**: JSON response with status

#### 7. Approval View
- **Route**: GET `/prod-045/kalibrasi-ct/approval/{id}`
- **Name**: `prod.kalibrasi-ct.approval`
- **Description**: View approval form
- **Parameters**: Record ID
- **Response**: Approval form view

#### 8. Approve Record
- **Route**: POST `/prod-045/kalibrasi-ct/approve/{id}`
- **Name**: `prod.kalibrasi-ct.approve`
- **Description**: Approve calibration record
- **Parameters**: Record ID
- **Response**: JSON response with status

#### 9. Reject Record
- **Route**: POST `/prod-045/kalibrasi-ct/reject/{id}`
- **Name**: `prod.kalibrasi-ct.reject`
- **Description**: Reject calibration record
- **Parameters**: Record ID
- **Response**: JSON response with status

#### 10. Export PDF
- **Route**: GET `/prod-045/kalibrasi-ct/export/{id}`
- **Name**: `prod.kalibrasi-ct.export`
- **Description**: Generate PDF report
- **Parameters**: Record ID
- **Response**: PDF download

### Integration Points
- HRD System for user validation
- Equipment management system
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
- Equipment calibration forms
- Approval workflow interface
- PDF preview

### Navigation Flow
1. Dashboard view
2. Form creation/selection
3. Equipment measurements
4. Data entry
5. Approval workflow
6. Status updates
7. PDF generation

### Form Elements
- Text inputs
- Time inputs
- Equipment selectors
- Measurement fields
- Approval buttons
- Status indicators
- Performance metrics

### Messages
- Success notifications
- Error alerts
- Validation messages
- Processing indicators

## Data Flow

### Data Input Process
1. Form submission
2. Equipment measurements
3. Time calculations
4. Approval routing
5. Database storage
6. PDF generation

### Data Validation
- Required fields checking
- Time measurement validation
- Equipment validation
- Approval validation

### Data Storage
- Main record storage
- Equipment measurements (JSON)
- Time measurements (JSON)
- Approval statuses
- Performance metrics

### Data Retrieval
- Filtered queries
- Pagination handling
- PDF generation
- Statistical calculations

## Testing Requirements

### Test Cases
1. Form submission validation
2. Time measurement accuracy
3. PDF generation
4. Filter functionality
5. CRUD operations
6. Approval workflow
7. Equipment tracking

### Test Scenarios
- Complete calibration record creation
- Invalid data handling
- PDF report generation
- Search and filter operations
- Approval process testing
- Equipment measurement validation
- Time calculation verification

### Acceptance Criteria
- Successful calibration record creation
- Accurate time measurements
- Proper PDF report generation
- Responsive UI
- Proper error handling
- Data integrity maintenance
- Working approval workflow
- Valid equipment tracking

### Equipment Metrics

#### Hauler Metrics
1. Hauling distance
2. Queue time
3. Front departure time
4. Cycle timer
5. Bucket count

#### Loader Metrics
1. Equipment number
2. Material type
3. CMTDT number
4. Digging time
5. Loaded swing time
6. Loading time
7. Empty swing time
8. Total filling time
9. Duration
10. Issues/Reasons

#### Dozer Metrics
1. Equipment number
2. Dozing time
3. Reverse time
4. Gear shifting time
5. Total time
6. CM measurements
7. Distance
8. Duration
9. Issues/Reasons
