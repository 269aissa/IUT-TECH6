// Fonctions utilitaires
document.addEventListener('DOMContentLoaded', function() {
    // Initialisation des tooltips
    const tooltips = document.querySelectorAll('[data-tooltip]');
    
    tooltips.forEach(tooltip => {
        tooltip.addEventListener('mouseenter', function() {
            const tooltipText = this.getAttribute('data-tooltip');
            const tooltipElement = document.createElement('div');
            tooltipElement.className = 'tooltip';
            tooltipElement.textContent = tooltipText;
            
            const rect = this.getBoundingClientRect();
            tooltipElement.style.left = rect.left + 'px';
            tooltipElement.style.top = (rect.top - 40) + 'px';
            
            document.body.appendChild(tooltipElement);
            
            this.addEventListener('mouseleave', function() {
                tooltipElement.remove();
            });
        });
    });
    
    // Gestion des messages flash
    const alerts = document.querySelectorAll('.alert');
    
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.opacity = '0';
            setTimeout(() => alert.remove(), 300);
        }, 5000);
    });
});

// Fonction pour copier le lien
function copyPageLink(pageId) {
    const url = window.location.origin + '/preview.php?id=' + pageId;
    navigator.clipboard.writeText(url).then(() => {
        alert('Lien copié dans le presse-papier!');
    }).catch(err => {
        console.error('Erreur lors de la copie: ', err);
    });
}