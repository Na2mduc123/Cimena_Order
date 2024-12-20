// Script điều khiển các phần tử hiện thị trên cùng 1 page và cùng 1 chỗ khi ấn vào link tương ứng

const links = document.querySelectorAll('#links a');
    const items = document.querySelectorAll('.content');

    // Thêm sự kiện click cho từng liên kết
    links.forEach(link => {
      link.addEventListener('click', () => {
        const targetId = link.getAttribute('data-target');

        // Ẩn tất cả các phần tử
        items.forEach(item => item.classList.remove('active'));

        // Hiển thị phần tử tương ứng
        document.getElementById(targetId).classList.add('active');
      });
    });


// Lấy tất cả các nút
const buttons = document.querySelectorAll('#links a');

// Thêm sự kiện click cho từng nút
buttons.forEach(button => {
    button.addEventListener('click', () => {
        // Xóa lớp 'active' khỏi tất cả các nút
        buttons.forEach(btn => btn.classList.remove('active'));

        // Thêm lớp 'active' vào nút được click
        button.classList.add('active');
    });
});