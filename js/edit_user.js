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
























function loadAdminEvents() {
  fetch('get_all_events.php')
      .then(response => response.json())
      .then(events => {
          const adminEvents = document.getElementById('admin-events');
          adminEvents.innerHTML = '';
          events.forEach(event => {
              adminEvents.innerHTML += `
                  <li>
                      ${event.event_name} (${event.status})
                      <textarea id="comment-${event.id}" placeholder="Nhập phản hồi"></textarea>
                      <button onclick="updateEventStatus(${event.id}, 'approved')">Duyệt</button>
                      <button onclick="updateEventStatus(${event.id}, 'rejected')">Không duyệt</button>
                  </li>
              `;
          });
      });
}

function updateEventStatus(eventId, status) {
  const comment = document.getElementById(`comment-${eventId}`).value;

  fetch('update_event_status.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ event_id: eventId, status: status, admin_comment: comment })
  })
  .then(response => response.text())
  .then(data => {
      alert(data);
      loadAdminEvents();
  });
}

loadAdminEvents();
