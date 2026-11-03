# School MIS API - Authentication Flow

## 1. Overview

School MIS uses Laravel Sanctum for API authentication.

The API uses Bearer Tokens to authenticate users.

Base URL:

http://127.0.0.1:8000/api/v1

## 2. User Authentication

Users authenticate using their username and password.

### Login

Method: POST

Endpoint:

/login

Request Body:

{
    "username": "admin",
    "password": "your_password"
}

Successful Response:

- HTTP 200 OK
- Returns a Sanctum Bearer Token.
- Returns user information.
- Returns user level permissions.

The returned token must be used for protected API requests.

## 3. Register User

Only administrators with admin_level >= 1 can register users.

Method: POST

Endpoint:

/register

Middleware:

- auth:sanctum
- level:admin_level,1

Request Body:

{
    "staff_id": 1,
    "username": "newuser",
    "password": "password123",
    "password_confirmation": "password123"
}

The staff_id must belong to an active staff member.

A corresponding user_level record is created automatically.

## 4. Authenticated User Information

Method: GET

Endpoint:

/user

Middleware:

- auth:sanctum

Returns the authenticated user's information, staff information,
user level permissions, and avatar URL.

## 5. Logout

Method: POST

Endpoint:

/logout

Middleware:

- auth:sanctum

The current access token is deleted.

The revoked token can no longer access protected endpoints.

## 6. User Avatar Upload

Method: POST

Endpoint:

/me/avatar

Middleware:

- auth:sanctum

Content-Type:

multipart/form-data

Form Data:

avatar: image file

Validation Rules:

- Required image file.
- Accepted formats: JPG, JPEG, PNG, WEBP.
- Maximum file size: 2048 KB.
- Maximum dimensions: 4000 x 4000 pixels.

Images are stored on the public disk:

storage/app/public/avatars

Public image URL:

/storage/avatars/{filename}

The API returns avatar_url.

When a new avatar is uploaded successfully,
the previous avatar file is deleted.

## 7. Staff Authorization Policy

StaffPolicy controls access to staff records.

Permissions:

- Administrators can view all staff records.
- Regular users can view their own staff record.
- Regular users cannot view another staff member's record.
- Only administrators can create staff records.
- Only administrators can update staff records.
- Only administrators can delete staff records.

Staff API routes require Sanctum authentication.

## 8. User Permission Levels

School MIS uses the user_level table.

Available permission levels:

- admin_level
- academic_level
- student_level
- teacher_level
- staff_level
- finance_level
- library_level
- stock_level
- IT_level

The CheckUserLevel middleware checks whether a user
has the required permission.

## 9. Standard API Responses

HTTP 200:
Request successful.

HTTP 201:
Resource created successfully.

HTTP 401:
Unauthenticated. A valid token is required.

HTTP 403:
The authenticated user does not have permission.

HTTP 404:
Resource or endpoint not found.

HTTP 409:
Request conflicts with existing related records.

HTTP 422:
Validation failed.

HTTP 500:
Unexpected server error.

## 10. Security Notes

- Never expose access tokens publicly.
- Use Bearer Token authentication for protected routes.
- Passwords are stored using hashing.
- Logout revokes the current access token.
- Never return passwords in API resources.
- Only authorized administrators can register users.