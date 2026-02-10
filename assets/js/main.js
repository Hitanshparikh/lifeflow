// LifeFlow Custom JavaScript

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Lucide icons
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }
    
    // Initialize tooltips
    initTooltips();
    
    // Initialize smooth scroll
    initSmoothScroll();
    
    // Initialize form validation
    initFormValidation();
    
    // Check for geolocation support
    checkGeolocation();
});

// Tooltip Initialization
function initTooltips() {
    const tooltipElements = document.querySelectorAll('[data-tooltip]');
    
    tooltipElements.forEach(element => {
        element.addEventListener('mouseenter', function() {
            const tooltipText = this.getAttribute('data-tooltip');
            const tooltip = createTooltip(tooltipText);
            document.body.appendChild(tooltip);
            positionTooltip(this, tooltip);
        });
        
        element.addEventListener('mouseleave', function() {
            const tooltip = document.querySelector('.custom-tooltip');
            if (tooltip) {
                tooltip.remove();
            }
        });
    });
}

function createTooltip(text) {
    const tooltip = document.createElement('div');
    tooltip.className = 'custom-tooltip fixed bg-gray-900 text-white px-3 py-2 rounded-lg text-sm z-50';
    tooltip.textContent = text;
    return tooltip;
}

function positionTooltip(element, tooltip) {
    const rect = element.getBoundingClientRect();
    tooltip.style.top = `${rect.top - tooltip.offsetHeight - 8}px`;
    tooltip.style.left = `${rect.left + (rect.width / 2) - (tooltip.offsetWidth / 2)}px`;
}

// Smooth Scroll Enhancement
function initSmoothScroll() {
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            const href = this.getAttribute('href');
            if (href === '#') return;
            
            e.preventDefault();
            const target = document.querySelector(href);
            
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
}

// Form Validation Enhancement
function initFormValidation() {
    const forms = document.querySelectorAll('form[data-validate]');
    
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            if (!validateForm(this)) {
                e.preventDefault();
            }
        });
        
        // Real-time validation
        const inputs = form.querySelectorAll('input, select, textarea');
        inputs.forEach(input => {
            input.addEventListener('blur', function() {
                validateField(this);
            });
        });
    });
}

function validateForm(form) {
    let isValid = true;
    const inputs = form.querySelectorAll('input[required], select[required], textarea[required]');
    
    inputs.forEach(input => {
        if (!validateField(input)) {
            isValid = false;
        }
    });
    
    return isValid;
}

function validateField(field) {
    const value = field.value.trim();
    let isValid = true;
    let errorMessage = '';
    
    // Required check
    if (field.hasAttribute('required') && !value) {
        isValid = false;
        errorMessage = 'This field is required';
    }
    
    // Email validation
    if (field.type === 'email' && value) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(value)) {
            isValid = false;
            errorMessage = 'Please enter a valid email address';
        }
    }
    
    // Phone validation (Indian format)
    if (field.type === 'tel' && value) {
        const phoneRegex = /^[0-9]{10}$/;
        if (!phoneRegex.test(value.replace(/\s/g, ''))) {
            isValid = false;
            errorMessage = 'Please enter a valid 10-digit phone number';
        }
    }
    
    // Show/hide error message
    showFieldError(field, isValid, errorMessage);
    
    return isValid;
}

function showFieldError(field, isValid, message) {
    // Remove existing error
    const existingError = field.parentElement.querySelector('.field-error');
    if (existingError) {
        existingError.remove();
    }
    
    if (!isValid) {
        field.classList.add('border-red-500');
        const errorDiv = document.createElement('div');
        errorDiv.className = 'field-error text-red-500 text-sm mt-1';
        errorDiv.textContent = message;
        field.parentElement.appendChild(errorDiv);
    } else {
        field.classList.remove('border-red-500');
    }
}

// Geolocation Support
function checkGeolocation() {
    if ('geolocation' in navigator) {
        console.log('Geolocation is supported');
        // Can be used for finding nearby donors
    }
}

// Get user's location (optional feature)
function getUserLocation() {
    return new Promise((resolve, reject) => {
        if ('geolocation' in navigator) {
            navigator.geolocation.getCurrentPosition(
                position => {
                    resolve({
                        latitude: position.coords.latitude,
                        longitude: position.coords.longitude
                    });
                },
                error => {
                    reject(error);
                }
            );
        } else {
            reject(new Error('Geolocation not supported'));
        }
    });
}

// Notification System
function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.className = `fixed top-24 right-4 z-50 px-6 py-4 rounded-xl shadow-2xl flex items-center space-x-3 animate-slide-in-right max-w-md ${
        type === 'success' ? 'bg-green-500' :
        type === 'error' ? 'bg-red-500' :
        type === 'warning' ? 'bg-orange-500' :
        'bg-blue-500'
    } text-white`;
    
    notification.innerHTML = `
        <i data-lucide="${
            type === 'success' ? 'check-circle' :
            type === 'error' ? 'alert-circle' :
            type === 'warning' ? 'alert-triangle' :
            'info'
        }" class="w-6 h-6"></i>
        <span class="font-medium">${message}</span>
    `;
    
    document.body.appendChild(notification);
    
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }
    
    // Auto-remove after 5 seconds
    setTimeout(() => {
        notification.style.opacity = '0';
        notification.style.transform = 'translateX(100%)';
        setTimeout(() => notification.remove(), 300);
    }, 5000);
}

// Loading Spinner
function showLoader() {
    const loader = document.createElement('div');
    loader.id = 'global-loader';
    loader.className = 'fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center';
    loader.innerHTML = '<div class="loader"></div>';
    document.body.appendChild(loader);
}

function hideLoader() {
    const loader = document.getElementById('global-loader');
    if (loader) {
        loader.remove();
    }
}

// Blood Eligibility Calculator
function calculateEligibility(lastDonationDate) {
    if (!lastDonationDate) {
        return {
            eligible: true,
            daysRemaining: 0,
            message: 'Eligible to donate'
        };
    }
    
    const lastDate = new Date(lastDonationDate);
    const today = new Date();
    const daysSince = Math.floor((today - lastDate) / (1000 * 60 * 60 * 24));
    const daysRemaining = Math.max(0, 90 - daysSince);
    
    return {
        eligible: daysSince >= 90,
        daysRemaining: daysRemaining,
        daysSince: daysSince,
        message: daysSince >= 90 ? 'Eligible to donate' : `Please wait ${daysRemaining} more days`
    };
}

// Export functions for use in other scripts
window.LifeFlow = {
    showNotification,
    showLoader,
    hideLoader,
    getUserLocation,
    calculateEligibility
};
