<!-- Touch-friendly CSS for tablets -->
<style>
/* Touch-friendly buttons */
.btn {
    min-height: 44px;
    min-width: 44px;
    padding: 12px 20px;
    font-size: 16px;
}

.btn-sm {
    min-height: 38px;
    padding: 8px 16px;
    font-size: 14px;
}

/* Larger touch targets for mobile */
@media (max-width: 768px) {
    .btn {
        min-height: 48px;
        padding: 14px 24px;
        font-size: 18px;
    }
    
    .form-control {
        min-height: 48px;
        font-size: 16px;
        padding: 12px 16px;
    }
    
    .form-select {
        min-height: 48px;
        font-size: 16px;
        padding: 12px 16px;
    }
    
    /* Card touch areas */
    .card {
        margin-bottom: 20px;
    }
    
    .card-body {
        padding: 20px;
    }
    
    /* Navigation touch targets */
    .nav-link {
        padding: 15px 20px;
        font-size: 16px;
    }
    
    /* Table touch optimization */
    .table td, .table th {
        padding: 15px 10px;
        font-size: 14px;
    }
}

/* Tablet specific optimizations */
@media (min-width: 768px) and (max-width: 1024px) {
    .container {
        padding: 0 20px;
    }
    
    .btn {
        min-height: 50px;
        font-size: 16px;
    }
    
    .card {
        margin-bottom: 25px;
    }
    
    /* Menu grid for tablets */
    .menu-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 20px;
    }
}

/* Prevent zoom on input focus (iOS) */
input[type="text"],
input[type="email"],
input[type="tel"],
input[type="number"],
textarea,
select {
    font-size: 16px !important;
}

/* Touch feedback */
.btn:active,
.card:active,
.nav-link:active {
    transform: scale(0.98);
    transition: transform 0.1s ease;
}

/* Swipe indicators */
.swipeable {
    position: relative;
}

.swipeable::after {
    content: "← Swipe →";
    position: absolute;
    bottom: 10px;
    right: 10px;
    font-size: 12px;
    color: #6c757d;
    opacity: 0.7;
}

/* Loading states for touch */
.btn.loading {
    pointer-events: none;
    opacity: 0.7;
}

.btn.loading::after {
    content: "";
    display: inline-block;
    width: 16px;
    height: 16px;
    margin-left: 8px;
    border: 2px solid transparent;
    border-top: 2px solid currentColor;
    border-radius: 50%;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}
</style>