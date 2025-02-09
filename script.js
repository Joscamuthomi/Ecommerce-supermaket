function toggleNav() {
    const navbar = document.getElementById("navbarNav");
    navbar.classList.toggle("show");
}
document.addEventListener("DOMContentLoaded", function () {
    const slider = document.querySelector(".slider");
    const slides = document.querySelectorAll(".slide");
    const dots = document.querySelectorAll(".dot");
    let currentIndex = 0;
    const totalSlides = slides.length;
  
    // Clone the first slide and append it to the end
    const firstClone = slides[0].cloneNode(true);
    slider.appendChild(firstClone);
  
    function moveToSlide(index) {
      slider.style.transition = "transform 1s ease";
      slider.style.transform = `translateX(-${index * 100}%)`;
      currentIndex = index;
  
      // Reset to first slide instantly after reaching the cloned slide
      if (index === totalSlides) {
        setTimeout(() => {
          slider.style.transition = "none";
          slider.style.transform = `translateX(0%)`;
          currentIndex = 0;
        }, 1000); // Wait for transition to complete
      }
  
      updateDots();
    }
  
    function updateDots() {
      dots.forEach((dot, i) => {
        dot.classList.toggle("active", i === currentIndex);
      });
    }
  
    function nextSlide() {
      moveToSlide(currentIndex + 1);
    }
  
    dots.forEach((dot, i) => {
      dot.addEventListener("click", () => moveToSlide(i));
    });
  
    setInterval(nextSlide, 3000); // Auto-slide every 3 seconds
  });
  
  

  document.addEventListener('DOMContentLoaded', function() {
    const servicesContainer = document.querySelector('.services-container');
    const nextBtn = document.querySelector('.next-btn');
    const prevBtn = document.querySelector('.prev-btn');

    let scrollAmount = 0; // Track horizontal scroll amount

    // Scroll next service
    nextBtn.addEventListener('click', function() {
        const serviceWidth = document.querySelector('.service-item').offsetWidth + 20; // Include gap space
        scrollAmount += serviceWidth;
        servicesContainer.scrollTo({ left: scrollAmount, behavior: 'smooth' });
    });

    // Scroll previous service
    prevBtn.addEventListener('click', function() {
        const serviceWidth = document.querySelector('.service-item').offsetWidth + 20;
        scrollAmount -= serviceWidth;
        if (scrollAmount < 0) scrollAmount = 0; // Prevent scrolling beyond the first item
        servicesContainer.scrollTo({ left: scrollAmount, behavior: 'smooth' });
    });
});
