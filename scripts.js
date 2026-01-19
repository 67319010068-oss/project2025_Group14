// ฟังก์ชันค้นหาสินค้า
const searchInput = document.getElementById('search');
searchInput.addEventListener('input', function() {
    const query = searchInput.value.toLowerCase();
    const products = document.querySelectorAll('.product-card');
    products.forEach(function(product) {
        const productName = product.querySelector('h3').textContent.toLowerCase();
        if (productName.includes(query)) {
            product.style.display = 'block';
        } else {
            product.style.display = 'none';
        }
    });
});

// ฟังก์ชันกรองราคาสินค้า
const priceFilter = document.getElementById('priceFilter');
priceFilter.addEventListener('change', function() {
    const selected = priceFilter.value;
    const products = Array.from(document.querySelectorAll('.product-card'));
    
    if (selected === 'low-to-high') {
        products.sort((a, b) => {
            return parseFloat(a.querySelector('p').textContent.replace('บาท', '').trim()) - parseFloat(b.querySelector('p').textContent.replace('บาท', '').trim());
        });
    } else if (selected === 'high-to-low') {
        products.sort((a, b) => {
            return parseFloat(b.querySelector('p').textContent.replace('บาท', '').trim()) - parseFloat(a.querySelector('p').textContent.replace('บาท', '').trim());
        });
    }

    const grid = document.querySelector('.product-grid');
    products.forEach(product => {
        grid.appendChild(product);
    });
});
