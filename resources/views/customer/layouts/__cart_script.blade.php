<script>
function updateCartBadge() {
    fetch('/cart/count', {
        method: 'GET',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => response.json())
    .then(data => {
        const badge = document.getElementById('cart-badge');
        if (data.count > 0) {
            badge.textContent = data.count;
            badge.style.display = 'block';
        } else {
            badge.style.display = 'none';
        }
    })
    .catch(error => console.error('Error:', error));
}

// Load cart count on page load
document.addEventListener('DOMContentLoaded', function() {
    updateCartBadge();
});
</script>