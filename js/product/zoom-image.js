const img = document.getElementById('zoomable-image');

if (img) {
    const zoomLens = document.createElement('div');
    zoomLens.className = 'zoom-lens';
    img.parentElement.appendChild(zoomLens);
    
    img.addEventListener('mousemove', function(e) {
        const rect = img.getBoundingClientRect();
        const x = e.clientX - rect.left;
        const y = e.clientY - rect.top;
        zoomLens.style.left = (x - 50) + 'px';
        zoomLens.style.top = (y - 50) + 'px';
        zoomLens.style.backgroundImage = `url(${img.src})`;
        zoomLens.style.backgroundPosition = `-${x * 2}px -${y * 2}px`;
    });
    
        img.addEventListener('mouseenter', function() {
            zoomLens.style.display = 'block';
    });
    
        img.addEventListener('mouseleave', function() {
            zoomLens.style.display = 'none';
    });
}