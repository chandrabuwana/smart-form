# PROD-002 Form Checker Module Documentation

## Document Overview
### Document Purpose
This document provides comprehensive documentation for the PROD-002 Form Checker module, which manages and tracks equipment operations and shift-based activities in production.

### Project Name
Form Checker - Smart Form Module PROD-002

### Version History
- v1.0.0 - Initial release
- Current Version: 1.0.0

### Document Status
Active/In Development

## Project Overview
### Project Description
The PROD-002 Form Checker module is a critical production operations component that manages and tracks equipment usage, operator activities, and time-based operations across different shifts. It ensures proper documentation of equipment utilization, operator assignments, and operational timelines.

### Project Scope
- Dashboard with operational statistics
- Equipment tracking form
- Shift-based activity logging
- PDF report generation
- Operator assignment tracking
- Time-based operation logging
- Equipment utilization monitoring

### Project Goals
- Track equipment utilization
- Monitor operator activities
- Document shift operations
- Generate activity reports
- Support efficiency analysis
- Track operational issues
- Maintain equipment records

### Target Users
- Production Supervisors
- Equipment Operators
- Shift Leaders
- Operations Managers
- Equipment Managers
- Production Planners

## Functional Requirements

### User Interface Requirements
- Dashboard with statistics display:
  - Total records counter
  - Monthly records counter
  - Equipment counter
  - Activity tracker
- Advanced filtering capabilities:
  - Date filter
  - Shift filter
  - Document number search
  - Equipment search
- Activity logging interface
- PDF export functionality
- Status tracking interface

### Form Validation Rules
- Required field validation for:
  - Document number (auto-generated)
  - Shift
  - Loading equipment
  - Transport equipment
  - Operator names
  - Time details
  - Material types
  - Start/end times
- Time validation
- Equipment validation

### Data Processing Requirements
- Automatic document number generation
- PDF report generation
- Monthly statistics calculation
- Time detail processing
- Equipment tracking
- Activity logging
- Issue documentation

### Business Logic
- Time-based tracking:
  - Day shift (06:00-18:00)
  - Night shift (18:00-06:00)
- Equipment utilization tracking
- Operator assignment management
- Shift-based activity logging
- Issue tracking
- Status workflow
- Performance monitoring

### Error Handling
- Database query exception handling
- PDF generation error management
- Time validation error handling
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
#### Table: prod_checker_form
- id (Primary Key)
- doc_num (Unique)
- shift
- alat_muat (JSON)
- alat_angkut (JSON)
- nama_operator (JSON)
- operator_leader
- time_detail1-12 (JSON)
- material (JSON)
- waktu_mulai (JSON)
- waktu_selesai (JSON)
- keterangan (JSON)
- kendala (JSON)
- created_at
- updated_at

### API Endpoints

#### 1. Dashboard View
- **Route**: GET `/prod-002/form-checker`
- **Name**: `prod.form.checker.dashboard`
- **Description**: Main dashboard interface
- **Query Parameters**:
  - `search` (string, optional): Search by doc number, shift, or equipment
  - `shift` (string, optional): Filter by shift
  - `date` (date, optional): Filter by date
- **Response**: View with statistics and filtered records

#### 2. Show Form
- **Route**: GET `/prod-002/form-checker/show/{id}`
- **Name**: `prod.form.checker.show`
- **Description**: Display checker form
- **Parameters**: Record ID
- **Response**: Form view with time details

#### 3. Add Form
- **Route**: GET `/prod-002/form-checker/add`
- **Name**: `prod.form.checker.add`
- **Description**: Display new form
- **Response**: Form view with equipment selection

#### 4. Get Equipment by Site
- **Route**: GET `/prod-002/form-checker/alat`
- **Name**: `prod.form.checker.alat`
- **Description**: Get equipment list by site
- **Query Parameters**: Site ID
- **Response**: Equipment list

#### 5. Detail View
- **Route**: GET `/prod-002/form-checker/detail/{id}`
- **Name**: `prod.form.checker.detail`
- **Description**: View detailed record
- **Parameters**: Record ID
- **Response**: Detailed view with all data

#### 6. Update Record
- **Route**: POST `/prod-002/form-checker/update`
- **Name**: `prod.form.checker.update`
- **Description**: Update checker record
- **Request Body**: Form data with time details
- **Response**: JSON response with status

#### 7. Approve Record
- **Route**: POST `/prod-002/form-checker/approve`
- **Name**: `prod.form.checker.approve`
- **Description**: Approve checker record
- **Request Body**: Record ID and approval data
- **Response**: JSON response with status

#### 8. Reset Record
- **Route**: POST `/prod-002/form-checker/reset/{id}`
- **Name**: `prod.form.checker.reset`
- **Description**: Reset checker record
- **Parameters**: Record ID
- **Response**: JSON response with status

#### 9. Reject Record
- **Route**: POST `/prod-002/form-checker/reject`
- **Name**: `prod.form.checker.reject`
- **Description**: Reject checker record
- **Request Body**: Record ID and rejection reason
- **Response**: JSON response with status

#### 10. Store Record
- **Route**: POST `/prod-002/form-checker/store`
- **Name**: `prod.form.checker.store`
- **Description**: Save new checker record
- **Request Body**: Complete form data
- **Response**: JSON response with status

#### 11. Delete Record
- **Route**: DELETE `/prod-002/form-checker/delete/{id}`
- **Name**: `prod.form.checker.delete`
- **Description**: Delete checker record
- **Parameters**: Record ID
- **Response**: JSON response with status

#### 12. Export PDF
- **Route**: GET `/prod-002/form-checker/export/{id}`
- **Name**: `prod.form.checker.export`
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
- Time tracking grid
- Equipment selection interface
- PDF preview

### Navigation Flow
1. Dashboard view
2. Form creation/selection
3. Equipment assignment
4. Time detail entry
5. Activity logging
6. Status updates
7. PDF generation

### Form Elements
- Text inputs
- Time pickers
- Equipment selectors
- Operator fields
- Time detail grid
- Status buttons
- Issue notes
- Activity indicators

### Messages
- Success notifications
- Error alerts
- Validation messages
- Processing indicators

## Data Flow

### Data Input Process
1. Form submission
2. Equipment validation
3. Time tracking
4. Activity logging
5. Database storage
6. PDF generation

### Data Validation
- Required fields checking
- Time format validation
- Equipment validation
- Operator validation

### Data Storage
- Main record storage
- Equipment data (JSON)
- Time details (JSON)
- Activity logs
- Issue tracking

### Data Retrieval
- Filtered queries
- Pagination handling
- PDF generation
- Statistical calculations

## Testing Requirements

### Test Cases
1. Form submission validation
2. Time tracking accuracy
3. PDF generation
4. Filter functionality
5. CRUD operations
6. Equipment tracking
7. Status workflow

### Test Scenarios
- Complete form record creation
- Invalid data handling
- PDF report generation
- Search and filter operations
- Status update testing
- Equipment assignment
- Time detail tracking

### Acceptance Criteria
- Successful form record creation
- Accurate time tracking
- Proper PDF report generation
- Responsive UI
- Proper error handling
- Data integrity maintenance
- Working status workflow
- Valid equipment tracking

### Time Detail Structure
Day Shift Hours (06:00-18:00):
1. 06:00 to 07:00
2. 07:00 to 08:00
3. 08:00 to 09:00
4. 09:00 to 10:00
5. 10:00 to 11:00
6. 11:00 to 12:00
7. 12:00 to 13:00
8. 13:00 to 14:00
9. 14:00 to 15:00
10. 15:00 to 16:00
11. 16:00 to 17:00
12. 17:00 to 18:00

Night Shift Hours (18:00-06:00):
1. 18:00 to 19:00
2. 19:00 to 20:00
3. 20:00 to 21:00
4. 21:00 to 22:00
5. 22:00 to 23:00
6. 23:00 to 00:00
7. 00:00 to 01:00
8. 01:00 to 02:00
9. 02:00 to 03:00
10. 03:00 to 04:00
11. 04:00 to 05:00
12. 05:00 to 06:00
