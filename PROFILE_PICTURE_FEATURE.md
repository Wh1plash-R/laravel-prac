# Profile Picture Feature

## Overview
This feature allows users to upload and manage their profile pictures in the dashboard. The profile pictures are stored as BLOB data in the database for easy access and management.

## Features
- Upload profile pictures (JPEG, PNG, JPG, GIF formats)
- Image preview before upload
- Current profile picture display
- Responsive design with fallback to initials
- Image validation (size, dimensions, format)

## Database Changes
- Added `profile_picture` column to `users` table as `longText` (BLOB equivalent)
- Migration: `2025_08_31_100907_add_profile_picture_to_users_table.php`

## Components
- `x-profile-picture-upload` - Reusable component for profile picture upload
- Features:
  - File input with custom styling
  - Image preview
  - Current image display
  - File information display

## User Model Updates
- Added `profile_picture` to fillable fields
- Added helper methods:
  - `getProfilePictureBase64()` - Returns base64 encoded image
  - `hasProfilePicture()` - Checks if user has a profile picture

## Controller Updates
- Updated `DashboardController@update` to handle file uploads
- Added validation for image files
- Stores image data as BLOB in database

## Validation Rules
- File must be an image (jpeg, png, jpg, gif)
- Maximum file size: 2MB
- Minimum dimensions: 100x100 pixels
- Maximum dimensions: 1000x1000 pixels

## Usage
1. Navigate to Dashboard
2. Go to Profile section
3. Click "Edit Profile"
4. Use the profile picture upload component
5. Select an image file
6. Preview the image
7. Submit the form to save

## Display
- Profile pictures are displayed as circular images
- Fallback to user initials if no picture is set
- Multiple display sizes (16x16, 24x24, 32x32) for different contexts
