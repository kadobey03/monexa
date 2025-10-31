# Monexa Fintech Platform - RESTful API Documentation

## İçindekiler
- [Genel Bakış](#genel-bakış)
- [Authentication](#authentication)
- [User Management API](#user-management-api)
- [Financial Operations API](#financial-operations-api)
- [Investment Plans API](#investment-plans-api)
- [Notification API](#notification-api)
- [Admin Management API](#admin-management-api)
- [Lead Management API](#lead-management-api)
- [Error Handling](#error-handling)
- [Rate Limiting](#rate-limiting)

## Genel Bakış

Monexa API, Laravel Sanctum tabanlı token authentication kullanan RESTful bir API'dir. Tüm API endpoint'leri JSON format'ında request ve response alır.

### Base URL
```
Production: https://api.monexa.app/api
Staging: https://staging-api.monexa.app/api
Development: http://localhost:8000/api
```

### API Versioning
- **Current Version**: v1 (default)
- **Content-Type**: `application/json`
- **Accept**: `application/json`

### Global Headers
```http
Content-Type: application/json
Accept: application/json
Authorization: Bearer {token} # Required for authenticated endpoints
```

## Authentication

### Register New User
Create a new user account.

```http
POST /auth/register
```

**Request Body:**
```json
{
  "name": "John Doe",
  "email": "john@example.com",
  "password": "password123",
  "password_confirmation": "password123",
  "phone_code": "+1",
  "phone": "1234567890",
  "country": "US",
  "ref_by": "12345" // Optional referral ID
}
```

**Response (201 Created):**
```json
{
  "success": true,
  "message": "Registration successful",
  "data": {
    "user": {
      "id": 123,
      "name": "John Doe",
      "email": "john@example.com",
      "created_at": "2025-10-31T14:27:10.000Z"
    },
    "token": "1|abc123def456..."
  }
}
```

### Login User
Authenticate user and receive access token.

```http
POST /auth/login
```

**Request Body:**
```json
{
  "email": "john@example.com",
  "password": "password123"
}
```

**Response (200 OK):**
```json
{
  "success": true,
  "message": "Login successful",
  "data": {
    "user": {
      "id": 123,
      "name": "John Doe",
      "email": "john@example.com",
      "account_bal": "1250.50",
      "kyc_status": "approved"
    },
    "token": "2|xyz789abc123...",
    "expires_at": "2025-11-30T14:27:10.000Z"
  }
}
```

### Logout User
Invalidate the current access token.

```http
POST /auth/logout
Authorization: Bearer {token}
```

**Response (200 OK):**
```json
{
  "success": true,
  "message": "Successfully logged out"
}
```

### Refresh Token
Get a new access token using current valid token.

```http
POST /auth/refresh
Authorization: Bearer {token}
```

**Response (200 OK):**
```json
{
  "success": true,
  "data": {
    "token": "3|newtoken123...",
    "expires_at": "2025-11-30T14:27:10.000Z"
  }
}
```

## User Management API

### Get User Profile
Retrieve authenticated user's profile information.

```http
GET /user/profile
Authorization: Bearer {token}
```

**Response (200 OK):**
```json
{
  "success": true,
  "data": {
    "id": 123,
    "name": "John Doe",
    "email": "john@example.com",
    "phone": "1234567890",
    "country": "US",
    "currency": "USD",
    "account_bal": "1250.50",
    "bonus": "50.00",
    "ref_bonus": "25.00",
    "demo_balance": "1000.00",
    "kyc_status": "approved",
    "is_verified": true,
    "lead_status": "active_client",
    "lead_score": 85,
    "created_at": "2025-01-15T10:30:00.000Z",
    "referral": {
      "ref_link": "https://monexa.app/register?ref=12345",
      "total_referrals": 5,
      "total_commission": "125.50"
    }
  }
}
```

### Update User Profile
Update user profile information.

```http
PUT /user/profile
Authorization: Bearer {token}
```

**Request Body:**
```json
{
  "name": "John Smith",
  "phone": "1234567891",
  "country": "US",
  "currency": "USD",
  "company_name": "Tech Corp",
  "company_website": "https://techcorp.com",
  "industry": "Technology"
}
```

**Response (200 OK):**
```json
{
  "success": true,
  "message": "Profile updated successfully",
  "data": {
    "id": 123,
    "name": "John Smith",
    "phone": "1234567891",
    "updated_at": "2025-10-31T14:27:10.000Z"
  }
}
```

### Upload KYC Documents
Upload KYC verification documents.

```http
POST /user/kyc/upload
Authorization: Bearer {token}
Content-Type: multipart/form-data
```

**Request Body:**
```
identity_front: [file] # ID front image
identity_back: [file]  # ID back image
address_proof: [file]  # Address proof document
selfie: [file]         # Selfie with ID
document_type: "passport" # passport, license, national_id
```

**Response (201 Created):**
```json
{
  "success": true,
  "message": "KYC documents uploaded successfully",
  "data": {
    "kyc_application_id": 456,
    "status": "pending_review",
    "submitted_at": "2025-10-31T14:27:10.000Z",
    "expected_review_time": "24-48 hours"
  }
}
```

### Get KYC Status
Check KYC verification status.

```http
GET /user/kyc/status
Authorization: Bearer {token}
```

**Response (200 OK):**
```json
{
  "success": true,
  "data": {
    "status": "approved", // pending, approved, rejected
    "submitted_at": "2025-10-30T10:15:00.000Z",
    "reviewed_at": "2025-10-31T09:30:00.000Z",
    "reviewer_note": "All documents verified successfully",
    "documents": [
      {
        "type": "identity_front",
        "status": "approved",
        "uploaded_at": "2025-10-30T10:15:00.000Z"
      }
    ]
  }
}
```

## Financial Operations API

### Get Balance Information
Retrieve user's financial balance summary.

```http
GET /financial/balance
Authorization: Bearer {token}
```

**Response (200 OK):**
```json
{
  "success": true,
  "data": {
    "account_balance": "1250.50",
    "bonus_balance": "50.00",
    "referral_bonus": "25.00",
    "demo_balance": "1000.00",
    "currency": "USD",
    "total_deposits": "2000.00",
    "total_withdrawals": "500.00",
    "pending_deposits": "100.00",
    "pending_withdrawals": "0.00",
    "available_for_withdrawal": "1250.50"
  }
}
```

### Get Deposit History
Retrieve user's deposit transaction history.

```http
GET /financial/deposits?page=1&per_page=10&status=approved
Authorization: Bearer {token}
```

**Query Parameters:**
- `page`: Page number (default: 1)
- `per_page`: Results per page (default: 10, max: 50)
- `status`: Filter by status (pending, approved, declined)
- `date_from`: Start date (YYYY-MM-DD)
- `date_to`: End date (YYYY-MM-DD)

**Response (200 OK):**
```json
{
  "success": true,
  "data": {
    "current_page": 1,
    "per_page": 10,
    "total": 25,
    "last_page": 3,
    "data": [
      {
        "id": 789,
        "amount": "500.00",
        "currency": "USD",
        "payment_mode": "crypto",
        "status": "approved",
        "txn_id": "BTC_123456789",
        "created_at": "2025-10-30T15:20:00.000Z",
        "approved_at": "2025-10-30T16:45:00.000Z"
      }
    ]
  }
}
```

### Create Deposit Request
Create a new deposit request.

```http
POST /financial/deposits
Authorization: Bearer {token}
```

**Request Body:**
```json
{
  "amount": 500.00,
  "payment_mode": "crypto", // crypto, bank, card
  "currency": "USD",
  "crypto_type": "BTC", // Required if payment_mode is crypto
  "screenshot": "base64_image_data" // Payment proof (optional)
}
```

**Response (201 Created):**
```json
{
  "success": true,
  "message": "Deposit request created successfully",
  "data": {
    "id": 790,
    "amount": "500.00",
    "payment_mode": "crypto",
    "status": "pending",
    "payment_details": {
      "wallet_address": "bc1qxy2kgdygjrsqtzq2n0yrf2493p83kkfjhx0wlh",
      "qr_code": "data:image/png;base64,iVBOR...",
      "network": "Bitcoin",
      "minimum_confirmations": 3
    },
    "expires_at": "2025-11-01T14:27:10.000Z",
    "created_at": "2025-10-31T14:27:10.000Z"
  }
}
```

### Get Deposit Details
Retrieve specific deposit information.

```http
GET /financial/deposits/{id}
Authorization: Bearer {token}
```

**Response (200 OK):**
```json
{
  "success": true,
  "data": {
    "id": 789,
    "amount": "500.00",
    "currency": "USD",
    "payment_mode": "crypto",
    "status": "approved",
    "txn_id": "BTC_123456789",
    "payment_details": {
      "wallet_address": "bc1qxy2kgdygjrsqtzq2n0yrf2493p83kkfjhx0wlh",
      "confirmations": 6,
      "network_fee": "0.0001 BTC"
    },
    "processing_time": "45 minutes",
    "created_at": "2025-10-30T15:20:00.000Z",
    "approved_at": "2025-10-30T16:45:00.000Z"
  }
}
```

### Create Withdrawal Request
Request a withdrawal from user's account.

```http
POST /financial/withdrawals
Authorization: Bearer {token}
```

**Request Body:**
```json
{
  "amount": 300.00,
  "payment_mode": "crypto", // crypto, bank
  "currency": "USD",
  "wallet_address": "bc1qxy2kgdygjrsqtzq2n0yrf2493p83kkfjhx0wlh", // Required for crypto
  "bank_details": { // Required for bank
    "account_number": "123456789",
    "bank_name": "Example Bank",
    "swift_code": "EXMBUS33"
  }
}
```

**Response (201 Created):**
```json
{
  "success": true,
  "message": "Withdrawal request submitted successfully",
  "data": {
    "id": 456,
    "amount": "300.00",
    "charges": "15.00",
    "to_deduct": "315.00",
    "net_amount": "285.00",
    "payment_mode": "crypto",
    "status": "pending",
    "processing_time": "24-48 hours",
    "created_at": "2025-10-31T14:27:10.000Z"
  }
}
```

### Get Withdrawal History
Retrieve user's withdrawal transaction history.

```http
GET /financial/withdrawals?page=1&per_page=10
Authorization: Bearer {token}
```

**Response (200 OK):**
```json
{
  "success": true,
  "data": {
    "current_page": 1,
    "per_page": 10,
    "total": 8,
    "data": [
      {
        "id": 456,
        "amount": "300.00",
        "charges": "15.00",
        "net_amount": "285.00",
        "payment_mode": "crypto",
        "status": "approved",
        "wallet_address": "bc1qxy2kgdygjrsqtzq2n0yrf2493p83kkfjhx0wlh",
        "created_at": "2025-10-31T14:27:10.000Z",
        "processed_at": "2025-11-01T10:15:00.000Z"
      }
    ]
  }
}
```

## Investment Plans API

### Get Available Plans
Retrieve all available investment plans.

```http
GET /plans?category_id=1&active=true
Authorization: Bearer {token}
```

**Query Parameters:**
- `category_id`: Filter by plan category
- `active`: Filter active plans only
- `min_amount`: Filter by minimum investment amount
- `max_amount`: Filter by maximum investment amount

**Response (200 OK):**
```json
{
  "success": true,
  "data": [
    {
      "id": 101,
      "name": "Starter Plan",
      "description": "Perfect for beginners in crypto investment",
      "min_price": "100.00",
      "max_price": "999.00",
      "minr": "5.00", // Minimum return %
      "maxr": "8.00", // Maximum return %
      "duration": 30, // Days
      "increment_type": "percentage",
      "gift": "10.00", // Sign-up bonus
      "active": true,
      "category": {
        "id": 1,
        "name": "Crypto Trading",
        "description": "Cryptocurrency investment plans"
      },
      "features": [
        "Daily returns",
        "24/7 support",
        "Risk management"
      ],
      "roi_schedule": "daily",
      "risk_level": "low"
    }
  ]
}
```

### Get Plan Details
Get detailed information about a specific plan.

```http
GET /plans/{id}
Authorization: Bearer {token}
```

**Response (200 OK):**
```json
{
  "success": true,
  "data": {
    "id": 101,
    "name": "Starter Plan",
    "description": "Perfect for beginners in crypto investment",
    "min_price": "100.00",
    "max_price": "999.00",
    "minr": "5.00",
    "maxr": "8.00",
    "duration": 30,
    "total_investors": 245,
    "total_invested": "125000.00",
    "success_rate": "94.5",
    "terms_conditions": "Investment terms and conditions...",
    "risk_disclosure": "Risk disclosure statement...",
    "historical_performance": [
      {
        "month": "2025-10",
        "average_return": "6.2",
        "total_payouts": "15000.00"
      }
    ]
  }
}
```

### Invest in Plan
Make an investment in a specific plan.

```http
POST /plans/{id}/invest
Authorization: Bearer {token}
```

**Request Body:**
```json
{
  "amount": 500.00,
  "currency": "USD",
  "terms_accepted": true,
  "risk_acknowledged": true
}
```

**Response (201 Created):**
```json
{
  "success": true,
  "message": "Investment successful",
  "data": {
    "investment_id": 567,
    "plan_id": 101,
    "amount": "500.00",
    "expected_return": "540.00",
    "duration": 30,
    "daily_return": "1.33",
    "status": "active",
    "activated_at": "2025-10-31T14:27:10.000Z",
    "expires_at": "2025-11-30T14:27:10.000Z",
    "next_payout": "2025-11-01T14:27:10.000Z"
  }
}
```

### Get User Investments
Retrieve user's active and completed investments.

```http
GET /my-investments?status=active&page=1
Authorization: Bearer {token}
```

**Query Parameters:**
- `status`: Filter by status (active, completed, cancelled)
- `plan_id`: Filter by specific plan
- `page`: Page number

**Response (200 OK):**
```json
{
  "success": true,
  "data": {
    "summary": {
      "total_invested": "2000.00",
      "total_earned": "150.00",
      "active_investments": 3,
      "completed_investments": 2
    },
    "investments": [
      {
        "id": 567,
        "plan": {
          "id": 101,
          "name": "Starter Plan"
        },
        "amount": "500.00",
        "expected_return": "540.00",
        "profit_earned": "35.00",
        "status": "active",
        "progress_percentage": 23.33,
        "days_remaining": 23,
        "next_payout": "2025-11-01T14:27:10.000Z",
        "created_at": "2025-10-31T14:27:10.000Z"
      }
    ]
  }
}
```

## Notification API

### Get Notifications
Retrieve user notifications.

```http
GET /notifications?page=1&type=info&read=false
Authorization: Bearer {token}
```

**Query Parameters:**
- `type`: Filter by type (info, success, warning, error)
- `read`: Filter by read status (true, false)
- `page`: Page number

**Response (200 OK):**
```json
{
  "success": true,
  "data": {
    "current_page": 1,
    "total": 15,
    "unread_count": 3,
    "data": [
      {
        "id": 678,
        "title": "Deposit Approved",
        "message": "Your deposit of $500.00 has been approved and added to your account.",
        "type": "success",
        "read": false,
        "source_type": "deposit",
        "source_id": 789,
        "action_url": "/deposits/789",
        "created_at": "2025-10-31T14:27:10.000Z"
      }
    ]
  }
}
```

### Get Notification Count
Get count of unread notifications.

```http
GET /notifications/count
Authorization: Bearer {token}
```

**Response (200 OK):**
```json
{
  "success": true,
  "data": {
    "unread_count": 3,
    "total_count": 15,
    "by_type": {
      "info": 5,
      "success": 8,
      "warning": 1,
      "error": 1
    }
  }
}
```

### Mark Notification as Read
Mark a specific notification as read.

```http
POST /notifications/{id}/read
Authorization: Bearer {token}
```

**Response (200 OK):**
```json
{
  "success": true,
  "message": "Notification marked as read",
  "data": {
    "read_at": "2025-10-31T14:27:10.000Z"
  }
}
```

## Admin Management API

### Get Dashboard Statistics
Get admin dashboard statistics (Admin only).

```http
GET /admin/dashboard/stats
Authorization: Bearer {admin_token}
```

**Response (200 OK):**
```json
{
  "success": true,
  "data": {
    "users": {
      "total": 1250,
      "new_today": 15,
      "new_this_week": 85,
      "verified": 980,
      "pending_kyc": 45
    },
    "financial": {
      "total_deposits": "125000.00",
      "total_withdrawals": "45000.00",
      "pending_deposits": "5000.00",
      "pending_withdrawals": "2000.00",
      "deposits_today": "2500.00"
    },
    "investments": {
      "active_plans": 345,
      "total_invested": "85000.00",
      "payouts_today": "1200.00"
    },
    "leads": {
      "total_leads": 850,
      "hot_leads": 45,
      "assigned_today": 25,
      "conversion_rate": "15.5"
    }
  }
}
```

### Assign Lead to Admin
Assign a lead to specific admin (Admin only).

```http
POST /admin/users/{user_id}/assign-lead
Authorization: Bearer {admin_token}
```

**Request Body:**
```json
{
  "admin_id": 5,
  "assignment_reason": "High priority lead - qualified prospect",
  "priority": "high",
  "follow_up_date": "2025-11-01"
}
```

**Response (200 OK):**
```json
{
  "success": true,
  "message": "Lead assigned successfully",
  "data": {
    "assignment_id": 123,
    "user_id": 789,
    "admin_id": 5,
    "assigned_by": 1,
    "assignment_reason": "High priority lead - qualified prospect",
    "assigned_at": "2025-10-31T14:27:10.000Z"
  }
}
```

## Lead Management API

### Get Leads List
Get paginated leads list with filtering (Admin only).

```http
GET /admin/leads?status=new&assigned_to=5&page=1&search=john
Authorization: Bearer {admin_token}
```

**Query Parameters:**
- `status`: Lead status filter
- `assigned_to`: Filter by assigned admin ID
- `priority`: Priority filter (low, medium, high)
- `lead_score_min`: Minimum lead score
- `search`: Search in name, email, phone
- `date_from`: Created date filter start
- `date_to`: Created date filter end

**Response (200 OK):**
```json
{
  "success": true,
  "data": {
    "current_page": 1,
    "per_page": 20,
    "total": 156,
    "data": [
      {
        "id": 789,
        "name": "John Doe",
        "email": "john@example.com",
        "phone": "+1234567890",
        "lead_status": "contacted",
        "lead_score": 75,
        "lead_priority": "medium",
        "assigned_to": {
          "id": 5,
          "name": "Sarah Admin"
        },
        "lead_source": "website",
        "company_name": "Tech Corp",
        "last_contact_date": "2025-10-30T10:15:00.000Z",
        "next_follow_up_date": "2025-11-01T14:00:00.000Z",
        "created_at": "2025-10-25T12:30:00.000Z"
      }
    ],
    "summary": {
      "new_leads": 45,
      "contacted": 67,
      "qualified": 32,
      "converted": 12
    }
  }
}
```

### Update Lead Information
Update lead information and status (Admin only).

```http
PATCH /admin/leads/{id}
Authorization: Bearer {admin_token}
```

**Request Body:**
```json
{
  "lead_status": "qualified",
  "lead_priority": "high",
  "lead_score": 85,
  "next_follow_up_date": "2025-11-02T14:00:00",
  "notes": "Very interested in premium plans. Follow up with proposal.",
  "company_size": "51-200",
  "industry": "Finance"
}
```

**Response (200 OK):**
```json
{
  "success": true,
  "message": "Lead updated successfully",
  "data": {
    "id": 789,
    "lead_status": "qualified",
    "lead_priority": "high",
    "lead_score": 85,
    "score_change": "+10",
    "updated_at": "2025-10-31T14:27:10.000Z"
  }
}
```

## Error Handling

### Standard Error Response Format

```json
{
  "success": false,
  "message": "Error description",
  "errors": {
    "field_name": ["Validation error message"]
  },
  "error_code": "VALIDATION_FAILED",
  "timestamp": "2025-10-31T14:27:10.000Z"
}
```

### HTTP Status Codes
- **200**: Success
- **201**: Created
- **400**: Bad Request
- **401**: Unauthorized (Invalid/missing token)
- **403**: Forbidden (Insufficient permissions)
- **404**: Not Found
- **422**: Validation Error
- **429**: Too Many Requests (Rate limited)
- **500**: Internal Server Error

### Common Error Codes
- `AUTHENTICATION_FAILED`: Invalid login credentials
- `TOKEN_EXPIRED`: Access token has expired
- `INSUFFICIENT_BALANCE`: Not enough account balance
- `KYC_REQUIRED`: KYC verification required
- `VALIDATION_FAILED`: Request validation errors
- `RATE_LIMIT_EXCEEDED`: Too many requests
- `RESOURCE_NOT_FOUND`: Requested resource not found
- `PERMISSION_DENIED`: Insufficient permissions

### Error Examples

**401 Unauthorized:**
```json
{
  "success": false,
  "message": "Unauthenticated",
  "error_code": "AUTHENTICATION_REQUIRED",
  "timestamp": "2025-10-31T14:27:10.000Z"
}
```

**422 Validation Error:**
```json
{
  "success": false,
  "message": "The given data was invalid",
  "errors": {
    "amount": ["The amount must be at least 10."],
    "payment_mode": ["The payment mode field is required."]
  },
  "error_code": "VALIDATION_FAILED",
  "timestamp": "2025-10-31T14:27:10.000Z"
}
```

**403 KYC Required:**
```json
{
  "success": false,
  "message": "KYC verification required for this operation",
  "error_code": "KYC_REQUIRED",
  "data": {
    "kyc_status": "pending",
    "required_documents": ["identity", "address_proof"]
  },
  "timestamp": "2025-10-31T14:27:10.000Z"
}
```

## Rate Limiting

### Rate Limit Headers
```http
X-RateLimit-Limit: 120
X-RateLimit-Remaining: 119
X-RateLimit-Reset: 1698768000
```

### Rate Limits by Endpoint Category
- **Authentication**: 60 requests/minute
- **User Operations**: 120 requests/minute  
- **Financial Operations**: 60 requests/minute
- **Admin Operations**: 180 requests/minute

### Rate Limit Exceeded Response
```json
{
  "success": false,
  "message": "Too many requests",
  "error_code": "RATE_LIMIT_EXCEEDED",
  "retry_after": 60,
  "timestamp": "2025-10-31T14:27:10.000Z"
}
```

---

**Son Güncelleme**: 31 Ekim 2025  
**API Versiyon**: v1.0  
**Postman Collection**: [Download](./postman/monexa-api.postman_collection.json)