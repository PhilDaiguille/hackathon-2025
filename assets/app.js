import './bootstrap.js';
/*
 * Welcome to your app's main JavaScript file!
 *
 * This file will be included onto the page via the importmap() Twig function,
 * which should already be in your base.html.twig.
 */
import './styles/app.css';

let currentCard = 0;
const cards = document.querySelectorAll('.offer-card');
let isAnimating = false;

function swipe(direction) {
  if (isAnimating || !cards[currentCard]) return;

  isAnimating = true;

  const current = cards[currentCard];
  const hotelId = current.dataset.hotelId;

  if (direction === 'left') {
    current.classList.add('swipe-left');
  } else {
    current.classList.add('swipe-right');

    fetch('/api/wishlist', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded',
      },
      body: `hotel_id=${hotelId}`
    })
    .then(response => response.json())
    .then(data => console.log('Wishlist:', data))
    .catch(error => console.error('Erreur wishlist:', error));
  }

  setTimeout(() => {
    current.remove();
    current.classList.add('hidden');
    current.classList.remove('swipe-left', 'swipe-right');
    currentCard++;

    if (currentCard >= cards.length) {
      currentCard = 0;
    }

    const next = cards[currentCard];
    if (next) {
      next.classList.remove('hidden');
    }

    isAnimating = false;
  }, 400);
}

function removeFromWishlist(wishlistId) {
    fetch(`/api/wishlist/${wishlistId}`, {
        method: 'DELETE',
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(r => r.json())
    .then(data => {
        alert(data.message || data.error);
        if (!data.error) {
            location.reload();
        }
    });
}
document.addEventListener('DOMContentLoaded', () => {
  const leftBtn = document.getElementById('swipe-left-btn');
  const rightBtn = document.getElementById('swipe-right-btn');

  if (leftBtn) {
    leftBtn.addEventListener('click', () => swipe('left'));
  }
  if (rightBtn) {
    rightBtn.addEventListener('click', () => swipe('right'));
  }
});
