import "./bootstrap";
// import "./libs/alpine"; // TEMPORARILY DISABLED FOR VANILLA JS SOLUTION
import "./admin-management";
import axios from "axios";

// Global axios configuration for admin panel
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

// Global error handler for axios
axios.interceptors.response.use(
    response => response,
    error => {
        if (error.response?.status === 419) {
            // CSRF token mismatch
            window.location.reload();
        } else if (error.response?.status === 403) {
            // Unauthorized
            Swal.fire({
                title: 'Yetki Hatası',
                text: 'Bu işlemi gerçekleştirmek için yetkiniz bulunmamaktadır.',
                icon: 'error',
                confirmButtonColor: '#ef4444'
            });
        }
        return Promise.reject(error);
    }
);

// Global utilities
window.showToast = function(message, type = 'success') {
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    });

    Toast.fire({
        icon: type,
        title: message
    });
};

window.confirmAction = function(title, text, confirmText = 'Evet', cancelText = 'İptal') {
    return Swal.fire({
        title: title,
        text: text,
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3b82f6',
        cancelButtonColor: '#6b7280',
        confirmButtonText: confirmText,
        cancelButtonText: cancelText,
        reverseButtons: true
    });
};

