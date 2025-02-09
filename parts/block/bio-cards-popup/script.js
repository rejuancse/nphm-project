document.querySelectorAll('.openPopupBtn').forEach(button => {
    button.addEventListener('click', function() {
        const popupId = this.getAttribute('data-popup');
        const popupElement = document.getElementById(popupId);
        popupElement.style.display = 'flex';
    });
});
document.querySelectorAll('.popup').forEach(popup => {
    popup.addEventListener('click', function(event) {
        const popupContent = this.querySelector('.popup-content');
        if (!popupContent.contains(event.target)) {
            this.style.display = 'none';
        }
    });
});