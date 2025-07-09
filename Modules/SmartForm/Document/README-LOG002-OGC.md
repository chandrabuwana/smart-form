# LOG-002 OGC (Oil, Gas, Chemical) Compliance Module Documentation

## Document Overview
### Document Purpose
This document provides comprehensive documentation for the LOG-002 OGC Compliance module, which manages and tracks compliance checks for oil, gas, and chemical storage and handling facilities.

### Project Name
OGC Compliance - Smart Form Module LOG-002

### Version History
- v1.0.0 - Initial release
- Current Version: 1.0.0

### Document Status
Active/In Development

## Project Overview
### Project Description
The LOG-002 OGC Compliance module is a critical logistics component that manages weekly compliance checks for lube stations and lube trucks. It ensures proper documentation of safety standards, storage conditions, and handling procedures for oil, gas, and chemical materials.

### Project Scope
- Dashboard with compliance statistics
- Weekly compliance checks
- Lube station monitoring
- Lube truck inspections
- PDF report generation
- Multi-level approval workflow
- Compliance tracking

### Project Goals
- Track compliance status
- Monitor storage conditions
- Document inspections
- Generate compliance reports
- Support safety standards
- Track improvements
- Maintain audit trails

### Target Users
- Compliance Officers
- Safety Inspectors
- Logistics Staff
- Site Supervisors
- Safety Managers
- Audit Teams

## Functional Requirements

### User Interface Requirements
- Dashboard with statistics display:
  - Total checks counter
  - Monthly checks counter
  - Compliance status
  - Issue tracking
- Advanced filtering capabilities:
  - Date filter
  - Status filter
  - Creator filter
  - Week filter
- Inspection form interface
- PDF export functionality
- Approval workflow interface

### Form Validation Rules
- Required field validation for:
  - Document number (auto-generated)
  - Week number
  - Inspector information
  - Inspection date
  - Checklist items
  - Comments
  - Validator details
  - Checker details
- Checklist validation
- Status validation

### Data Processing Requirements
- Automatic document number generation
- PDF report generation
- Weekly statistics calculation
- Checklist processing
- Status tracking
- Issue documentation
- Comment handling

### Business Logic
- Weekly inspection workflow:
  - Checklist completion
  - Issue identification
  - Comment recording
  - Status tracking
  - Approval process
  - Report generation
- Multi-level approval
- Status management
- Issue tracking
- Improvement monitoring

### Error Handling
- Database query exception handling
- PDF generation error management
- Checklist validation error handling
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
#### Table: log_ogc_compliance
- id (Primary Key)
- doc_num (Unique)
- creator
- created_at
- updated_at

#### Table: detail_log_ogc_compliance
- id (Primary Key)
- doc_num_id (Foreign Key)
- week
- date
- lube_station (JSON)
- lube_truck (JSON)
- station_comment (JSON)
- truck_comment (JSON)
- status (JSON)
- validator
- checker
- created_at
- updated_at

### API Endpoints

#### 1. Dashboard View
- **Route**: GET `/log-002/ogc`
- **Name**: `log.ogc.dashboard`
- **Description**: Main dashboard interface
- **Query Parameters**:
  - `search` (string, optional): Search by doc number or creator
  - `creator` (string, optional): Filter by creator
- **Response**: View with statistics and filtered records

#### 2. Add Form
- **Route**: GET `/log-002/ogc/add`
- **Name**: `log.ogc.add`
- **Description**: Display inspection form
- **Query Parameters**: Week ID (optional)
- **Response**: Form view with checklist items

#### 3. Store Record
- **Route**: POST `/log-002/ogc/store`
- **Name**: `log.ogc.store`
- **Description**: Save new inspection
- **Request Body**:
  ```json
  {
    "week": "string",
    "date": "date",
    "lube_station": "json",
    "lube_truck": "json",
    "station_comment": "json",
    "truck_comment": "json",
    "validator": "string",
    "checker": "string"
  }
  ```
- **Response**: JSON response with status

#### 4. Delete Week
- **Route**: DELETE `/log-002/ogc/delete-week/{id}`
- **Name**: `log.ogc.delete-week`
- **Description**: Delete week record
- **Parameters**: Week ID
- **Response**: JSON response with status

#### 5. Delete Record
- **Route**: DELETE `/log-002/ogc/delete/{id}`
- **Name**: `log.ogc.delete`
- **Description**: Delete inspection record
- **Parameters**: Record ID
- **Response**: JSON response with status

#### 6. Detail View
- **Route**: GET `/log-002/ogc/detail/{id}`
- **Name**: `log.ogc.detail`
- **Description**: View detailed record
- **Parameters**: Record ID
- **Response**: Detailed view with all data

#### 7. Show Record
- **Route**: GET `/log-002/ogc/show/{id}`
- **Name**: `log.ogc.show`
- **Description**: Show inspection record
- **Parameters**: Record ID
- **Response**: Record view

#### 8. Approve Record
- **Route**: POST `/log-002/ogc/approve`
- **Name**: `log.ogc.approve`
- **Description**: Approve inspection record
- **Request Body**:
  ```json
  {
    "doc_num": "string",
    "week": "string",
    "checked": "string",
    "validated": "string"
  }
  ```
- **Response**: JSON response with status

#### 9. Reset Record
- **Route**: POST `/log-002/ogc/reset/{id}`
- **Name**: `log.ogc.reset`
- **Description**: Reset approval status
- **Parameters**: Record ID
- **Response**: JSON response with status

#### 10. Reject Record
- **Route**: POST `/log-002/ogc/reject`
- **Name**: `log.ogc.reject`
- **Description**: Reject inspection record
- **Request Body**: Same as Approve Record
- **Response**: JSON response with status

#### 11. Modal View
- **Route**: GET `/log-002/ogc/modal/{id}/{doc_num}`
- **Name**: `log.ogc.modal`
- **Description**: Get modal content
- **Parameters**: Record ID, Document Number
- **Response**: JSON with modal data

#### 12. Export PDF
- **Route**: GET `/log-002/ogc/export/{id}`
- **Name**: `log.ogc.export`
- **Description**: Generate PDF report
- **Parameters**: Record ID
- **Response**: PDF download

### Integration Points
- Compliance management system
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
- Comment sections
- PDF preview

### Navigation Flow
1. Dashboard view
2. Form creation/selection
3. Checklist completion
4. Comment entry
5. Approval workflow
6. Status tracking
7. PDF generation

### Form Elements
- Text inputs
- Checkboxes
- Date pickers
- Comment areas
- Status selectors
- Approval buttons
- Week selector

### Messages
- Success notifications
- Error alerts
- Validation messages
- Processing indicators

## Data Flow

### Data Input Process
1. Form submission
2. Checklist validation
3. Comment processing
4. Status tracking
5. Database storage
6. PDF generation

### Data Validation
- Required fields checking
- Checklist validation
- Status validation
- Comment validation

### Data Storage
- Main record storage
- Checklist responses
- Comments
- Status tracking
- Approval records

### Data Retrieval
- Filtered queries
- Weekly reports
- Status summaries
- Compliance metrics

## Testing Requirements

### Test Cases
1. Form submission validation
2. Checklist completion
3. Comment handling
4. Filter functionality
5. CRUD operations
6. Approval workflow
7. PDF generation

### Test Scenarios
- Complete inspection record
- Invalid data handling
- PDF report generation
- Search and filter operations
- Approval process testing
- Comment handling
- Status tracking

### Acceptance Criteria
- Successful inspection creation
- Accurate checklists
- Proper PDF generation
- Responsive UI
- Proper error handling
- Data integrity maintenance
- Working approval workflow
- Valid status tracking

### Checklist Categories
1. Lube Station
   - Storage conditions
   - Safety equipment
   - Spill containment
   - Labeling
   - Documentation

2. Lube Truck
   - Vehicle condition
   - Safety equipment
   - Containment systems
   - Documentation
   - Emergency equipment

### Required Metrics
1. Compliance rate
2. Issue frequency
3. Resolution time
4. Inspection completion
5. Approval cycle time
6. Issue categories
7. Improvement trends
