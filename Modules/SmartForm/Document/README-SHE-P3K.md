# SHE P3K (First Aid Kit) Inspection Module Documentation

## Document Overview
### Document Purpose
This document provides comprehensive documentation for the SHE P3K (First Aid Kit) inspection module, which manages and tracks first aid kit inspections and inventory across different locations.

### Project Name
P3K (First Aid Kit) Inspection Management - Smart Form Module

### Version History
- v1.0.0 - Initial release
- Current Version: 1.0.0

### Document Status
Active/In Development

## Project Overview
### Project Description
The P3K module is a critical health and safety component that manages and tracks first aid kit inspections and inventory levels across various locations. It ensures proper stocking and maintenance of first aid supplies for workplace safety compliance.

### Project Scope
- Dashboard with inspection statistics
- First aid kit inventory management
- Multi-level approval workflow
- PDF report generation
- Location-specific monitoring
- Stock level alerts
- Comprehensive item checklist

### Project Goals
- Ensure regular first aid kit inspections
- Maintain adequate supply levels
- Track item expiration dates
- Generate inspection reports
- Support multi-level approvals
- Identify restocking needs

### Target Users
- Safety Officers
- Health Inspectors
- Supervisors
- Department Heads
- SHE Officers
- First Aid Personnel

## Functional Requirements

### User Interface Requirements
- Dashboard with statistics display:
  - Total inspections counter
  - Low stock alerts
  - Location status
  - Approval status indicators
- Advanced filtering capabilities:
  - Date range filter
  - Location filter
  - Document number search
  - Stock status filter
- Inspection form interface
- PDF export functionality
- Multi-level approval interface

### Form Validation Rules
- Required field validation for:
  - Document number (auto-generated)
  - Location
  - Inspection date
  - Item quantities
  - Inspector details
- Stock level validation
- Status validation
- Approval workflow validation

### Data Processing Requirements
- Automatic document number generation
- PDF report generation
- Stock level calculations
- Low stock alerts
- Approval status tracking
- Item expiration tracking

### Business Logic
- Multi-level approval workflow:
  - Inspector 1 review
  - Inspector 2 review
  - Supervisor approval
  - Department Head approval
  - SHE Officer approval
- Stock level monitoring
- Monthly inspection requirements
- Item threshold alerts
- User role-based access control

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
#### Table: she_p3k
- id (Primary Key)
- doc_number (Unique)
- location
- inspection_date
- items_data (JSON)
  - item_id
  - name
  - qty (required)
  - current_qty
- created_by
- created_at
- updated_at
- inspector_1_status
- inspector_1_id
- inspector_1_date
- inspector_2_status
- inspector_2_id
- inspector_2_date
- supervisor_status
- supervisor_id
- supervisor_date
- dh_status
- dh_id
- dh_date
- she_status
- she_id
- she_date
- approval_status
- notes

### Standard P3K Items
1. Kasa steril terbungkus (20)
2. Perban (lebar 5 cm) (2)
3. Perban (lebar 10 cm) (2)
4. Plester (lebar 1,25 cm) (2)
5. Plester Cepat (10)
6. Kapas (25 gram) (1)
7. Kain segitiga/mittela (2)
8. Gunting (1)
9. Peniti (12)
10. Sarung tangan sekali pakai (2)
11. Masker (2)
12. Pinset (1)
13. Lampu senter (1)
14. Gelas untuk cuci mata (1)
15. Kantong plastik bersih (1)
16. Aquades (100 ml lar. Saline) (1)
17. Povidon Iodin (60 ml) (1)
18. Alkohol 70% (1)
19. Buku panduan P3K (1)
20. Buku catatan (1)
21. Daftar isi kotak (1)

### API Endpoints

#### 1. Dashboard View
- **Route**: GET `/she-p3k/dashboard`
- **Name**: `she-p3k.dashboard`
- **Description**: Main dashboard interface
- **Query Parameters**:
  - `search` (string, optional): Search by doc number or location
  - `start_date` (date, optional): Filter by start date
  - `end_date` (date, optional): Filter by end date
  - `location` (string, optional): Filter by location
  - `stock_status` (string, optional): Filter by stock status
- **Response**: View with statistics and filtered records

#### 2. Add Form
- **Route**: GET `/she-p3k/add`
- **Name**: `she-p3k.add-form`
- **Description**: Display inspection form
- **Response**: Form view with item checklist

#### 3. Store Record
- **Route**: POST `/she-p3k/store`
- **Name**: `she-p3k.store`
- **Description**: Save new inspection
- **Request Body**:
  ```json
  {
    "location": "string",
    "inspection_date": "date",
    "items_data": [
      {
        "item_id": "integer",
        "name": "string",
        "qty": "integer",
        "current_qty": "integer"
      }
    ],
    "notes": "string"
  }
  ```
- **Response**: JSON response with status

#### 4. Update Record
- **Route**: POST `/she-p3k/update/{id}`
- **Name**: `she-p3k.update`
- **Description**: Update inspection record
- **Request Body**: Same as Store Record
- **Response**: JSON response with status

#### 5. Export PDF
- **Route**: GET `/she-p3k/export/{id}`
- **Name**: `she-p3k.export`
- **Description**: Generate PDF report
- **Parameters**: 
  - `id` (integer): Record ID
- **Response**: PDF download

#### 6. Edit Form
- **Route**: GET `/she-p3k/edit/{id}`
- **Name**: `she-p3k.edit-form`
- **Description**: Edit inspection form
- **Parameters**: Record ID
- **Response**: Form view with existing data

#### 7. Delete Record
- **Route**: DELETE `/she-p3k/delete/{id}`
- **Name**: `she-p3k.delete`
- **Description**: Delete inspection record
- **Parameters**: Record ID
- **Response**: JSON response with status

#### 8. Approval Endpoints
- **Approve**:
  - **Route**: POST `/she-p3k/approve/{id}/{role}`
  - **Name**: `she-p3k.approve`
  - **Description**: Approve inspection
  - **Parameters**:
    - `id` (integer): Record ID
    - `role` (string): Approver role
  - **Request Body**:
    ```json
    {
      "notes": "string"
    }
    ```

- **Approve All**:
  - **Route**: POST `/she-p3k/approve-all/{id}`
  - **Name**: `she-p3k.approve-all`
  - **Description**: Approve all roles at once
  - **Parameters**: Record ID
  - **Request Body**: Same as Approve

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
3. Form submission
4. Multi-level approval process
5. PDF generation

### Form Elements
- Text inputs
- Date pickers
- Location selectors
- Item quantity inputs
- Approval buttons
- Status indicators

### Messages
- Success notifications
- Error alerts
- Validation messages
- Processing indicators

## Data Flow

### Data Input Process
1. Form submission
2. Data validation
3. Status tracking
4. Database storage
5. PDF generation

### Data Validation
- Required fields checking
- Date format validation
- Status validation
- Item quantity validation

### Data Storage
- Main record storage
- Status tracking
- Approval tracking
- Audit logging

### Data Retrieval
- Filtered queries
- Pagination handling
- PDF generation
- Statistical calculations

## Testing Requirements

### Test Cases
1. Form submission validation
2. PDF generation
3. Multi-level approval workflow
4. Filter functionality
5. CRUD operations
6. Date handling
7. Stock level alerts

### Test Scenarios
- Complete inspection record creation
- Invalid data handling
- PDF report generation
- Search and filter operations
- Approval process testing
- Status reset functionality
- Low stock alerts

### Acceptance Criteria
- Successful inspection record creation
- Accurate inventory tracking
- Proper PDF report generation
- Responsive UI
- Proper error handling
- Data integrity maintenance
- Working approval workflow
- Valid stock level alerts
