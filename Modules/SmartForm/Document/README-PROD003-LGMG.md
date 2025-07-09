# PROD-003 LGMG (Light Goods Motor Grader) Inspection Module Documentation

## Document Overview
### Document Purpose
This document provides comprehensive documentation for the PROD-003 LGMG Inspection module, which manages and tracks pre-operation inspections for Light Goods Motor Grader equipment.

### Project Name
LGMG Inspection - Smart Form Module PROD-003

### Version History
- v1.0.0 - Initial release
- Current Version: 1.0.0

### Document Status
Active/In Development

## Project Overview
### Project Description
The PROD-003 LGMG Inspection module is a critical production operations component that manages and tracks pre-operation inspections for Light Goods Motor Grader equipment. It ensures proper documentation of equipment condition, operator checks, and safety compliance.

### Project Scope
- Dashboard with inspection statistics
- Equipment inspection form
- Multi-category checklist
- PDF report generation
- Operator tracking
- Fuel and meter readings
- Equipment condition monitoring

### Project Goals
- Track equipment condition
- Monitor operator inspections
- Document safety compliance
- Generate inspection reports
- Support maintenance planning
- Track equipment usage
- Maintain safety standards

### Target Users
- Equipment Operators
- Maintenance Staff
- Safety Officers
- Operations Managers
- Equipment Managers
- Maintenance Planners

## Functional Requirements

### User Interface Requirements
- Dashboard with statistics display:
  - Total inspections counter
  - Monthly inspections counter
  - Equipment counter
  - Status tracker
- Advanced filtering capabilities:
  - Equipment number filter
  - Operator name filter
  - Document number search
  - Approval status filter
- Inspection form interface
- PDF export functionality
- Approval workflow interface

### Form Validation Rules
- Required field validation for:
  - Document number (auto-generated)
  - Operator name and NRP
  - Equipment number
  - Shift information
  - Date
  - Hour meter readings
  - Fuel readings
  - Checklist items
- Reading validation
- Equipment validation

### Data Processing Requirements
- Automatic document number generation
- PDF report generation
- Monthly statistics calculation
- Checklist processing
- Approval tracking
- Equipment tracking
- Issue documentation

### Business Logic
- Equipment inspection workflow:
  - Pre-operation checks
  - Component verification
  - Safety compliance
  - Condition assessment
- Multi-level approval process
- Status management
- Equipment usage tracking
- Issue reporting
- Performance monitoring

### Error Handling
- Database query exception handling
- PDF generation error management
- Reading validation error handling
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
#### Table: lgmg
- id (Primary Key)
- doc_num (Unique)
- nama_operator
- shift
- nrp
- fuel_awal
- fuel_akhir
- tanggal
- no_unit
- km_star
- km_akhir
- hm_star
- hm_akhir
- delete_status
- status (JSON)
- created_at
- updated_at

#### Table: lgmg_pertanyaan
- id (Primary Key)
- category
- pertanyaan

#### Table: lgmg_detail
- id (Primary Key)
- lgmg_id (Foreign Key)
- pertanyaan_id (Foreign Key)
- jawaban
- keterangan (JSON)

### API Endpoints

#### 1. Dashboard View
- **Route**: GET `/prod-003/lgmg`
- **Name**: `prod.lgmg.dashboard`
- **Description**: Main dashboard interface
- **Query Parameters**:
  - `search` (string, optional): Search by doc number, unit number, or operator
  - `no_unit` (string, optional): Filter by unit number
  - `nama_operator` (string, optional): Filter by operator name
  - `approval` (string, optional): Filter by approval status
- **Response**: View with statistics and filtered records

#### 2. Add Form
- **Route**: GET `/prod-003/lgmg/add`
- **Name**: `prod.lgmg.add`
- **Description**: Display inspection form
- **Response**: Form view with checklist categories

#### 3. Store Record
- **Route**: POST `/prod-003/lgmg/store`
- **Name**: `prod.lgmg.store`
- **Description**: Save new inspection
- **Request Body**:
  ```json
  {
    "nama_operator": "string",
    "shift": "string",
    "nrp": "string",
    "fuel_awal": "number",
    "fuel_akhir": "number",
    "tanggal": "date",
    "no_unit": "string",
    "km_star": "number",
    "km_akhir": "number",
    "hm_star": "number",
    "hm_akhir": "number",
    "checklist_items": "array"
  }
  ```
- **Response**: JSON response with status

#### 4. Delete Record
- **Route**: DELETE `/prod-003/lgmg/delete/{id}`
- **Name**: `prod.lgmg.delete`
- **Description**: Delete inspection record
- **Parameters**: Record ID
- **Response**: JSON response with status

#### 5. Detail View
- **Route**: GET `/prod-003/lgmg/detail/{id}`
- **Name**: `prod.lgmg.detail`
- **Description**: View detailed record
- **Parameters**: Record ID
- **Response**: Detailed view with all data

#### 6. Update Record
- **Route**: PUT `/prod-003/lgmg/update`
- **Name**: `prod.lgmg.update`
- **Description**: Update inspection record
- **Request Body**: Same as Store Record
- **Response**: JSON response with status

#### 7. Show Record
- **Route**: GET `/prod-003/lgmg/show/{id}`
- **Name**: `prod.lgmg.show`
- **Description**: Show inspection record
- **Parameters**: Record ID
- **Response**: Record view

#### 8. Approve Record
- **Route**: POST `/prod-003/lgmg/approve`
- **Name**: `prod.lgmg.approve`
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

#### 9. Reset Record
- **Route**: POST `/prod-003/lgmg/reset/{id}`
- **Name**: `prod.lgmg.reset`
- **Description**: Reset approval status
- **Parameters**: Record ID
- **Response**: JSON response with status

#### 10. Reject Record
- **Route**: POST `/prod-003/lgmg/reject`
- **Name**: `prod.lgmg.reject`
- **Description**: Reject inspection record
- **Request Body**: Same as Approve Record
- **Response**: JSON response with status

#### 11. Export PDF
- **Route**: GET `/prod-003/lgmg/export/{id}`
- **Name**: `prod.lgmg.export`
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
- Inspection checklist
- Equipment readings form
- PDF preview

### Navigation Flow
1. Dashboard view
2. Form creation/selection
3. Equipment details
4. Checklist completion
5. Readings entry
6. Approval workflow
7. PDF generation

### Form Elements
- Text inputs
- Number inputs
- Date pickers
- Equipment selectors
- Checklist items
- Approval buttons
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
4. Checklist processing
5. Database storage
6. PDF generation

### Data Validation
- Required fields checking
- Reading validation
- Equipment validation
- Approval validation

### Data Storage
- Main record storage
- Checklist responses
- Equipment readings
- Approval statuses
- Issue notes

### Data Retrieval
- Filtered queries
- Pagination handling
- PDF generation
- Statistical calculations

## Testing Requirements

### Test Cases
1. Form submission validation
2. Reading accuracy verification
3. PDF generation
4. Filter functionality
5. CRUD operations
6. Approval workflow
7. Equipment tracking

### Test Scenarios
- Complete inspection record creation
- Invalid data handling
- PDF report generation
- Search and filter operations
- Approval process testing
- Equipment validation
- Reading verification

### Acceptance Criteria
- Successful inspection record creation
- Accurate equipment readings
- Proper PDF report generation
- Responsive UI
- Proper error handling
- Data integrity maintenance
- Working approval workflow
- Valid equipment tracking

### Checklist Categories
1. Cabin
2. Engine
3. Undercarriage
4. Hydraulics
5. Safety Equipment
6. Lighting
7. Controls
8. Attachments
9. Documentation
10. General Condition
