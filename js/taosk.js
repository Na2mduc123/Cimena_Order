// Lưu trữ dữ liệu sự kiện
let events = [];
let editingIndex = null; // Lưu chỉ số sự kiện đang chỉnh sửa

// Tải dữ liệu tỉnh/thành, quận/huyện, phường/xã
let addressData = {
    provinces: [],
    districts: {},
    wards: {}
};

async function loadProvinces() {
    try {
        const response = await fetch('https://provinces.open-api.vn/api/p/');
        const data = await response.json();
        addressData.provinces = data;

        const provinceSelect = document.getElementById('province');
        provinceSelect.innerHTML = '<option value="">Chọn Tỉnh/Thành</option>';
        data.forEach(province => {
            provinceSelect.innerHTML += `<option value="${province.code}">${province.name}</option>`;
        });
    } catch (error) {
        console.error("Không thể tải dữ liệu tỉnh/thành:", error);
    }
}

async function loadDistricts(provinceCode) {
    if (!provinceCode) return;

    try {
        const response = await fetch(`https://provinces.open-api.vn/api/p/${provinceCode}?depth=2`);
        const data = await response.json();
        addressData.districts[provinceCode] = data.districts;

        const districtSelect = document.getElementById('district');
        districtSelect.innerHTML = '<option value="">Chọn Quận/Huyện</option>';
        data.districts.forEach(district => {
            districtSelect.innerHTML += `<option value="${district.code}">${district.name}</option>`;
        });

        document.getElementById('ward').innerHTML = '<option value="">Chọn Phường/Xã</option>';
    } catch (error) {
        console.error("Không thể tải dữ liệu quận/huyện:", error);
    }
}

async function loadWards(districtCode) {
    if (!districtCode) return;

    try {
        const response = await fetch(`https://provinces.open-api.vn/api/d/${districtCode}?depth=2`);
        const data = await response.json();
        addressData.wards[districtCode] = data.wards;

        const wardSelect = document.getElementById('ward');
        wardSelect.innerHTML = '<option value="">Chọn Phường/Xã</option>';
        data.wards.forEach(ward => {
            wardSelect.innerHTML += `<option value="${ward.code}">${ward.name}</option>`;
        });
    } catch (error) {
        console.error("Không thể tải dữ liệu phường/xã:", error);
    }
}

// Lưu sự kiện
function saveEvent() {
    const name = document.getElementById('event-name').value;
    const time = document.getElementById('event-time').value;
    const province = document.getElementById('province').value;
    const district = document.getElementById('district').value;
    const ward = document.getElementById('ward').value;
    const detailedAddress = document.getElementById('detailed-address').value;
    const logo = document.getElementById('logo').files[0];
    const banner = document.getElementById('banner').files[0];

    if (!name || !time || !province || !district || !ward || !detailedAddress) {
        alert("Vui lòng điền đầy đủ thông tin!");
        return;
    }

    const event = {
        name,
        time,
        address: `${detailedAddress}, ${ward}, ${district}, ${province}`,
        logo: logo ? URL.createObjectURL(logo) : '',
        banner: banner ? URL.createObjectURL(banner) : '',
        status: new Date(time) > new Date() ? 'pending' : 'past'
    };

    if (editingIndex !== null) {
        events[editingIndex] = event;
        editingIndex = null;
    } else {
        events.push(event);
    }

    document.getElementById('event-form').reset();
    alert("Sự kiện đã được lưu!");
    showEventList();
    renderEvents();
}

// Hiển thị danh sách sự kiện
function renderEvents() {
    const eventItems = document.getElementById('event-items');
    eventItems.innerHTML = '';

    events.forEach((event, index) => {
        const li = document.createElement('li');
        li.className = 'event-item';

        li.innerHTML = `
            <img src="${event.banner}" alt="Banner sự kiện">
            <div class="event-details">
                <h3>${event.name}</h3>
                <p><strong>Thời gian:</strong> ${new Date(event.time).toLocaleString()}</p>
                <p><strong>Địa điểm:</strong> ${event.address}</p>
                <p><strong>Trạng thái:</strong> ${event.status === 'pending' ? 'Chờ duyệt' : 'Đã qua'}</p>
            </div>
            <div class="event-actions">
                <button class="btn-edit" onclick="editEvent(${index})">Chỉnh sửa</button>
                <button class="btn-delete" onclick="deleteEvent(${index})">Xóa</button>
            </div>
        `;
        eventItems.appendChild(li);
    });
}

// Xóa sự kiện
function deleteEvent(index) {
    if (confirm('Bạn có chắc chắn muốn xóa sự kiện này?')) {
        events.splice(index, 1);
        renderEvents();
    }
}

// Chỉnh sửa sự kiện
function editEvent(index) {
    const event = events[index];
    document.getElementById('event-name').value = event.name;
    document.getElementById('event-time').value = event.time;

    const [detailedAddress, ward, district, province] = event.address.split(', ');
    document.getElementById('detailed-address').value = detailedAddress;

    document.getElementById('province').value = province;
    loadDistricts(province).then(() => {
        document.getElementById('district').value = district;
        return loadWards(district);
    }).then(() => {
        document.getElementById('ward').value = ward;
    });

    editingIndex = index;
    showCreateEvent();
}

// Lọc sự kiện theo trạng thái
function filterEvents(status) {
    const filteredEvents = events.filter(event => event.status === status);
    renderFilteredEvents(filteredEvents);
}

function renderFilteredEvents(filteredEvents) {
    const eventItems = document.getElementById('event-items');
    eventItems.innerHTML = '';

    filteredEvents.forEach((event, index) => {
        const li = document.createElement('li');
        li.className = 'event-item';

        li.innerHTML = `
            <img src="${event.banner}" alt="Banner sự kiện">
            <div class="event-details">
                <h3>${event.name}</h3>
                <p><strong>Thời gian:</strong> ${new Date(event.time).toLocaleString()}</p>
                <p><strong>Địa điểm:</strong> ${event.address}</p>
                <p><strong>Trạng thái:</strong> ${event.status === 'pending' ? 'Chờ duyệt' : 'Đã qua'}</p>
            </div>
        `;
        eventItems.appendChild(li);
    });
}

// Chuyển đổi giữa các màn hình
function showCreateEvent() {
    document.getElementById('create-event').classList.remove('hidden');
    document.getElementById('event-list').classList.add('hidden');
}

function showEventList() {
    document.getElementById('create-event').classList.add('hidden');
    document.getElementById('event-list').classList.remove('hidden');
    renderEvents();
}

// Tải dữ liệu khi trang được tải
window.onload = loadProvinces;