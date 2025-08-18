class SweetAlertHelper {
    static init() {
        // Initialize SweetAlert2 for Livewire
        document.addEventListener("livewire:init", function () {
            // Listen for confirm delete event
            Livewire.on("confirmDelete", (data) => {
                SweetAlertHelper.confirmDelete(data);
            });

            // Listen for show alert event
            Livewire.on("showAlert", (data) => {
                SweetAlertHelper.showAlert(data);
            });

            // Listen for form validation errors
            Livewire.on("showValidationError", (data) => {
                SweetAlertHelper.showValidationError(data);
            });
        });
    }

    static confirmDelete(data) {
        Swal.fire({
            title: data.title || "Konfirmasi Hapus",
            text: data.text || "Apakah Anda yakin ingin menghapus data ini?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: data.confirmButtonText || "Ya, Hapus!",
            cancelButtonText: data.cancelButtonText || "Batal",
            reverseButtons: true,
            focusCancel: true,
            customClass: {
                confirmButton: "btn btn-danger mx-2",
                cancelButton: "btn btn-secondary mx-2",
            },
            buttonsStyling: false,
        }).then((result) => {
            if (result.isConfirmed) {
                // User confirmed, proceed with deletion
                if (data.component) {
                    Livewire.find(data.component).call("delete", data.id);
                } else {
                    // Fallback to global Livewire instance
                    window.livewire.call("delete", data.id);
                }
            }
            // If cancelled, nothing happens (this fixes the bug)
        });
    }

    static showAlert(data) {
        const iconColors = {
            success: "#28a745",
            error: "#dc3545",
            warning: "#ffc107",
            info: "#17a2b8",
        };

        Swal.fire({
            title: data.title,
            text: data.message,

            icon: data.type || "info",
            timer: data.timer || 3000,
            timerProgressBar: true,
            showConfirmButton: data.showConfirmButton || false,
            toast: data.toast !== false,
            position: data.position || "top-end",
            iconColor: iconColors[data.type] || iconColors.info,
            customClass: {
                popup: "swal2-toast-custom",
            },
        });
    }

    static showValidationError(data) {
        Swal.fire({
            title: "Validasi Error",
            html: data.errors.map((error) => `<li>${error}</li>`).join(""),
            icon: "error",
            confirmButtonText: "OK",
            customClass: {
                confirmButton: "btn btn-primary",
            },
            buttonsStyling: false,
        });
    }

    static showSuccess(title, message, timer = 3000) {
        this.showAlert({
            title: title,
            message: message,
            type: "success",
            timer: timer,
        });
    }

    static showError(title, message) {
        this.showAlert({
            title: title,
            message: message,
            type: "error",
            toast: false,
            showConfirmButton: true,
        });
    }

    static showWarning(title, message) {
        this.showAlert({
            title: title,
            message: message,
            type: "warning",
            toast: false,
            showConfirmButton: true,
        });
    }
}

// Auto-initialize when DOM is ready
if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", SweetAlertHelper.init);
} else {
    SweetAlertHelper.init();
}

// Export for use in other scripts
window.SweetAlertHelper = SweetAlertHelper;
