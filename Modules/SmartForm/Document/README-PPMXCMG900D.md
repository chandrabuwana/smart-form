# PPMXCMG900D Module Documentation

## Document Overview
### Document Purpose
This document provides comprehensive documentation for the PPMXCMG900D module, which manages Planned Preventive Maintenance (PPM) for XCMG XE900D heavy equipment.

### Project Name
PPMXCMG900D - Smart Form Module for XCMG XE900D Maintenance

### Version History
- v1.0.0 - Initial release with core functionality
- Current Version: 1.0.0

### Document Status
Active/In Development

## Project Overview
### Project Description
The PPMXCMG900D module is a specialized component of the Smart Form system designed for managing preventive maintenance specifically for XCMG XE900D equipment. It provides comprehensive functionality for maintenance record management, including detailed inspections of engine, hydraulic, work order, and final inspection components.

### Project Scope
- Dashboard with real-time statistics and filtering
- Complete CRUD operations for maintenance records
- PDF export functionality
- Multi-level approval workflow
- Integration with equipment database
- Detailed component inspection tracking:
  - Engine inspection
  - Hydraulic system inspection
  - Work order management
  - Final inspection

### Project Goals
- Streamline XCMG XE900D maintenance processes
- Ensure standardized maintenance procedures
- Provide detailed maintenance history
- Enable data-driven maintenance decisions
- Facilitate maintenance approval workflow

### Target Users
- Maintenance Technicians
- Equipment Supervisors
- Plant Managers
- Quality Control Personnel
- Maintenance Approvers

## Functional Requirements

### User Interface Requirements
- Dashboard with statistics display
  - Total records counter
  - Monthly records counter
  - Unique unit counter
  - Job site counter
- Advanced filtering capabilities:
  - Document number search
  - Unit model filter
  - Unit CN filter
  - Job site filter
- Paginated data tables (5 items per page)
- Form interfaces for:
  - New maintenance records
  - Record editing
  - Approval process
  - Inspection details

### Form Validation Rules
- Required field validation for:
  - Document number
  - Unit information
  - Inspection details
  - Approval information
- JSON data structure validation
- Date and time validation

### Data Processing Requirements
- Automatic document number generation
- JSON data handling for inspection details
- Monthly statistics calculation
- Equipment data integration
- PDF report generation

### Business Logic
- Multi-level approval workflow:
  - Draft status
  - Checking process
  - Validation process
  - Rejection handling
- Document number format: BSS-FRM-PLA-071-YYMM-XXX
- Inspection categories:
  - Engine inspection
  - Hydraulic system
  - Work order processing
  - Final inspection

### Error Handling
- Database query exception handling
- File processing error management
- User-friendly error messages
- Logging system integration
- Transaction management

## Technical Specifications

### Framework & Technologies
- Laravel Framework
- Blade Templates
- Bootstrap UI
- MySQL Database
- DomPDF for document generation

### Database Schema
Tables:
1. ppm_xcmg_900d
   - id (Primary Key)
   - doc_num (Unique)
   - unit_model
   - unit_cn
   - job_site
   - status
   - created_at
   - updated_at
   - date_validated

2. report_ppm_xcmg_900d
   - doc_num_id (Foreign Key)
   - eng_actual (JSON)
   - eng_correction_made (JSON)
   - eng_result (JSON)
   - eng_remark (JSON)
   - hyd_actual (JSON)
   - hyd_correction_made (JSON)
   - hyd_result (JSON)
   - hyd_remark (JSON)
   - wo_actual (JSON)
   - wo_correction_made (JSON)
   - wo_result (JSON)
   - wo_remark (JSON)
   - fin_actual (JSON)
   - fin_correction_made (JSON)
   - fin_result (JSON)
   - fin_remark (JSON)

### API Endpoints
- GET /dashboard - Display maintenance dashboard
- GET /add - Show add form
- GET /detail/{id} - View record details
- POST /store - Create new record
- GET /export/{id} - Export PDF
- POST /update - Update record
- POST /approve - Approve record
- GET /show/{id} - Show record
- POST /reset/{id} - Reset record status
- POST /reject - Reject record
- DELETE /delete/{id} - Delete record

### Integration Points
- HRD System (via HrdHelper)
- Equipment Database (alat_angkut_data)
- PDF Generation System
- Logging System

### Security Requirements
- Session-based authentication
- Role-based access control
- Data validation
- CSRF protection
- SQL injection prevention

## User Interface Design

### Layout Specifications
- Responsive dashboard
- Data tables with pagination
- Search and filter components
- Form layouts for data entry
- PDF export formatting

### Navigation Flow
1. Dashboard view
2. Record creation/editing
3. Detail view
4. Approval process
5. PDF generation

### Form Elements
- Search fields
- Unit selection dropdowns
- Date inputs
- Inspection checklists
- Remark fields
- Approval buttons

### Messages
- Success notifications
- Error alerts
- Validation messages
- Confirmation dialogs

## Data Flow

### Data Input Process
1. Form submission
2. Data validation
3. JSON processing
4. Database storage
5. Approval workflow

### Data Validation
- Input sanitization
- Required fields checking
- Format verification
- Business rule validation

### Data Storage
- Main record storage
- Detailed inspection data
- Approval status tracking
- Audit logging

### Data Retrieval
- Paginated queries
- Filtered searches
- Statistical calculations
- PDF generation

## Testing Requirements

### Test Cases
1. Document number generation
2. Form submission validation
3. Approval workflow
4. PDF export functionality
5. Data filtering
6. Error handling

### Test Scenarios
- Complete maintenance record creation
- Approval process workflow
- Reset and rejection handling
- PDF generation
- Search and filter operations

### Acceptance Criteria
- Successful record creation
- Proper approval workflow
- Accurate PDF generation
- Responsive UI
- Proper error handling
- Data integrity maintenance
