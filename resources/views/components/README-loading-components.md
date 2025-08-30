# Loading Components Documentation

This document describes the loading components created for course enrollment/unenrollment processes and their usage throughout the application.

## Components Overview

### 1. Loading Overlay (`loading-overlay.blade.php`)
A full-screen loading overlay with spinner and message, perfect for form submissions and async operations.

**Features:**
- Full-screen backdrop with blur effect
- Animated gradient spinner matching project theme (#35b5ac)
- Customizable loading message
- Fade-in/fade-out transitions
- Responsive design
- Three size options for spinner

**Props:**
- `show` (required): Boolean or Alpine.js expression to control visibility
- `message` (optional): Loading message text (default: "Processing...")
- `size` (optional): Spinner size - 'small', 'default', 'large' (default: 'default')

**Usage:**
```blade
<x-loading-overlay 
    :show="$loading" 
    message="Enrolling in course..." 
    size="default" />
```

### 2. Loading Button (`loading-button.blade.php`)
A button component that automatically shows loading state when clicked.

**Features:**
- Automatic loading state management
- Spinning icon during loading
- Disabled state during processing
- Customizable loading text
- Maintains all button styling

**Props:**
- `type` (optional): Button type (default: 'submit')
- `loadingText` (optional): Text shown during loading (default: 'Processing...')
- `class` (optional): Additional CSS classes
- `disabled` (optional): Boolean to disable button

**Usage:**
```blade
<x-loading-button 
    type="submit"
    loadingText="Enrolling..."
    class="w-full bg-green-600 text-white py-2 rounded-lg">
    Enroll Now
</x-loading-button>
```

### 3. Enhanced Confirm Dialog (`confirm-dialog.blade.php`)
Updated the existing confirm dialog to include loading overlay functionality.

**New Features:**
- Automatic loading overlay after confirmation
- Customizable loading message
- Seamless integration with existing forms

**New Props:**
- `loadingMessage` (optional): Message shown in loading overlay (default: 'Processing...')

**Usage:**
```blade
<x-confirm-dialog
    title="Please confirm"
    message="Are you sure you want to enroll in this course?"
    confirmText="Enroll"
    cancelText="Cancel"
    loadingMessage="Enrolling in course..."
    :formId="'enroll-form-123'">
    <x-slot:trigger>
        <button type="button" class="btn-primary">
            Enroll Now
        </button>
    </x-slot:trigger>
</x-confirm-dialog>
```
## Design Theme Consistency

All loading components follow the project's design system:

- **Colors**: Gradient theme using #35b5ac and #2dd4aa
- **Typography**: Inter font family
- **Styling**: Tailwind CSS with rounded corners and shadows
- **Animations**: Smooth fade-in/fade-out transitions
- **Responsive**: Mobile-friendly design

## Technical Implementation

### Alpine.js Integration
- Uses Alpine.js for reactive state management
- `x-data`, `x-show`, and `x-transition` directives
- Automatic cleanup and state reset

### CSS Animations
- Custom keyframe animations for spinner and fade effects
- Hardware-accelerated transforms for smooth performance
- Consistent timing and easing functions

### Accessibility
- Proper ARIA attributes and semantic HTML
- Keyboard navigation support
- Screen reader friendly

## Future Usage

These components are modular and can be reused throughout the application:

1. **Course Management**: Creating, editing, deleting courses
2. **User Registration**: Account creation and verification
3. **Profile Updates**: Saving user profile changes
4. **File Uploads**: Document and image uploads
5. **API Calls**: Any async operations requiring user feedback

## Examples

See `loading-examples.blade.php` for comprehensive usage examples and patterns.

## Browser Support

- Modern browsers with CSS Grid and Flexbox support
- Alpine.js v3.x compatibility
- Tailwind CSS v3.x compatibility

## Performance Notes

- Components use CSS transforms for animations (GPU accelerated)
- Minimal JavaScript footprint
- Lazy loading of overlay content
- Efficient DOM updates with Alpine.js

---

For questions or improvements, refer to the project's main documentation or contact the development team.
