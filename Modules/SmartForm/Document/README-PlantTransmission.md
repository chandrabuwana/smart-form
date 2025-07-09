# Plant Transmission Module Documentation

## Document Overview
### Document Purpose
This document provides comprehensive documentation for the Plant Transmission module, which manages transmission testing and monitoring for plant equipment.

### Project Name
Plant Transmission Test - Smart Form Module

### Version History
- v1.0.0 - Initial release
- Current Version: 1.0.0

### Document Status
Active/In Development

## Project Overview
### Project Description
The Plant Transmission module is a specialized component of the Smart Form system designed for managing and monitoring transmission tests for plant equipment. It provides comprehensive functionality for test record management, including detailed inspections of harness, speed sensors, and power train pressure measurements.

### Project Scope
- Dashboard for test data visualization
- Detailed test form management
- Excel report generation
- Multi-level approval workflow
- Equipment data tracking
- Test result documentation for:
  - Harness testing
  - Speed sensor testing
  - Power train pressure measurements

### Project Goals
- Streamline transmission testing processes
- Ensure standardized testing procedures
- Maintain detailed test history
- Enable data-driven maintenance decisions
- Facilitate test approval workflow

### Target Users
- Plant Maintenance Engineers
- Test Technicians
- Quality Control Personnel
- Maintenance Supervisors
- Test Approvers

## Functional Requirements

### User Interface Requirements
- Dashboard with data visualization
- Test form interface
- Data filtering capabilities:
  - Machine number/serial
  - Job site
  - Check date
- Paginated data tables (10 items per page)
- Detailed test view interface

### Form Validation Rules
- Required field validation for:
  - Machine information
  - Test measurements
  - Approval information
- Data format validation
- Test parameter validation

### Data Processing Requirements
- Excel report generation
- Test data processing
- Equipment data integration
- Pagination handling
- Data filtering and sorting

### Business Logic
- Test record management
- Equipment identification
- Test parameter tracking:
  - Harness testing
  - Speed sensor measurements
  - Power train pressure readings
- Approval workflow

### Error Handling
- Database query exception handling
- Data validation errors
- Export process errors
- User-friendly error messages

## Technical Specifications

### Framework & Technologies
- Laravel Framework
- PhpSpreadsheet for Excel handling
- MySQL Database
- Bootstrap UI

### Database Schema
Tables:
1. FM_PLANT_PPM_TRANSMISI_CMT_BSS_MASTER
   - id (Primary Key)
   - machine_number
   - machine_model
   - machine_serial_no
   - machine_smr
   - jobsite
   - checkdate

2. FM_PLANT_PPM_TRANSMISI_CMT_BSS_DETAIL_HARNESS
   - id (Primary Key)
   - plant_test_id (Foreign Key)
   - harness details

3. FM_PLANT_PPM_TRANSMISI_CMT_BSS_DETAIL_SPEED_SENSOR_TEST
   - id (Primary Key)
   - plant_test_id (Foreign Key)
   - speed_sensor
   - actual_low_iddle
   - actual_high_iddle

4. FM_PLANT_PPM_TRANSMISI_CMT_BSS_DETAIL_POWER_TRAIN_PRESSURE
   - id (Primary Key)
   - plant_test_id (Foreign Key)
   - description
   - lever_position
   - actual_low_iddle
   - after_adjust_low_iddle
   - actual_high_iddle
   - after_adjust_high_iddle

### API Endpoints

#### 1. Dashboard View
- **Route**: GET `/plant-transmission/dashboard` 
- **Name**: `bss-form.plant-transmission.dashboard`
- **Description**: Displays the main dashboard interface
- **Response**: Returns blade view `SmartForm::plant/dashboard`

#### 2. Dashboard Data
- **Route**: GET `/plant-transmission/dashboard/get-data`
- **Name**: `bss-form.plant-transmission.get-data-dashboard`
- **Description**: Fetches filtered dashboard data
- **Query Parameters**:
  - `machine` (string, optional): Filter by machine number or serial
  - `jobsite` (string, optional): Filter by job site
  - `checkdate` (string, optional): Filter by check date
  - `sort` (string, default: 'id'): Sort column
  - `order` (string, default: 'asc'): Sort direction
  - `offset` (integer, default: 0): Pagination offset
  - `limit` (integer, default: 10): Items per page
- **Response**: JSON
  ```json
  {
    "total": integer,
    "totalNotFiltered": integer,
    "rows": [
      {
        "id": integer,
        "machine_number": string,
        "machine_model": string,
        "machine_serial_no": string,
        "machine_smr": string,
        "jobsite": string,
        "checkdate": string
      }
    ]
  }
  ```

#### 3. Detail View
- **Route**: GET `/plant-transmission/dashboard/detail/{id}`
- **Name**: `bss-form.plant-transmission.detail`
- **Parameters**:
  - `id` (integer): Record ID
- **Description**: Shows detailed test information
- **Response**: Returns view with:
  - Master data
  - Harness details
  - Speed sensor test data
  - Power train pressure data
  - Approval information

#### 4. Form View
- **Route**: GET `/plant-transmission/form`
- **Name**: `bss-form.plant-transmission.form`
- **Query Parameters**:
  - `reference_no` (string, optional): Reference number
- **Description**: Displays the test form interface
- **Response**: Returns blade view with reference number

#### 5. Store Data
- **Route**: POST `/plant-transmission/form/store`
- **Name**: `bss-form.plant-transmission.store`
- **Description**: Saves test data
- **Request Body**: Form data including:
  - Machine information
  - Test measurements
  - Harness details
  - Speed sensor readings
  - Power train pressure data
- **Response**: Redirect with success/error message

#### 6. Download Report
- **Route**: GET `/plant-transmission/download-report`
- **Name**: `bss-form.plant-transmission.download`
- **Description**: Generates Excel report
- **Response**: 
  - Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet
  - File: report_plant_transmission_test.xlsx
  - Contains:
    - Machine details
    - Test results
    - Harness information
    - Speed sensor data
    - Power train measurements

### Authentication and Security
- All endpoints require authentication
- CSRF protection enabled for POST requests
- Role-based access control implemented
- File download endpoints are protected

### Integration Points
- Equipment Database
- User Management System
- Excel Export System
- Approval System (FM_APPROVAL table)

### Security Requirements
- User authentication
- Role-based access control
- Data validation
- Secure file handling

## User Interface Design

### Layout Specifications
- Responsive dashboard
- Data tables with sorting
- Filter components
- Test form layout
- Detail view layout

### Navigation Flow
1. Dashboard view
2. Test form entry
3. Detail view
4. Report generation

### Form Elements
- Machine information fields
- Test measurement inputs
- Approval sections
- Export options

### Messages
- Success notifications
- Error alerts
- Validation messages
- Processing status

## Data Flow

### Data Input Process
1. Form submission
2. Data validation
3. Test parameter processing
4. Database storage

### Data Validation
- Machine data validation
- Test measurement validation
- Required field checking
- Format verification

### Data Storage
- Master test records
- Harness test details
- Speed sensor measurements
- Power train pressure readings

### Data Retrieval
- Paginated queries
- Filtered searches
- Excel report generation
- Detail view compilation

## Testing Requirements

### Test Cases
1. Form submission
2. Data validation
3. Report generation
4. Filter functionality
5. Detail view access

### Test Scenarios
- Complete test record creation
- Invalid data handling
- Report generation process
- Filter and search operations

### Acceptance Criteria
- Successful test record creation
- Accurate measurement storage
- Proper Excel report generation
- Responsive UI
- Proper error handling
- Data integrity maintenance
