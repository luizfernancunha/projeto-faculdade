const slides = document.getElementById('slides');
    const totalSlides = slides.children.length;
    let currentIndex = 0;
    let intervalId;

    function showSlide(index) {
      slides.style.marginLeft = `-${1300 * index}px`;
      currentIndex = index;
    }

    function nextSlide() {
      currentIndex = (currentIndex + 1) % totalSlides;
      showSlide(currentIndex);
    }

    function prevSlide() {
      currentIndex = (currentIndex - 1 + totalSlides) % totalSlides;
      showSlide(currentIndex);
    }

    function startAutoSlide() {
      intervalId = setInterval(nextSlide, 4000);
    }

    function stopAutoSlide() {
      clearInterval(intervalId);
    }

    startAutoSlide();

    document.querySelector('.slider').addEventListener('mouseenter', stopAutoSlide);
    document.querySelector('.slider').addEventListener('mouseleave', startAutoSlide);
 