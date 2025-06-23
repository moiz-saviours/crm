

// Initialize page - should be called on each page's DOMContentLoaded
function initPage() {
    // Add event listeners to tour buttons
    const tourButtons = document.querySelectorAll('.start-tour-btn');
    tourButtons.forEach(button => {
        button.addEventListener('click', function() {
            const tourName = this.dataset.tour;
            startTour(tourName);
        });
    });

    // Check if we should auto-start tour for this page
    const pageTour = document.body.dataset.pageTour;
    if (pageTour && !tourState[pageTour]) {
        setTimeout(() => {
            startTour(pageTour);
        }, 1000);
    }
}

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', initPage);
