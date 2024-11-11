Loan Management API
This API provides endpoints for managing user registrations, user logins, and loan operations, including creating, updating, approving, and deleting loans. The API uses JWT for authentication.

Table of Contents
Setup
Environment Variables
Migrations
Running the Server
API Endpoints
Testing the Endpoints with Postman
Setup

Clone the repository:
git clone https://github.com/mekayashwanth/PHP-Backend-Engineer-Take-Home-Assessment-
cd PHP-Backend-Engineer-Take-Home-Assessment-

Install dependencies:

composer install

Set up the environment file:
cp .env.example .env

Generate the application key:
php artisan key:generate

Install JWT package:
php artisan jwt:secret

Environment Variables
Configure the following variables in your .env file:

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_username
DB_PASSWORD=your_password
Ensure these are properly configured to match your database setup.

Migrations
Run the migrations to create the necessary database tables:
php artisan migrate

Running the Server
To start the Laravel development server:
php artisan serve

The server will run at http://127.0.0.1:8000.

API Endpoints
Authentication Endpoints
Register a user
POST /api/register
Request Body:
json

{
"username": "testuser",
"password": "password123",
"is_lender": true
}

Login a user

POST /api/login
Request Body:
json
{
"username": "testuser",
"password": "password123"
}

Loan Endpoints
All loan-related endpoints require authentication.

Create a Loan
POST /api/loans
Request Body:
json
{
"amount": 1500,
"lender_id": 2,
"borrower_id": 3
}

List all Loans

GET /api/loans
Approve a Loan (Only lender of the loan can approve)

POST /api/loans/{id}/approve
Update a Loan (Only lender of the loan can update)

PUT /api/loans/{id}
Request Body:
json
{
"amount": 2000,
"status": "approved"
}

Delete a Loan (Only lender of the loan can delete)

DELETE /api/loans/{id}

Testing the Endpoints with Postman

Setup Authentication
After registering and logging in a user, copy the JWT token received from the /api/login response.
In Postman, go to the Authorization tab in each request, select Bearer Token, and paste the token.

Testing Registration
Method: POST
URL: http://127.0.0.1:8000/api/register
Body:
json
{
"username": "testuser",
"password": "password123",
"is_lender": true
}

Send the request and check for a success message.
Testing Login
Method: POST
URL: http://127.0.0.1:8000/api/login
Body:
json
{
"username": "testuser",
"password": "password123"
}
Send the request and copy the token from the response.

Testing Loan Creation
Method: POST
URL: http://127.0.0.1:8000/api/loans
Headers: Add the Authorization header with Bearer Token set to the token received from login.
Body:
json
{
"amount": 1500,
"lender_id": 2,
"borrower_id": 3
}
Send the request and check for a success message.

Testing Loan Approval
Method: POST
URL: http://127.0.0.1:8000/api/loans/{id}/approve
Replace {id} with the loan ID you want to approve.
Headers: Add the Authorization header with Bearer Token.
Send the request and check for a success message.

Testing Loan Deletion
Method: DELETE
URL: http://127.0.0.1:8000/api/loans/{id}
Replace {id} with the loan ID you want to delete.
Headers: Add the Authorization header with Bearer Token.
Send the request and check for a success message.
