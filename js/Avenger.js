// Tạo thời gian chiếu ngẫu nhiên cho mỗi ngày
function generateRandomTimes() {
    const times = [];
    const hours = ["09", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19", "20", "21", "22"];
    const minutes = ["00", "30"];

    // Lấy 6 giờ chiếu ngẫu nhiên từ danh sách
    while (times.length < 6) {
        const hour = hours[Math.floor(Math.random() * hours.length)];
        const minute = minutes[Math.floor(Math.random() * minutes.length)];
        const time = `${hour}:${minute}`;
        if (!times.includes(time)) {
            times.push(time);
        }
    }
    return times;
}

// Hiển thị giờ chiếu khi nhấn vào ngày
function showSchedule(scheduleId) {
    // Ẩn tất cả các giờ chiếu trước
    var schedules = document.querySelectorAll('.schedule-times');
    schedules.forEach(function(schedule) {
        schedule.classList.remove('active');
    });
    
    // Hiển thị giờ chiếu của ngày đã chọn
    var scheduleToShow = document.getElementById(scheduleId);
    scheduleToShow.classList.add('active');

    // Tạo giờ chiếu ngẫu nhiên cho ngày
    const times = generateRandomTimes();
    const timesContainer = document.getElementById(`times-${scheduleId.charAt(scheduleId.length - 1)}`);
    timesContainer.innerHTML = ''; // Xóa nội dung cũ

    // Tạo các button giờ chiếu
    times.forEach(function(time) {
        const button = document.createElement('button');
        button.textContent = time;
        
        
    });


    // Khi chọn giờ chiếu
function handleTimeSelection(event, time) {
// Bỏ chọn các giờ chiếu khác
const buttons = document.querySelectorAll(".schedule-times.active button");
buttons.forEach((btn) => btn.classList.remove("selected-time"));

// Đánh dấu giờ chiếu được chọn
event.target.classList.add("selected-time");

// Lưu giờ chiếu vào phần hiển thị
document.getElementById("time").textContent = time;
}
times.forEach(function (time) {
const button = document.createElement("button");
button.textContent = time;

selectedShowTime = time;

// Thêm sự kiện click
button.onclick = function (event) {
handleTimeSelection(event, time); // Gọi hàm xử lý khi click
};

timesContainer.appendChild(button);
});

}
function goBack() {
window.history.back();
}

// Hiển thị ngày và giờ hiện tại
function updateDateTime() {
const now = new Date();
const options = { weekday: "long", year: "numeric", month: "long", day: "numeric" };
const date = now.toLocaleDateString("vi-VN", options);
const time = now.toLocaleTimeString("vi-VN", { hour: "2-digit", minute: "2-digit", second: "2-digit" });

document.getElementById("date").textContent = date;
document.getElementById("time").textContent = time;
}

// Cập nhật ngày giờ mỗi giây
setInterval(updateDateTime, 1000);

// Tạo các ghế
const seatsContainer = document.getElementById("seats-container");
const selectedCount = document.getElementById("selected-count");
const selectedSeats = document.getElementById("selected-seats");
const totalPrice = document.getElementById("total-price");


const TOTAL_SINGLE_ROWS = 5; // Số hàng ghế đơn
const SINGLE_SEATS_PER_ROW = 10; // Số ghế đơn mỗi hàng
const TOTAL_DOUBLE_ROWS = 2; // Số hàng ghế đôi
const DOUBLE_SEATS_PER_ROW = 5; // Số ghế đôi mỗi hàng

const TICKET_PRICE = 50000; // Giá vé thường
const DOUBLE_TICKET_PRICE = 90000; // Giá vé ghế đôi

// Tạo ghế đơn
for (let row = 1; row <= TOTAL_SINGLE_ROWS; row++) {
const singleRow = document.createElement("div");
singleRow.classList.add("row");

for (let col = 1; col <= SINGLE_SEATS_PER_ROW; col++) {
const seat = document.createElement("div");
seat.classList.add("seat");
seat.dataset.type = "regular";
seat.dataset.seatNumber = `R${row}-${col}`;
singleRow.appendChild(seat);
}

seatsContainer.appendChild(singleRow);
}

// Tạo ghế đôi
for (let row = 1; row <= TOTAL_DOUBLE_ROWS; row++) {
const doubleRow = document.createElement("div");
doubleRow.classList.add("double-row");

for (let col = 1; col <= DOUBLE_SEATS_PER_ROW; col++) {
const seat = document.createElement("div");
seat.classList.add("seat", "double-seat");
seat.dataset.type = "double";
seat.dataset.seatNumber = `D${row}-${col}`;
doubleRow.appendChild(seat);
}

seatsContainer.appendChild(doubleRow);
}

// Xử lý sự kiện click vào ghế
seatsContainer.addEventListener("click", (e) => {
if (!e.target.classList.contains("seat") || e.target.classList.contains("occupied")) {
return;
}

e.target.classList.toggle("selected");

updateSelectedSeats();
});

// Hàm cập nhật thông tin ghế đã chọn
function updateSelectedSeats() {
const selectedSeatsElements = document.querySelectorAll(".seat.selected");
const seatNumbers = [...selectedSeatsElements].map(seat => seat.dataset.seatNumber);
const total = [...selectedSeatsElements].reduce((sum, seat) => {
return sum + (seat.dataset.type === "double" ? DOUBLE_TICKET_PRICE : TICKET_PRICE);
}, 0);

selectedCount.textContent = selectedSeatsElements.length;
selectedSeats.textContent = seatNumbers.length ? seatNumbers.join(", ") : "None";
totalPrice.textContent = total.toLocaleString();
}





// Hàm xử lý đặt vé
function bookTickets() {
    const selectedSeatsElements = document.querySelectorAll(".seat.selected");
    if (selectedSeatsElements.length === 0) {
        alert("Bạn chưa chọn ghế nào!");
        return;
    }

    // Lấy thông tin ghế đã chọn
    const seatNumbers = [...selectedSeatsElements].map(seat => seat.dataset.seatNumber).join(", ");

    // Lấy thông tin ngày và giờ chiếu
    const selectedDate = document.getElementById("date").textContent || "Chưa chọn ngày";
    const selectedTimeButtons = document.querySelectorAll(".schedule-times.active button");
    let selectedTime = "Chưa chọn giờ chiếu"; // Khởi tạo giá trị mặc định

    console.log("Tìm các button giờ chiếu:", selectedTimeButtons); // Kiểm tra các button giờ chiếu
    selectedTimeButtons.forEach((button) => {
        if (button.classList.contains("selected-time")) {
            selectedTime = button.textContent;
        }
    });

    console.log("Giờ chiếu đã chọn: ", selectedTime); // Kiểm tra giá trị của selectedTime

    // Kiểm tra nếu giờ chiếu chưa được chọn
    if (selectedTime === "Chưa chọn giờ chiếu") {
        alert("Bạn chưa chọn giờ chiếu!");
        return;
    }

    // Hiển thị thông tin đặt vé
    alert(`Thông tin đặt vé:\n- Ngày: ${selectedDate}\n- Giờ: ${selectedTime}\n- Ghế: ${seatNumbers}\n- Tổng tiền: ${totalPrice.textContent} VNĐ`);
}


let currentIndex = 0;

function moveSlide(direction) {
    const slides = document.querySelectorAll('.slide');
    const totalSlides = slides.length;
    const slidesToShow = 4; // Số lượng slide hiển thị một lần
    const slideWidth = slides[0].offsetWidth + 10; // Chiều rộng mỗi hình ảnh cộng với khoảng cách 10px

    currentIndex += direction;

    // Xử lý vòng lặp của slide
    if (currentIndex >= totalSlides - slidesToShow + 1) {
        currentIndex = 0;
    } else if (currentIndex < 0) {
        currentIndex = totalSlides - slidesToShow;
    }

    const slider = document.querySelector('.slider');
    slider.style.transform = `translateX(-${currentIndex * slideWidth}px)`; // Dịch chuyển mỗi slide theo chiều ngang
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


// Cập nhật ngày và giờ hiện tại
function updateDateTime() {
    const now = new Date();
    const options = { weekday: "long", year: "numeric", month: "long", day: "numeric" };
    const date = now.toLocaleDateString("vi-VN", options);
    const time = now.toLocaleTimeString("vi-VN", { hour: "2-digit", minute: "2-digit", second: "2-digit" });

    document.getElementById("date").textContent = date;
    document.getElementById("time").textContent = time;

    // Cập nhật các ngày chiếu
    const today = new Date();
    const tomorrow = new Date(today);
    tomorrow.setDate(today.getDate() + 1);  // Ngày mai
    const dayAfterTomorrow = new Date(today);
    dayAfterTomorrow.setDate(today.getDate() + 2);  // Ngày kia

    const dateStrings = [
        today.toLocaleDateString("vi-VN", { weekday: 'short', day: 'numeric', month: 'short' }),
        tomorrow.toLocaleDateString("vi-VN", { weekday: 'short', day: 'numeric', month: 'short' }),
        dayAfterTomorrow.toLocaleDateString("vi-VN", { weekday: 'short', day: 'numeric', month: 'short' }),
    ];

    // Cập nhật ngày chiếu trong bảng lịch chiếu
    const scheduleRows = document.querySelectorAll(".schedule-table tbody tr");
    scheduleRows[0].cells[0].textContent = dateStrings[0]; // Hôm nay
    scheduleRows[1].cells[0].textContent = dateStrings[1]; // Ngày mai
    scheduleRows[2].cells[0].textContent = dateStrings[2]; // Ngày kia
}

// Cập nhật mỗi giây
setInterval(updateDateTime, 1000);


    // Tính tổng số tiền
    const totalAmount = document.getElementById("total-price").textContent.replace(/\D/g, "");





    function bookTickets() {
        const selectedSeatsElements = document.querySelectorAll(".seat.selected");
        if (selectedSeatsElements.length === 0) {
            alert("Bạn chưa chọn ghế nào!");
            return;
        }
    
        // Lấy thông tin ghế đã chọn
        const seatNumbers = [...selectedSeatsElements].map(seat => seat.dataset.seatNumber).join(", ");
    
        // Lấy thông tin ngày và giờ chiếu
        const selectedDate = document.getElementById("date").textContent || "Chưa chọn ngày";
        const selectedTimeButtons = document.querySelectorAll(".schedule-times.active button");
        let selectedTime = "Chưa chọn giờ chiếu"; // Khởi tạo giá trị mặc định
    
        console.log("Tìm các button giờ chiếu:", selectedTimeButtons); // Kiểm tra các button giờ chiếu
        selectedTimeButtons.forEach((button) => {
            if (button.classList.contains("selected-time")) {
                selectedTime = button.textContent;
            }
        });
    
        console.log("Giờ chiếu đã chọn: ", selectedTime); // Kiểm tra giá trị của selectedTime
    
        // Kiểm tra nếu giờ chiếu chưa được chọn
        if (selectedTime === "Chưa chọn giờ chiếu") {
            alert("Bạn chưa chọn giờ chiếu!");
            return;
        }
    
        // Lấy thông tin tổng tiền
        const totalAmount = document.getElementById("total-price").textContent.replace(/\D/g, "");
    
        // Hiển thị thông tin đặt vé
        alert(`Thông tin đặt vé:\n- Ngày: ${selectedDate}\n- Giờ: ${selectedTime}\n- Ghế: ${seatNumbers}\n- Tổng tiền: ${totalAmount} VNĐ`);
    
        // Gửi dữ liệu tới save_ticket.php
        const data = {
            user_id: 1,  // Giả sử user_id là 1 (có thể lấy từ session)
            seat_number: seatNumbers,
            movie_name: document.getElementById('movie_name1').textContent, // Tên phim
            show_time: selectedTime,
            amount: parseFloat(totalAmount)  // Số tiền cần thanh toán
        };
    
        fetch('../html/save_ticket.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        })
        .then(response => response.json())
        .then(result => {
            console.log('Response:', result);
            if (result.message === "Đặt vé thành công!") {
                alert('Đặt vé thành công!');
            } else {
                alert('Đặt vé thất bại: ' + result.message);
            }
        })
        .catch(error => {
            console.error('Lỗi:', error);
            alert('Có lỗi xảy ra khi đặt vé.');
        });
    }
    
    
    
    
    