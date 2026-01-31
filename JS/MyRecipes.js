document.addEventListener('DOMContentLoaded', function() {
    initializeDeleteConfirmation();
    animateStatsOnScroll();
    highlightCurrentPage();
    addTableInteractivity();
});

function initializeDeleteConfirmation() {
    const deleteButtons = document.querySelectorAll('.btn-delete');
    
    deleteButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            
            const confirmed = confirm('Are you sure you want to delete this recipe? This action cannot be undone.');
            
            if (confirmed) {
                const row = this.closest('tr');
                row.style.transition = 'all 0.5s ease';
                row.style.opacity = '0';
                row.style.transform = 'translateX(100px)';
                
                setTimeout(() => {
                    row.remove();
                    updateStats();
                    showNotification('Recipe deleted successfully', 'success');
                }, 500);
            }
        });
    });
}

function animateStatsOnScroll() {
    const statNumbers = document.querySelectorAll('.stat-number');
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                animateNumber(entry.target);
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.5 });
    
    statNumbers.forEach(stat => observer.observe(stat));
}

function animateNumber(element) {
    const finalNumber = parseInt(element.textContent.replace(/,/g, ''));
    const duration = 2000;
    const steps = 60;
    const increment = finalNumber / steps;
    let current = 0;
    
    const timer = setInterval(() => {
        current += increment;
        if (current >= finalNumber) {
            element.textContent = finalNumber.toLocaleString('ar-SA');
            clearInterval(timer);
        } else {
            element.textContent = Math.floor(current).toLocaleString('ar-SA');
        }
    }, duration / steps);
}

function highlightCurrentPage() {
    const currentPath = window.location.pathname;
    const navLinks = document.querySelectorAll('.nav-link');
    
    navLinks.forEach(link => {
        if (link.getAttribute('href') && currentPath.includes(link.getAttribute('href'))) {
            link.classList.add('active');
        }
    });
}

function addTableInteractivity() {
    const tableRows = document.querySelectorAll('.recipes-table tbody tr');
    
    tableRows.forEach((row, index) => {
        row.style.animationDelay = `${index * 0.1}s`;
        
        row.addEventListener('mouseenter', function() {
            this.style.boxShadow = '0 4px 12px rgba(198, 113, 84, 0.2)';
        });
        
        row.addEventListener('mouseleave', function() {
            this.style.boxShadow = 'none';
        });
    });
}

function updateStats() {
    const totalRecipes = document.querySelectorAll('.recipes-table tbody tr').length;
    const statCards = document.querySelectorAll('.stat-card');
    
    if (statCards[0]) {
        const recipesNumber = statCards[0].querySelector('.stat-number');
        recipesNumber.textContent = totalRecipes;
    }
    
    let totalLikes = 0;
    document.querySelectorAll('.likes-count').forEach(cell => {
        const likes = parseInt(cell.textContent.replace(/[^0-9]/g, ''));
        totalLikes += likes;
    });
    
    if (statCards[1]) {
        const likesNumber = statCards[1].querySelector('.stat-number');
        likesNumber.textContent = totalLikes.toLocaleString('ar-SA');
    }
}

function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.className = `notification notification-${type}`;
    notification.textContent = message;
    
    notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        padding: 1rem 2rem;
        background: ${type === 'success' ? '#618C72' : '#C67154'};
        color: white;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        z-index: 1000;
        animation: slideIn 0.5s ease;
        font-weight: 600;
    `;
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.style.animation = 'slideOut 0.5s ease';
        setTimeout(() => notification.remove(), 500);
    }, 3000);
}

const style = document.createElement('style');
style.textContent = `
    @keyframes slideIn {
        from {
            transform: translateX(400px);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
    
    @keyframes slideOut {
        from {
            transform: translateX(0);
            opacity: 1;
        }
        to {
            transform: translateX(400px);
            opacity: 0;
        }
    }
`;
document.head.appendChild(style);

window.addEventListener('load', function() {
    document.body.style.opacity = '0';
    document.body.style.transition = 'opacity 0.5s ease';
    setTimeout(() => {
        document.body.style.opacity = '1';
    }, 100);
});
