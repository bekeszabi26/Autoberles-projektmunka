document.addEventListener("DOMContentLoaded", function() {
    const cars = document.querySelector('.cars');
    let isDown = false;
    let startX;
    let scrollLeft;
  
    cars.addEventListener('mousedown', function(e) {
      isDown = true;
      startX = e.pageX - cars.offsetLeft;
      scrollLeft = cars.scrollLeft;
    });
  
    cars.addEventListener('mouseleave', function() {
      isDown = false;
    });
  
    cars.addEventListener('mouseup', function() {
      isDown = false;
    });
  
    cars.addEventListener('mousemove', function(e) {
      if (!isDown) return;
      e.preventDefault();
      const x = e.pageX - cars.offsetLeft;
      const walk = (x - startX) * 2; // Adjust the scrolling speed if needed
      cars.scrollLeft = scrollLeft - walk;
    });
});

  document.addEventListener("DOMContentLoaded", function() {
    const btn = document.querySelector(".btn");
    const cardsSection = document.getElementById("cards");

    btn.addEventListener("click", function() {
      cardsSection.scrollIntoView({ behavior: "smooth" });
    });
  });



