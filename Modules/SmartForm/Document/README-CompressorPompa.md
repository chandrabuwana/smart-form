# Compressor Pompa Module Documentation

## Document Overview
### Document Purpose
This document provides comprehensive documentation for the Compressor Pompa module, which manages inspection and maintenance records for compressors and pumps in the plant.

### Project Name
Compressor Pompa Management - Smart Form Module

### Version History
- v1.0.0 - Initial release
- Current Version: 1.0.0

### Document Status
Active/In Development

## Project Overview
### Project Description
The Compressor Pompa module is a specialized component of the Smart Form system designed for managing and tracking compressor and pump maintenance inspections. It provides comprehensive functionality for recording detailed inspections with up to 22 different question categories.

### Project Scope
- Dashboard with statistical overview
- Detailed inspection form management
- PDF report generation
- Equipment tracking
- Location-based monitoring
- Site-specific management
- Comprehensive inspection questionnaire (22 categories)

### Project Goals
- Streamline compressor and pump inspection processes
- Maintain detailed maintenance records
- Enable site-specific monitoring
- Facilitate PDF report generation
- Track equipment performance
- Ensure standardized inspection procedures

### Target Users
- Plant Maintenance Engineers
- Equipment Inspectors
- Site Supervisors
- Maintenance Managers
- Quality Control Personnel

## Functional Requirements

### User Interface Requirements
- Dashboard with statistics display:
  - Total records counter
  - Monthly records counter
  - Location counter
  - Site counter
- Advanced filtering capabilities:
  - Document number search
  - Unit name filter
  - Location filter
  - Site filter
  - Date filter
- Paginated data tables (5 items per page)
- Detailed inspection forms
- PDF export functionality

### Form Validation Rules
- Required field validation for:
  - Document number
  - Unit information
  - Location details
  - Site information
  - Inspection answers
- JSON data structure validation for questions
- Date and time validation

### Data Processing Requirements
- Automatic document number generation
- JSON data handling for questionnaires
- PDF report generation
- Monthly statistics calculation
- Data filtering and pagination

### Business Logic
- Document number format: BSS-FRM-PLA-040-YYMM-XXX
- Question categories management (22 sections)
- Location-based organization
- Site-specific tracking
- Monthly record tracking

### Error Handling
- Database query exception handling
- PDF generation error management
- JSON parsing error handling
- User-friendly error messages
- Logging system integration

## Technical Specifications

### Framework & Technologies
- Laravel Framework
- DomPDF for PDF generation
- MySQL Database
- Bootstrap UI
- JSON data storage

### Database Schema
Table: plant_pompa_compressor
- id (Primary Key)
- doc_number (Unique)
- unit_name
- location
- site
- engine_model
- generator_model
- created_at
- updated_at
- paraf_item (JSON)
- question1 to question22 (JSON)

### API Endpoints

All routes are prefixed with `/plant-compressor` and protected by middleware: `check.auth`, `FetchMenu`, and `PermissionMenu`.

#### 1. Dashboard View
- **Route**: GET `/dashboard`
- **Name**: `plant.compressor.dashboard`
- **Description**: Main dashboard interface
- **Query Parameters**:
  - `search` (string, optional): Search by doc number, unit name, location, engine model, site, or generator model
  - `location` (string, optional): Filter by location
  - `site` (string, optional): Filter by site
  - `unit` (string, optional): Filter by unit name
  - `date` (date, optional): Filter by date
- **Response**: View with statistics and filtered records

#### 2. Add Form
- **Route**: GET `/form-compressor`
- **Name**: `plant.compressor.form`
- **Description**: Display form for creating new record
- **Response**: Form view

#### 3. Store Record
- **Route**: POST `/store-compressor`
- **Name**: `plant.compressor.store`
- **Description**: Save new compressor record
- **Request Body**:
  ```json
  {
    "unit_name": "string",
    "location": "string",
    "site": "string",
    "engine_model": "string",
    "generator_model": "string",
    "paraf_item": "json",
    "question1" to "question22": "json"
  }
  ```
- **Response**: Redirect with success/error message

#### 4. Update Record
- **Route**: POST `/update-compressor`
- **Name**: `plant.compressor.update`
- **Description**: Update existing record
- **Request Body**: Same as Store Record
- **Response**: Redirect with success/error message

#### 5. Export PDF
- **Route**: GET `/form-compressor/export/{id}`
- **Name**: `plant.compressor.export`
- **Description**: Generate PDF report
- **Parameters**: 
  - `id` (integer): Record ID
- **Response**: PDF download

#### 6. Delete Record
- **Route**: DELETE `/delete-compressor/{id}`
- **Name**: `plant.compressor.delete`
- **Description**: Remove record
- **Parameters**:
  - `id` (integer): Record ID
- **Response**: JSON response with status

All routes are protected by authentication and permission checks. The system uses named routes for better maintainability and reverse routing.

### Integration Points
- PDF Generation System
- Logging System
- Database System
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
2. Record creation/editing
3. Form submission
4. PDF generation
5. Record management

### Form Elements
- Text inputs
- Dropdown selections
- Date pickers
- Checkbox groups
- Radio button sets
- JSON-based question forms

### Messages
- Success notifications
- Error alerts
- Validation messages
- Processing indicators

## Data Flow

### Data Input Process
1. Form submission
2. Data validation
3. JSON processing
4. Database storage
5. PDF generation

### Data Validation
- Required fields checking
- JSON structure validation
- Date format validation
- Business rule validation

### Data Storage
- Main record storage
- JSON data fields
- Document numbering
- Audit logging

### Data Retrieval
- Paginated queries
- Filtered searches
- PDF generation
- Statistical calculations

## Testing Requirements

### Test Cases
1. Form submission validation
2. PDF generation
3. JSON data handling
4. Filter functionality
5. CRUD operations

### Test Scenarios
- Complete form submission
- Invalid data handling
- PDF generation process
- Search and filter operations
- Document number generation

### Acceptance Criteria
- Successful record creation
- Proper PDF generation
- Accurate JSON handling
- Responsive UI
- Proper error handling
- Data integrity maintenance
