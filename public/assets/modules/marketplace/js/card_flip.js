document.addEventListener('DOMContentLoaded', () => {
  // Handle card clicks for modal opening
  document.querySelectorAll('.card-front').forEach(cardFront => {
    cardFront.addEventListener('click', (e) => {
      // Don't trigger if clicking icons or if parent card is flipped
      if (e.target.closest('.info-icon') ||
        e.target.closest('.flip-back-icon')) {
        e.preventDefault();
        e.stopPropagation();
        return;
      }

      const card = cardFront.closest('.card-modal');
      if (!card || card.classList.contains('flipped')) {
        return;
      }

      // Get modal ID and open it
      const modalId = card.getAttribute('data-modal-target');
      if (modalId) {
        // Find the modal element using the dynamic ID
        const modalElement = document.getElementById(modalId);
        if (modalElement) {
          // Initialize and show the modal
          const modal = new bootstrap.Modal(modalElement);
          modal.show();
        }
      }
    });
  });

  // Handle modal cleanup
  document.querySelectorAll('.modal').forEach(modalElement => {
    modalElement.addEventListener('hidden.bs.modal', function () {
      const modal = bootstrap.Modal.getInstance(this);
      if (modal) {
        modal.dispose();
      }
    });
  });

  // Handle info icon clicks
  document.querySelectorAll('.info-icon').forEach(icon => {
    icon.onclick = (e) => {
      e.preventDefault();
      e.stopPropagation();
      const card = icon.closest('.card');
      card.classList.add('flipped');
      return false;
    };
  });

  // Handle flip back icon clicks
  document.querySelectorAll('.flip-back-icon').forEach(icon => {
    icon.onclick = (e) => {
      e.preventDefault();
      e.stopPropagation();
      const card = icon.closest('.card');
      card.classList.remove('flipped');
      return false;
    };
  });

  const cards = document.querySelectorAll(".card");
  const DRAG_THRESHOLD = 10;
  const PRESS_DELAY = 50;

  cards.forEach((card) => {
    let startX = 0, startY = 0;
    let isDragging = false;
    let pressTimer = null;

    // Handle card press effect
    card.addEventListener("pointerdown", (e) => {
      // Don't apply press effect if clicking icons or if card is flipped
      if (
        e.target.closest(".info-icon") ||
        e.target.closest(".flip-back-icon") ||
        card.classList.contains("flipped")
      ) {
        return;
      }

      isDragging = false;
      startX = e.clientX;
      startY = e.clientY;

      pressTimer = setTimeout(() => {
        if (!isDragging) {
          card.classList.add("pressed");
        }
      }, PRESS_DELAY);
    });

    card.addEventListener("pointermove", (e) => {
      const dx = e.clientX - startX;
      const dy = e.clientY - startY;
      if (Math.abs(dx) > DRAG_THRESHOLD || Math.abs(dy) > DRAG_THRESHOLD) {
        isDragging = true;
        clearTimeout(pressTimer);
        card.classList.remove("pressed");
      }
    });

    card.addEventListener("pointerup", () => {
      clearTimeout(pressTimer);
      card.classList.remove("pressed");
    });

    card.addEventListener("pointercancel", () => {
      clearTimeout(pressTimer);
      card.classList.remove("pressed");
    });
  });

  // Handle info icon clicks (flip card)
  document.querySelectorAll(".info-icon").forEach((icon) => {
    icon.addEventListener("click", (e) => {
      e.preventDefault();
      e.stopPropagation();
      e.stopImmediatePropagation();

      const card = icon.closest(".card");
      card.classList.add("flipped");

      // Prevent any modal from being triggered
      const modalId = card.getAttribute('data-bs-target');
      if (modalId) {
        const modal = document.querySelector(modalId);
        const bsModal = bootstrap.Modal.getInstance(modal);
        if (bsModal) {
          bsModal.hide();
        }
      }

      return false;
    }, true);
  });

  // Additional handler on the cards to prevent modal trigger when flipped
  document.querySelectorAll(".card").forEach((card) => {
    const observer = new MutationObserver((mutations) => {
      mutations.forEach((mutation) => {
        if (mutation.type === 'attributes' && mutation.attributeName === 'class') {
          if (card.classList.contains('flipped')) {
            card.setAttribute('data-bs-toggle-disabled', card.getAttribute('data-bs-toggle'));
            card.removeAttribute('data-bs-toggle');
          } else {
            const originalToggle = card.getAttribute('data-bs-toggle-disabled');
            if (originalToggle) {
              card.setAttribute('data-bs-toggle', originalToggle);
              card.removeAttribute('data-bs-toggle-disabled');
            }
          }
        }
      });
    });

    observer.observe(card, { attributes: true });
  });

  // Handle flip back icon clicks
  document.querySelectorAll(".flip-back-icon").forEach((icon) => {
    icon.addEventListener("click", (e) => {
      e.preventDefault();
      e.stopPropagation();
      const card = icon.closest(".card");
      card.classList.remove("flipped");
    });
  });

  // Prevent modal from opening when card is flipped
  cards.forEach(card => {
    card.addEventListener('click', (e) => {
      if (card.classList.contains('flipped')) {
        e.preventDefault();
        e.stopPropagation();
      }
    });
  });
});