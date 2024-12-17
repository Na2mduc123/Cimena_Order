document.addEventListener('DOMContentLoaded', () => {
    // Smooth scroll to sections
    document.querySelectorAll('.sub-nav a').forEach(link => {
        link.addEventListener('click', event => {
            event.preventDefault();
            const section = document.querySelector(`[data-section="${link.textContent.trim()}"]`);
            if (section) {
                window.scrollTo({
                    top: section.offsetTop - 120, // Adjust offset for fixed header
                    behavior: 'smooth'
                });
            }
        });
    });

    // Search functionality
    const searchInput = document.querySelector('.search-bar input');
    const sections = document.querySelectorAll('.section');

    searchInput.addEventListener('input', () => {
        const query = searchInput.value.toLowerCase();

        sections.forEach(section => {
            const items = section.querySelectorAll('.item');
            let sectionHasMatch = false;

            items.forEach(item => {
                const name = item.querySelector('.info h3').textContent.toLowerCase();
                if (name.includes(query)) {
                    item.style.display = '';
                    sectionHasMatch = true;
                } else {
                    item.style.display = 'none';
                }
            });

            // Hide section if no items match
            section.style.display = sectionHasMatch ? '' : 'none';
        });
    });
});



let currentSlide = 0;
    
    function scrollEvents(direction) {
      const grid = document.querySelector('.events-grid');
      const totalSlides = document.querySelectorAll('.event-card').length;
      const visibleSlides = 3;
  
      if (direction === 'next') {
        if (currentSlide < totalSlides - visibleSlides) {
          currentSlide++;
        }
      } else if (direction === 'prev') {
        if (currentSlide > 0) {
          currentSlide--;
        }
      }
  
      const slideWidth = document.querySelector('.event-card').clientWidth + 20; // Including margin
      grid.style.transform = `translateX(-${currentSlide * slideWidth}px)`;
    }
  
    function followEvent(button) {
      button.textContent = 'Đã theo dõi';
      button.disabled = true;
  
      const followersCount = button.nextElementSibling;
      let count = parseInt(followersCount.textContent.match(/\d+/)[0]);
      count++;
      followersCount.textContent = `${count} người đã theo dõi`;
    }
        const track = document.querySelector('.carousel-track');
        const items = document.querySelectorAll('.carousel-item');
        const prevButton = document.querySelector('.carousel-btn.left');
        const nextButton = document.querySelector('.carousel-btn.right');
        const dots = document.querySelectorAll('.carousel-dot');
    
        let currentIndex = 0;
        const itemsToShow = 2;
    
        function updateCarousel() {
          const translateX = -(currentIndex * (100 / itemsToShow));
          track.style.transform = `translateX(${translateX}%)`;
          dots.forEach((dot, index) => {
            dot.classList.toggle('active', index === currentIndex);
          });
        }
    
        prevButton.addEventListener('click', () => {
          currentIndex = (currentIndex === 0) ? items.length - itemsToShow : currentIndex - 1;
          updateCarousel();
        });
    
        nextButton.addEventListener('click', () => {
          currentIndex = (currentIndex >= items.length - itemsToShow) ? 0 : currentIndex + 1;
          updateCarousel();
        });
    
        dots.forEach(dot => {
          dot.addEventListener('click', () => {
            currentIndex = parseInt(dot.getAttribute('data-index'));
            updateCarousel();
          });
        });
    
        updateCarousel();
        const eventList = document.querySelector(".event-list");
  const leftBtn = document.querySelector(".left-btn");
  const rightBtn = document.querySelector(".right-btn");
  
  let scrollPosition = 0; // Vị trí cuộn hiện tại
  const itemWidth = 320; // Chiều rộng của mỗi event-item (bao gồm cả khoảng cách)
  
  rightBtn.addEventListener("click", () => {
    const maxScroll = eventList.scrollWidth - eventList.offsetWidth;
    if (scrollPosition < maxScroll) {
      scrollPosition += itemWidth;
      eventList.style.transform = `translateX(-${scrollPosition}px)`;
    }
  });
  
  leftBtn.addEventListener("click", () => {
    if (scrollPosition > 0) {
      scrollPosition -= itemWidth;
      eventList.style.transform = `translateX(-${scrollPosition}px)`;
    }
  });


  document.getElementById('sendButton').addEventListener('click', function () {
    const emailInput = document.getElementById('email');
    const email = emailInput.value.trim();
    const status = document.getElementById('status');

    if (email === '') {
        status.textContent = "Vui lòng nhập email!";
        status.style.color = "red";
        return;
    }

    // Giả lập gửi email (bạn có thể thay bằng logic gửi email thực tế)
    if (validateEmail(email)) {
        status.textContent = `Email "${email}" đã được gửi thành công!`;
        status.style.color = "green";
        emailInput.value = ''; // Xóa nội dung sau khi gửi
    } else {
        status.textContent = "Email không hợp lệ!";
        status.style.color = "red";
    }
});

// Hàm kiểm tra định dạng email
function validateEmail(email) {
    const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return re.test(email);
}

// Hiệu ứng hiện ra mượt mà của trang
document.addEventListener("DOMContentLoaded", () => {
    // Thêm lớp 'loaded' để kích hoạt hiệu ứng fade-in
    document.body.classList.add('loaded');

    // Lắng nghe sự kiện click vào liên kết
    const links = document.querySelectorAll("a");

    links.forEach(link => {
        link.addEventListener("click", (e) => {
            e.preventDefault();
            const href = link.getAttribute("href");

            // Thêm hiệu ứng fade-out và hiển thị loader
            document.body.classList.remove("loaded");
            document.body.classList.add("fade-out", "loading");

            setTimeout(() => {
                window.location.href = href; // Chuyển sang trang mới
            }, 1000); // Trì hoãn để hiệu ứng hoàn tất
        });
    });
});