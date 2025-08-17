document.addEventListener('DOMContentLoaded', function() {
    setTimeout(() => {
        hideSuccessAlert()
    }, 5000);

    document.getElementById('btn-close').addEventListener('click', function () {
        hideSuccessAlert();
    });

    function hideSuccessAlert() {
        document.getElementById('success-message').style.display = 'none';
    }
});
