document.addEventListener('DOMContentLoaded', () => {
    const sectionId = sessionStorage.getItem('scrollToSectionId');
    if (sectionId) {
        // Scrolls to the section
        const section = document.getElementById(sectionId);
        if (section) {
            section.scrollIntoView({ behavior: 'smooth' });
        }
        // Clears the ID of the sessionStorage section
        sessionStorage.removeItem('scrollToSectionId');
    }
});