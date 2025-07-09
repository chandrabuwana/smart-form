# PROD-001 Coal Getting Inspection Module Documentation

## Document Overview
### Document Purpose
This document provides comprehensive documentation for the PROD-001 Coal Getting Inspection module, which manages and tracks coal getting operations and safety inspections.

### Project Name
Coal Getting Inspection - Smart Form Module PROD-001

### Version History
- v1.0.0 - Initial release
- Current Version: 1.0.0

### Document Status
Active/In Development

## Project Overview
### Project Description
The PROD-001 Coal Getting Inspection module is a critical production operations component that manages and tracks coal getting activities and safety inspections. It ensures proper documentation of equipment checks, safety procedures, and operational standards in coal extraction activities.

### Project Scope
- Dashboard with inspection statistics
- Coal getting inspection form
- Equipment and safety checklist
- PDF report generation
- Location-specific monitoring
- Compliance tracking
- Finding documentation

### Project Goals
- Ensure safe coal extraction
- Track equipment condition
- Monitor operational compliance
- Generate inspection reports
- Support quality control
- Identify improvement areas
- Maintain safety standards

### Target Users
- Production Supervisors
- Equipment Operators
- Safety Officers
- Area PICs
- Quality Control Staff
- Production Managers

## Functional Requirements

### User Interface Requirements
- Dashboard with statistics display:
  - Total inspections counter
  - Monthly inspections counter
  - Location count
  - Attention alerts counter
- Advanced filtering capabilities:
  - Date range filter
  - Location filter
  - Document number search
  - Area PIC search
- Inspection form interface
- PDF export functionality
- Status tracking interface

### Form Validation Rules
- Required field validation for:
  - Document number (auto-generated)
  - Inspection date
  - Location
  - Area PIC
  - Created by
  - Checklist items
- Status validation
- Checklist validation

### Data Processing Requirements
- Automatic document number generation
- PDF report generation
- Monthly statistics calculation
- Checklist processing
- Status tracking
- Finding documentation

### Business Logic
- Checklist validation:
  - Equipment condition checks
  - Safety procedure checks
  - Operational standard checks
  - Quality control checks
- Location-based tracking
- Status management
- User role-based access control
- Attention item tracking

### Error Handling
- Database query exception handling
- PDF generation error management
- Date parsing error handling
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
#### Table: she_coal_getting
- id (Primary Key)
- doc_number (Unique)
- inspection_date
- location
- area_pic
- created_by
- checklist_items (JSON)
- status
- isActive
- created_at
- updated_at

### API Endpoints

#### 1. Dashboard View
- **Route**: GET `/prod-001/coal-getting`
- **Name**: `prod.coal-getting.dashboard`
- **Description**: Main dashboard interface
- **Query Parameters**:
  - `search` (string, optional): Search by doc number, location, area PIC, or creator
  - `start_date` (date, optional): Filter by start date
  - `end_date` (date, optional): Filter by end date
  - `location` (string, optional): Filter by location
- **Response**: View with statistics and filtered records

#### 2. Add Form
- **Route**: GET `/prod-001/coal-getting/add`
- **Name**: `prod.coal-getting.add-form`
- **Description**: Display inspection form
- **Response**: Form view with checklist

#### 3. Edit Form
- **Route**: GET `/prod-001/coal-getting/edit/{id}`
- **Name**: `prod.coal-getting.edit`
- **Description**: Edit inspection form
- **Parameters**: Record ID
- **Response**: Form view with existing data

#### 4. Store Record
- **Route**: POST `/prod-001/coal-getting/store`
- **Name**: `prod.coal-getting.store`
- **Description**: Save new inspection
- **Request Body**:
  ```json
  {
    "inspection_date": "date",
    "location": "string",
    "area_pic": "string",
    "checklist_items": "array",
    "created_by": "string"
  }
  ```
- **Response**: JSON response with status

#### 5. Update Record
- **Route**: POST `/prod-001/coal-getting/update/{id}`
- **Name**: `prod.coal-getting.update`
- **Description**: Update inspection record
- **Parameters**: Record ID
- **Request Body**: Same as Store Record
- **Response**: JSON response with status

#### 6. Export PDF
- **Route**: GET `/prod-001/coal-getting/export/{id}`
- **Name**: `prod.coal-getting.export`
- **Description**: Generate PDF report
- **Parameters**: Record ID
- **Response**: PDF download

#### 7. Update Status
- **Route**: POST `/prod-001/coal-getting/status`
- **Name**: `prod.coal-getting.update-status`
- **Description**: Update inspection status
- **Request Body**:
  ```json
  {
    "id": "integer",
    "status": "string"
  }
  ```
- **Response**: JSON response with status

#### 8. Delete Record
- **Route**: DELETE `/prod-001/coal-getting/delete`
- **Name**: `prod.coal-getting.delete`
- **Description**: Soft delete inspection record
- **Request Body**:
  ```json
  {
    "id": "integer"
  }
  ```
- **Response**: JSON response with status

### Integration Points
- HRD System for user validation
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
- Inspection form layout
- PDF preview

### Navigation Flow
1. Dashboard view
2. Inspection form creation
3. Checklist completion
4. Form submission
5. Status updates
6. PDF generation

### Form Elements
- Text inputs
- Date pickers
- Location selector
- Checklist items
- Status buttons
- Finding notes
- Status indicators

### Messages
- Success notifications
- Error alerts
- Validation messages
- Processing indicators

## Data Flow

### Data Input Process
1. Form submission
2. Checklist validation
3. Status tracking
4. Database storage
5. PDF generation

### Data Validation
- Required fields checking
- Checklist validation
- Date format validation
- Status validation

### Data Storage
- Main record storage
- Checklist data (JSON)
- Status tracking
- Audit logging

### Data Retrieval
- Filtered queries
- Pagination handling
- PDF generation
- Statistical calculations

## Testing Requirements

### Test Cases
1. Form submission validation
2. Checklist completion
3. PDF generation
4. Filter functionality
5. CRUD operations
6. Date handling
7. Status tracking

### Test Scenarios
- Complete inspection record creation
- Invalid data handling
- PDF report generation
- Search and filter operations
- Status update testing
- Checklist validation
- Location filtering

### Acceptance Criteria
- Successful inspection record creation
- Accurate checklist tracking
- Proper PDF report generation
- Responsive UI
- Proper error handling
- Data integrity maintenance
- Working status workflow
- Valid finding documentation

### Checklist Items
1. Supervisor validates P2H fleet coal getting
2. Operator has received coal quality education
3. Excavator track shoe cleanliness
4. Bucket teeth in good/normal condition
5. No oil/fuel leaks from units
6. Hauler unit bed cleanliness
7. No potential loose components on hauler unit
8. Coal is exposed
9. Coal cleaning using cutting edge
10. Cleaning area offset roof and floor min 1 meter
11. Coal has been cleaned
12. Coal size meets customer requirements
13. Loading Front Cleanliness:
    - a. soil
    - b. mud
    - c. parting
    - d. waste
14. Loading point area drainage
15. Parting handling (boundary handling and daytime operations)
16. Night lighting
17. Roof and floor data measurement
