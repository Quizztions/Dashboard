document.addEventListener('DOMContentLoaded', function() {
    const profileInfoForm = document.getElementById('profile-info-form');
    const changePasswordForm = document.getElementById('change-password-form');

    // Handle profile information update
    profileInfoForm.addEventListener('submit', function(event) {
        event.preventDefault();
        // Implement AJAX request to update profile information
        alert('Profile information updated successfully!');
    });

    // Handle password change
    changePasswordForm.addEventListener('submit', function(event) {
        event.preventDefault();
        const currentPassword = document.getElementById('current-password').value;
        const newPassword = document.getElementById('new-password').value;
        const confirmNewPassword = document.getElementById('confirm-new-password').value;

        if (newPassword !== confirmNewPassword) {
            alert('New passwords do not match.');
            return;
        }

        // Implement AJAX request to change password
        alert('Password changed successfully!');
    });
});
