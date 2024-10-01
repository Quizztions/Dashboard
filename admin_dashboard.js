document.addEventListener('DOMContentLoaded', function() {
    // Add event listeners to collapsible buttons
    const collapsibles = document.querySelectorAll('.collapsible');
    collapsibles.forEach(button => {
        button.addEventListener('click', function() {
            // Toggle the active class to show/hide content
            const content = document.getElementById(button.id.replace('-btn', '-section'));
            if (content) {
                // Hide other sections
                document.querySelectorAll('.module-content').forEach(section => {
                    if (section !== content) {
                        section.classList.remove('active');
                    }
                });
                // Toggle the clicked section
                content.classList.toggle('active');
            }
        });
    });

    // Additional JavaScript functionality for dynamically populated content can go here
});
