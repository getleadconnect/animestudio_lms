# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

This is a **Laravel 10** learning management system (LMS) for educational courses with an admin panel and student-facing website. The system includes course management, video content, PDF materials, test/exam functionality, and mobile API support.

**Environment:** XAMPP/LAMPP local development server
**PHP Version:** ^8.1
**Framework:** Laravel 10.10

## Development Commands

### Common Operations
```bash
# Start local development server
php artisan serve

# Clear all caches (run after config/route changes or when experiencing issues)
php artisan view:clear && php artisan cache:clear && php artisan route:clear && php artisan config:clear

# Run database migrations
php artisan migrate

# Rollback migrations
php artisan migrate:rollback

# Run tests
php artisan test

# Code formatting with Pint
./vendor/bin/pint

# Asset compilation
npm run dev      # Development with hot reload
npm run build    # Production build
```

### Database Operations
```bash
# Refresh database (drop all tables and re-migrate)
php artisan migrate:fresh

# Seed database
php artisan db:seed

# MySQL access (XAMPP/LAMPP)
# Default credentials: root user, no password
mysql -u root -p

# Start XAMPP/LAMPP services
sudo /opt/lampp/lampp start

# Stop XAMPP/LAMPP services
sudo /opt/lampp/lampp stop
```

## Architecture Overview

### Multi-Guard Authentication System

This application uses **four separate authentication guards**:

1. **`web` guard** - Default Laravel guard (not actively used)
   - Provider: `App\Models\User`
   - Session-based

2. **`admin` guard** - Admin panel authentication
   - Model: `App\Models\Admin`
   - Login route: `/login`
   - After login redirect: `/dashboard`
   - Session-based

3. **`student` guard** - Website student authentication
   - Model: `App\Models\User` (linked to `students` table via `student_id`)
   - Login route: `/student-login`
   - After login redirect: `/student-dashboard`
   - Session-based

4. **`api` guard** - Mobile app authentication
   - Uses Laravel Passport (OAuth2)
   - Provider: `App\Models\User`
   - Token-based authentication

**Important:** When implementing authentication checks, always specify the correct guard:
- Admin: `auth()->guard('admin')->check()`
- Student: `auth()->guard('student')->check()`
- API: `auth()->guard('api')->check()`

### Database Schema Relationships

**Core Entity Hierarchy:**
```
Center (Training centers)
  └─> Course (course_category_id, center_id)
       ├─> Subject (course_id)
       │    └─> Chapter (subject_id, course_id)
       │         ├─> Video (chapter_id)
       │         └─> PdfFile (chapter_id)
       └─> QuestionPaper (course_id, exam_tab_heading_id)
            └─> Question (question_paper_id)
```

**Student & Subscription Flow:**
```
Student (students table)
  └─> User (users table, student_id FK)
       └─> Subscription (user_id, course_id)
            └─> Access to course content
```

**Key Models:**
- `Course`: Has category, type, pricing (rate, discount_rate), dates
- `Subject`: Belongs to a course, has icon and description
- `Chapter`: Belongs to both subject and course
- `Video`: Course video content (linked to chapter)
- `PdfFile`: Downloadable PDF materials
- `QuestionPaper`: Exam/test papers with questions
- `TestResult`: Student test performance tracking
- `Subscription`: Student course enrollments

### Route Organization

Routes are split across **three files**:

1. **`routes/web.php`** - Main application routes
   - Public website pages (home, about, courses, course-details)
   - Admin panel routes (all prefixed with controller-specific paths)
   - Video content routes (public access)
   - Privacy/Terms/Contact pages

2. **`routes/website.php`** - Student authentication routes
   - Student login/register/logout
   - Student dashboard and profile
   - My courses and course content (auth required)
   - Test/exam access

3. **`routes/api.php`** - Mobile app API endpoints
   - Public: login, register, forgot password, OTP
   - Authenticated: course content, videos, PDFs, tests, notifications
   - All prefixed with `/api`

**Route Loading:** Both `web.php` and `website.php` use the `web` middleware group (see `RouteServiceProvider.php`)

### File Storage Architecture

The application uses a **hybrid storage approach**:

**DigitalOcean Spaces (S3-compatible):**
- Banner images
- Splash slides
- Subject icons
- Chapter icons
- Live class icons
- Recorded class videos
- Success stories
- Easy tips
- Image questions

**Local Storage (`public/uploads/`):**
- Course icons (`/uploads/course_icons/`)
- Video files (`/uploads/video_files/`)
- PDF files (`/uploads/pdf_files/`)

**Configuration:** See `config/constants.php` for all file path constants.

**Important:** When working with file uploads, check `config/constants.php` to determine if files should be stored locally or on DigitalOcean Spaces.

### Controller Organization

**Admin Controllers** (`app/Http/Controllers/Admin/`):
- Follow a consistent pattern: index, store, view_data, edit, update, destroy, activate_deactivate
- Use DataTables for listing pages (AJAX endpoint: `view_data()`)
- All admin routes require admin guard authentication

**Website Controllers** (`app/Http/Controllers/Website/`):
- `WebsiteController`: Public pages and course details
- `StudentAuthController`: Student authentication and dashboard
- `VideoContentController`: Video playback and content access

**API Controllers** (`app/Http/Controllers/Api/`):
- Return JSON responses
- Use Passport authentication
- Follow mobile app requirements

### Frontend Structure

**Admin Panel:**
- Located in: `resources/views/admin/`
- Uses Bootstrap 4 and SB Admin 2 template
- jQuery + DataTables for data grids
- Custom CSS in `public/assets/css/`

**Website (Student-facing):**
- Located in: `resources/views/website/`
- Modern design with custom CSS
- Vanilla JavaScript (no jQuery)
- AJAX for dynamic content loading
- Responsive and mobile-friendly

**Key Pages:**
- `index.blade.php`: Homepage with course carousel
- `course-details.blade.php`: Course info with subjects/chapters
- `purchase-course.blade.php`: Course purchase page
- `student/dashboard.blade.php`: Student dashboard

## Common Development Workflows

### Adding a New Admin CRUD Module

1. Create migration: `php artisan make:migration create_tablename_table`
2. Create model: `php artisan make:model ModelName`
3. Create controller: `php artisan make:controller Admin/ModelNameController`
4. Implement standard methods: index, store, view_data, edit, update, destroy, activate_deactivate
5. Add routes to `routes/web.php`
6. Create views in `resources/views/admin/modelname/`
7. Add to admin sidebar navigation

### Adding Website Features

1. Add routes to `routes/web.php` (public) or `routes/website.php` (auth required)
2. Create/update controller methods in `WebsiteController` or `StudentAuthController`
3. Create Blade views in `resources/views/website/`
4. If AJAX is needed, create JSON endpoint and JavaScript handler
5. Test with both guest and authenticated users

### Working with Course Content

**To add videos to a chapter:**
- Videos belong to: course, subject, and chapter
- Upload to local storage: `public/uploads/video_files/`
- Use `VideoController` admin panel

**To add PDF materials:**
- PDFs belong to: course, subject, and chapter
- Upload to local storage: `public/uploads/pdf_files/`
- Use `PdfController` admin panel

### Testing Workflow

**Running Tests:**
```bash
# Run all tests
php artisan test

# Run specific test file
php artisan test tests/Feature/ExampleTest.php

# Run tests with coverage
php artisan test --coverage
```

## Important Implementation Notes

### Performance Considerations

1. **Avoid PHP string processing in Blade templates** - Use CSS-based truncation instead of `Str::limit()` on large content to prevent timeout errors
2. **Use database subqueries** - Fetch related counts (video_count, pdf_count) in a single query
3. **Implement AJAX for dynamic content** - Load chapters/subjects dynamically to reduce initial page load
4. **Cache clearing** - Always clear view/cache/route/config cache after making changes to avoid stale data

### Security Best Practices

1. **Guard-specific authentication** - Always specify the correct guard in auth checks
2. **CSRF protection** - All forms must include `@csrf` token
3. **Authorization checks** - Verify user has access to requested resources
4. **File upload validation** - Validate file types and sizes
5. **SQL injection prevention** - Use Eloquent or prepared statements

### Common Gotchas

1. **Multiple authentication systems** - Remember to use the correct guard (admin/student/api)
2. **File path configuration** - Check `config/constants.php` for correct storage location
3. **Route file precedence** - Routes in `web.php` are processed before `website.php`
4. **Session-based redirects** - Use session flash data for post-login redirects (see purchase flow)
5. **XAMPP/LAMPP environment** - Default DB credentials: root user, no password

## Recent Changes

See `claude.md` in the root directory for a detailed changelog of recent development work, including:
- Homepage course carousel implementation
- Course details page redesign
- Purchase page with authentication flow
- Subject/chapter dynamic loading
- Performance optimizations

## Key Dependencies

- **Laravel Passport** (`laravel/passport`) - OAuth2 API authentication
- **Maatwebsite Excel** (`maatwebsite/excel`) - Excel export functionality
- **Yajra DataTables** (`yajra/laravel-datatables-oracle`) - Server-side DataTables
- **Flysystem AWS S3** (`league/flysystem-aws-s3-v3`) - DigitalOcean Spaces integration
- **Guzzle HTTP** (`guzzlehttp/guzzle`) - HTTP client for external APIs
- **Laravel Pint** (`laravel/pint`) - Code style fixer

## Troubleshooting

### Common Issues

**1. Maximum execution time exceeded:**
- Avoid using `Str::limit()` or `strip_tags()` on large HTML content in Blade templates
- Use CSS-based truncation (`max-height` + `overflow: hidden`) instead
- Solution documented in `claude.md` (Date: 2025-10-04, Section 3.1)

**2. Stale cache after changes:**
- Always run cache clearing commands after config/route changes:
  ```bash
  php artisan view:clear && php artisan cache:clear && php artisan route:clear && php artisan config:clear
  ```

**3. Authentication issues:**
- Ensure you're using the correct guard (`admin`, `student`, or `api`)
- Check middleware configuration in routes
- Verify session driver in `.env` file

**4. File upload issues:**
- Check `config/constants.php` for correct storage location (local vs DigitalOcean Spaces)
- Verify directory permissions for `public/uploads/`
- Ensure file validation rules match requirements

**5. Database connection errors:**
- Default XAMPP/LAMPP credentials: username=`root`, password=(empty)
- Check `.env` file database configuration
- Ensure MySQL service is running: `sudo /opt/lampp/lampp status`

---

## Development Changelog

### Date: 2025-10-08

#### **1. Homepage Enhancements**

**1.1. Introduction Section**
- **Location:** Added below hero banner section in `resources/views/website/index.blade.php`
- **Layout:** Two-column layout (6-6 grid)
  - Left: Student group image (`assets/first.jpg`)
  - Right: Introduction content with "INTRODUCTION" label, main heading, orange gradient divider, and descriptive text
- **Styling:** Professional design with proper spacing, justified text, and READ MORE button
- **Mobile Responsive:** Stacks vertically on small screens

**1.2. Student Reviews Section**
- **Data Source:** `student_reviews` table (joined with `students` table)
- **Controller:** `WebsiteController@index()` - fetches reviews with student details
- **Layout:** Dark blue gradient background section positioned above footer
- **Features:**
  - Displays 2 reviews side-by-side on desktop
  - Smooth horizontal scrolling with left/right navigation buttons
  - Each review card shows: quote icon, review text, student avatar, name, and location
  - Auto-hides scrollbar for clean appearance
  - Mobile: Shows 1 review at a time
- **Styling:** White cards with shadows, gradient avatars, orange accent for student location
- **Navigation:** Left/Right arrow buttons scroll by exactly 2 card widths with smooth animation

**1.3. CTA Section Redesign**
- **Changed from:** Full-width purple background
- **Changed to:** Centered white card with gradient background
- **Features:**
  - Light gray section background (#f8f9fa)
  - Max-width 1368px centered card
  - Gradient purple background inside card
  - White text with enhanced button styles
  - Lift animation on hover
- **Buttons:** White "Enroll Now" button and outlined "Contact Us" button

**1.4. Statistics Icons Update**
- Updated homepage stat cards in `resources/views/website/index.blade.php`:
  - Video Tutorials: Changed to `fa-video` icon
  - PDF Notes: Changed to `fa-file-pdf` icon

#### **2. Student Dashboard Enhancements**

**2.1. Online Classes Section**
- **Location:** Added below "My Courses" section in student dashboard
- **Data Source:** `live_classes` table
- **Controller Method:** `StudentAuthController@dashboard()`
- **Filtering:** Shows only classes for student's purchased courses
  - Queries subscriptions to get purchased course IDs
  - Filters live classes by `course_id IN (purchased_course_ids)`
  - Limits to 5 most recent classes
- **Features:**
  - Course name display
  - Instructor name (conducted_by)
  - Start date and time
  - "Join" button with class link (opens in new tab)
  - Custom icon or default gradient icon
- **Styling:** Card format with scrollable list, gradient icons, left border accent

**2.2. Recorded Online Classes Section**
- **Location:** Right column next to Online Classes
- **Data Source:** `recorded_live_classes` table
- **Filtering:** Shows only classes for student's purchased courses
  - Same subscription-based filtering as live classes
  - Limits to 5 most recent recordings
- **Features:**
  - Course name display
  - Instructor name (class_by)
  - Duration display
  - "Watch" button links to dedicated recorded classes page
  - Custom icon or default gradient icon
- **Styling:** Matching card format with Online Classes section

**2.3. Models Added**
- `LiveClass` - imported in StudentAuthController
- `RecordedLiveClass` - imported in StudentAuthController

#### **3. Recorded Classes Viewing Page**

**3.1. New Route**
- **Route:** `/recorded-classes/{courseId}`
- **Name:** `student.recorded-classes`
- **File:** `routes/website.php`
- **Middleware:** `auth:student`
- **Controller:** `StudentAuthController@recordedClassesPage()`

**3.2. Controller Method**
- **Method:** `recordedClassesPage($courseId)`
- **File:** `app/Http/Controllers/Website/StudentAuthController.php`
- **Functionality:**
  - Verifies student has active subscription to the course
  - Fetches course details (id, name, icon)
  - Retrieves all recorded classes for the course (ordered by created_at DESC)
  - Returns to `website.student.recorded-classes` view
  - Redirects to dashboard with error message if no access

**3.3. View Page**
- **File:** `resources/views/website/student/recorded-classes.blade.php`
- **Layout:** Two-column responsive layout (8-4 grid)

  **Left Column (Video Player):**
  - HTML5 video player with controls
  - Auto-loads first video on page load
  - 16:9 aspect ratio responsive wrapper
  - Video information card below player:
    - Title
    - Instructor name
    - Duration
    - Description (if available)

  **Right Column (Classes List):**
  - Gradient header showing total count
  - Scrollable list (max 600px height)
  - Each class item shows:
    - Title with play icon
    - Instructor name
    - Duration
  - Active state highlighting for currently playing video
  - Click to play functionality

**3.4. Features:**
- ✅ **No subject/chapter dropdowns** - Simplified interface
- ✅ **Click to play** - JavaScript function `playRecordedClass(index)`
- ✅ **Dynamic content update** - Updates video player, title, instructor, duration, description
- ✅ **Active state** - Highlights currently playing class
- ✅ **Mobile responsive** - Auto-scroll to top when video changes on mobile
- ✅ **Subscription verification** - Only accessible if student has purchased the course
- ✅ **Clean UI** - Matches existing design patterns

**3.5. JavaScript Functionality**
- Function: `playRecordedClass(index)`
- Updates video source dynamically
- Switches active class highlighting
- Updates all video metadata
- Auto-plays selected video
- Smooth user experience without page reload

**3.6. File Path Constants Used**
- `config('constants.recorded_class_video')` - For video file URLs
- `config('constants.recorded_class_icon')` - For class thumbnail icons

#### **4. Technical Implementation Notes**

**4.1. Controller Pattern**
- All functionality implemented in controller methods (not in routes)
- Proper use of Eloquent models for database queries
- JOIN queries for fetching related data (students, courses)
- Subscription-based access control

**4.2. Database Queries**
- Student reviews: JOIN `student_reviews` with `students` table
- Live/Recorded classes: JOIN with `courses` table for course names
- Subscription filtering: Uses `whereIn()` with purchased course IDs array
- Proper ordering: Most recent items first

**4.3. Security**
- All routes use appropriate authentication guards
- Subscription verification before granting access
- Session flash messages for error handling
- Try-catch blocks with logging for error tracking

**4.4. Responsive Design**
- Mobile-first approach with `@media` queries
- Flexbox and CSS Grid for layouts
- Custom scrollbar styling
- Proper breakpoints for tablets and mobile devices

**4.5. Performance Optimizations**
- Limited queries (5 items for dashboard sections)
- Efficient JOIN queries instead of N+1 queries
- CSS-based animations (no heavy JavaScript)
- Lazy loading considerations for video content

#### **5. Files Modified**

**Controllers:**
- `app/Http/Controllers/Website/WebsiteController.php`
- `app/Http/Controllers/Website/StudentAuthController.php`

**Routes:**
- `routes/website.php`

**Views:**
- `resources/views/website/index.blade.php`
- `resources/views/website/student/dashboard.blade.php`
- `resources/views/website/student/recorded-classes.blade.php` (NEW)

**Models Used:**
- `StudentReview`
- `LiveClass`
- `RecordedLiveClass`
- `Course`
- `Subscription`
- `Student`

#### **6. Database Tables Utilized**

- `student_reviews` - Student testimonials
- `students` - Student information
- `live_classes` - Scheduled online classes
- `recorded_live_classes` - Recorded video classes
- `courses` - Course details
- `subscriptions` - Student course enrollments

---

### Date: 2025-10-09

#### **1. Student Dashboard UI Improvements**

**1.1. "Get Started" Button Redesign**
- **Location:** `resources/views/website/student/dashboard.blade.php` - "My Courses" section
- **Changes:**
  - Moved "Get Started" button from footer to inline with subscription status badge
  - Button now styled as badge format (matching subscription status badge)
  - Both badges appear side-by-side on the right side
  - Removed `course-item-footer` div and CSS
- **Styling:**
  - Button: Purple gradient with `6px 12px` padding, `0.8rem` font-size
  - Responsive: Wraps to next line on smaller screens with `flex-wrap: wrap`
  - Hover effects: Lift animation with shadow
  - Icon: Arrow right icon with proper spacing

**1.2. My Courses Scrollbar Removal**
- **Location:** `resources/views/website/student/dashboard.blade.php`
- **Changes:**
  - Removed `max-height: 450px` from `.courses-scroll-container`
  - Removed `overflow-y: auto` to eliminate vertical scrolling
  - Removed custom scrollbar styling (webkit-scrollbar CSS)
  - Now displays all enrolled courses in grid without height restriction
- **Result:** All courses visible at once, no scrolling needed

**1.3. Info Cards Reorganization**
- **Location:** `resources/views/website/student/dashboard.blade.php` - Top info cards row
- **Changes:**
  - Reordered info cards: Courses → Mock Tests → Test Results → My Profile
  - Changed "My Courses" card to "Courses" with route to public `/courses` page
  - Updated counts: "Available" instead of "Enrolled" for consistency

#### **2. Student Profile Page Implementation**

**2.1. Profile View Page Created**
- **File:** `resources/views/website/student/profile.blade.php` (NEW)
- **Route:** GET `/student-profile` → `student.profile`
- **Layout:** Two-column responsive layout

  **Left Column - Personal Information Form:**
  - Full Name (required, max 100 chars)
  - Email Address (required, unique validation)
  - Mobile Number (required, 10 digits, unique validation)
  - Date of Birth (optional)
  - Place (optional, max 50 chars)
  - Update Profile button

  **Right Column:**
  - **Change Password Section:**
    - New Password field (min 6 chars)
    - Confirm Password field (must match)
    - Password visibility toggle (eye icon)
    - Update Password button
    - Info alert: "Leave empty if you don't want to change password"
  - **Account Information Display:**
    - Student ID
    - Account Status badge (Active/Inactive)
    - Member Since date

**2.2. Controller Methods**
- **File:** `app/Http/Controllers/Website/StudentAuthController.php`
- **Methods:**
  - `profile()` (lines 198-202) - Displays profile page with student data
  - `updateProfile()` (lines 205-248) - Updates profile and password
- **Validation:**
  - Name, email, mobile with unique checks
  - Password optional, confirmed if provided
  - Updates both `users` and `students` tables
  - Refreshes session data after update

**2.3. Routes**
- **File:** `routes/website.php:45-46`
- GET `/student-profile` - View profile
- POST `/student-profile` - Update profile/password

**2.4. Features:**
- ✅ View and edit all profile fields
- ✅ Change password with confirmation
- ✅ Password visibility toggle
- ✅ Form validation (client and server-side)
- ✅ Success/error messages with auto-dismiss
- ✅ Mobile number auto-format (digits only, max 10)
- ✅ Purple gradient theme matching site design
- ✅ Fully responsive mobile layout

#### **3. Video Completion Tracking**

**3.1. Database Table**
- **Table:** `video_completed_status` (already existed)
- **Fields:** `id`, `course_id`, `subject_id`, `student_id`, `video_id`, `completed_status`, `created_at`, `updated_at`
- **Note:** `chapter_id` column exists but is NOT used (per requirement)

**3.2. Model**
- **File:** `app/Models/VideoCompletedStatus.php` (already existed)
- **Fillable:** `id`, `course_id`, `subject_id`, `chapter_id`, `student_id`, `video_id`, `completed_status`

**3.3. Mark as Completed Button**
- **Location:** `resources/views/website/student/course-content.blade.php:556-568`
- **Position:** Below video title and description, above comments section
- **UI:**
  - Green gradient button: "Mark as Completed" with check icon
  - Toggles to green badge when clicked: "Completed" with check icon
  - Button disappears after marking, shows badge instead
  - Loading spinner while processing

**3.4. Controller Methods**
- **File:** `app/Http/Controllers/Website/StudentAuthController.php:623-710`
- **Methods:**
  - `markVideoCompleted()` (lines 623-678)
    - Validates: video_id, course_id, subject_id
    - Checks for duplicates
    - Stores: student_id, video_id, course_id, subject_id, completed_status=1
    - Returns JSON with success/error message
  - `checkVideoCompleted()` (lines 680-710)
    - Checks if video already completed by student
    - Returns JSON: `{completed: true/false}`

**3.5. Routes**
- **File:** `routes/website.php:58-60`
- POST `/mark-video-completed` - Mark video as completed
- GET `/check-video-completed` - Check completion status

**3.6. JavaScript Functionality**
- **File:** `resources/views/website/student/course-content.blade.php:1428-1520`
- **Functions:**
  - `markVideoAsCompleted()` - AJAX request to mark video complete
  - `checkVideoCompleted(videoId)` - Fetches completion status
  - `updateCompletionUI(videoId)` - Updates button/badge visibility
  - Automatically checks status when video loads
  - Shows appropriate UI (button or badge) based on status

**3.7. CSS Styling**
- **File:** `resources/views/website/student/course-content.blade.php:481-535`
- Green gradient button matching site theme
- Completed badge with light green background
- Hover effects and animations
- Responsive mobile design

#### **4. Video Comments System**

**4.1. Database Table**
- **Table:** `video_comments` (already existed)
- **Fields:** `id`, `course_id`, `subject_id`, `student_id`, `video_id`, `comments`, `created_at`, `updated_at`
- **Note:** Text field for comments (max 1000 characters)

**4.2. Model**
- **File:** `app/Models/VideoComment.php` (already existed)
- **Fillable:** `id`, `course_id`, `subject_id`, `student_id`, `video_id`, `comments`

**4.3. Comments Section UI**
- **Location:** `resources/views/website/student/course-content.blade.php:626-653`
- **Position:** Below "Mark as Completed" button
- **Components:**
  - Heading: "Comments" with icon
  - Comment textarea (3 rows, placeholder text)
  - "Post Comment" button with purple gradient
  - Comments list (scrollable, max 400px height)
  - "No comments yet" placeholder

**4.4. Controller Methods**
- **File:** `app/Http/Controllers/Website/StudentAuthController.php:712-804`
- **Methods:**
  - `addVideoComment()` (lines 712-762)
    - Validates: video_id, course_id, subject_id, comment (max 1000 chars)
    - Stores comment with student_id
    - Returns JSON with comment data including student name
  - `getVideoComments()` (lines 764-804)
    - Fetches all comments for a video
    - JOINs with `students` table for student names
    - Returns JSON array ordered by created_at DESC (newest first)
    - Formats timestamps: "d M Y, h:i A"

**4.5. Routes**
- **File:** `routes/website.php:62-64`
- POST `/add-video-comment` - Add new comment
- GET `/get-video-comments` - Fetch all comments for video

**4.6. JavaScript Functionality**
- **File:** `resources/views/website/student/course-content.blade.php:1522-1629`
- **Functions:**
  - `loadComments(videoId)` - Fetches and displays comments
  - `submitComment()` - Posts new comment via AJAX
  - `escapeHtml(text)` - Security helper to prevent XSS
  - Automatically loads comments when video is selected
  - Clears textarea after successful submission
  - Shows loading spinner while posting

**4.7. CSS Styling**
- **File:** `resources/views/website/student/course-content.blade.php:537-715`
- **Comment Form:**
  - Textarea with border focus effects
  - Purple gradient submit button
  - Loading state with spinner
- **Comment Items:**
  - White cards with left purple border
  - Student name with user icon
  - Timestamp with clock icon
  - Hover effects (lift and shadow)
  - Pre-wrap text formatting
- **Comments List:**
  - Custom scrollbar (purple theme)
  - Max height 400px with overflow
  - Responsive padding adjustments

**4.8. Features:**
- ✅ Post comments on any video
- ✅ View all comments in chronological order
- ✅ Student name displayed with each comment
- ✅ Timestamp for each comment
- ✅ Scrollable comments list
- ✅ Real-time submission (no page reload)
- ✅ Form validation (required field)
- ✅ XSS protection with HTML escaping
- ✅ Loading states for better UX
- ✅ Mobile responsive design

#### **5. Technical Implementation Details**

**5.1. Models Added/Updated**
- `VideoCompletedStatus` - Imported in StudentAuthController
- `VideoComment` - Imported in StudentAuthController
- Both models already existed, just integrated

**5.2. Database Integrity**
- Foreign keys: course_id, subject_id, student_id, video_id
- Cascading deletes configured in migrations
- Proper indexing on foreign key columns
- `completed_status` stored as tinyint (1 = completed)

**5.3. Security Measures**
- All routes protected with `auth:student` middleware
- CSRF token validation on POST requests
- XSS prevention with HTML escaping in comments
- Validation for all user inputs
- Duplicate prevention for video completion

**5.4. User Experience Enhancements**
- Auto-show comments section when video loads
- Smooth transitions and animations
- Loading spinners for async operations
- Success/error alerts for user feedback
- Responsive design for all screen sizes
- Keyboard-friendly form inputs

**5.5. Performance Optimizations**
- Async/await for non-blocking AJAX
- Single query with JOIN for comments + student names
- Efficient duplicate checking before insert
- Minimal DOM manipulation
- CSS transitions instead of JS animations

#### **6. Files Modified**

**Controllers:**
- `app/Http/Controllers/Website/StudentAuthController.php` (lines 20-21, 623-804)

**Routes:**
- `routes/website.php` (lines 58-64)

**Views:**
- `resources/views/website/student/dashboard.blade.php` (UI improvements, scrollbar removal)
- `resources/views/website/student/profile.blade.php` (NEW - complete profile page)
- `resources/views/website/student/course-content.blade.php` (completion button, comments section)

**Models Used:**
- `VideoCompletedStatus`
- `VideoComment`
- `Student`
- `User`

**Database Tables:**
- `video_completed_status` - Video completion tracking
- `video_comments` - Video comments storage
- `students` - Student information
- `users` - User authentication

---
