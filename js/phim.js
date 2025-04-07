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

// Danh sách 72 bộ phim (thay thế nội dung này bằng dữ liệu thực tế của bạn)
const movies = [
    { title: "Linh Miêu - Quỷ Nhập Tràng", img: "../img/linhmieu.jpg", link: "../html/ds_phim/linhmieu.html" },
    { title: "Doraemon: Nobita Và Bản Giao Hưởng Địa Cầu", img: "../img/doremon.jpg", link: "../html/ds_phim/doremon.html" },
    { title: "Quỷ Ăn Tạng", img: "../img/ty_700x1000.jpg", link: "../html/ds_phim/quyantang.html" },
    { title: "Ròm", img: "../img/RomflimVN.jpg", link: "../html/ds_phim/rom.html" },
    { title: "Mắt Biếc", img: "../img/matbiec.jpg", link: "../html/ds_phim/matbiec.html" },
    { title: "Mai", img: "../img/mai.jpg", link: "../html/ds_phim/mai.html" },
    { title: "Avenger", img: "../img/avenger.jpg", link: "../html/ds_phim/Avenger.html" },
    { title: "Avatar - Dòng Chảy Của Nước", img: "../img/avatar.jpg", link: "../html/ds_phim/avatar.html" },
    { title: "Đào, Phở Và Piano", img: "../img/daopho.jpg", link: "../html/ds_phim/daopho.html" },
    { title: "Cười Xuyên Biên Giới", img: "../img/cuoi-xuyen-bien-gioi-500_1731395845993.jpg", link: "../html/ds_phim/laught.html" },
    { title: "Em Là Bà Nội Của Anh", img: "../img/emlabanoi.jpg", link: "../html/ds_phim/emlabanoi.html" },
    { title: "Wakanda - Chiến Binh Báo Đen", img: "../img/wakanda.jpeg", link: "../html/ds_phim/wakanda.html" },


    { title: "Kẻ Ăn Hồn", img: "../img/keanhon.jpg", link: "../html/ds_phim/keanhon.html" },
    { title: "Nụ Hôn Bạc Tỷ", img: "../img/nuhonbacty.jpg", link: "../html/ds_phim/nuhonbacti.html" },
    { title: "Yêu Nhầm Bạn Thân", img: "../img/YNBT.jpg", link: "../html/ds_phim/yeunhambanthan.html" },
    { title: "Chị Dâu", img: "../img/chidau.jpg", link: "../html/ds_phim/chidau.html" },
    { title: "Mufasa: Vua Sư Tử", img: "../img/mufasa.jpg", link: "../html/ds_phim/vuasutu.html" },
    { title: "Thiên Tài Ném Phao", img: "../img/thientainemphao.jpg", link: "../html/ds_phim/thientainemphao.html" },
    { title: "Yêu Là Đau", img: "../img/yeuladau.jpg", link: "../html/ds_phim/yeuladau.html" },
    { title: "Trước Ngày Em Đến", img: "../img/truocngayemden.jpg", link: "../html/ds_phim/truocngayemden.html" },
    { title: "Titanic", img: "../img/titanic.jpg", link: "../html/ds_phim/titanic.html" },
    { title: "Ngày Em Đẹp Nhất", img: "../img/ngayemdepnhat.jpg", link: "../html/ds_phim/ngayemdepnhat.html" },
    { title: "Yêu Phải Nàng Lắm Chiêu", img: "../img/yeuphainanglamchieu.jpg", link: "../html/ds_phim/yeuphainanglamchieu.html" },
    { title: "Em Và Trịnh", img: "../img/emvatrinh.jpg", link: "../html/ds_phim/emvatrinh.html" },


    { title: "100 Ngày Bên Em", img: "../img/100ngay.jpg", link: "../html/ds_phim/linhmieu.html" },
    { title: "Trái Tim Quái Vật", img: "../img/ttqv.jpg", link: "../html/ds_phim/doremon.html" },
    { title: "Bố Già", img: "../img/bogia.jpeg", link: "../html/ds_phim/quyantang.html" },
    { title: "10 Lời Nguyền Trở Lại", img: "../img/10loinguyen.jpg", link: "../html/ds_phim/rom.html" },
    { title: "Bóng Đè", img: "../img/bongde.jpg", link: "../html/ds_phim/matbiec.html" },
    { title: "Dragon Ball Super: Sự Hồi Sinh Của Frieza", img: "../img/dragonball.png", link: "../html/ds_phim/mai.html" },
    { title: "Doraemon: Nobita Và Vùng Đất Lý Tưởng Trên Bầu Trời", img: "../img/doraemon2.jpg", link: "../html/ds_phim/Avenger.html" },
    { title: "Maika - Cô Bé Đến Từ Hành Tinh Khác", img: "../img/maika.jpg", link: "../html/ds_phim/avatar.html" },
    { title: "Tiệc Trăng Máu", img: "../img/tiectrangmau.jpg", link: "../html/ds_phim/daopho.html" },
    { title: "Đừng Gọi Anh Là Bố", img: "../img/dunggoianhlabo.jpg", link: "../html/ds_phim/laught.html" },
    { title: "Gọi Hồn Quỷ Dữ", img: "../img/goihon.jpg", link: "../html/ds_phim/emlabanoi.html" },
    { title: "Cám", img: "../img/cam.jpg", link: "../html/ds_phim/wakanda.html" },
];

// Hàm để lấy danh sách phim theo ngày
function getMoviesByDate(movies, perPage) {
    const date = new Date();
    const dayOfYear = Math.floor((date - new Date(date.getFullYear(), 0, 0)) / 1000 / 60 / 60 / 24); // Tính ngày trong năm
    const startIndex = (dayOfYear % movies.length); // Vị trí bắt đầu trong danh sách phim
    const endIndex = startIndex + perPage;

    // Nếu hết danh sách, quay lại từ đầu
    const selectedMovies = [];
    for (let i = 0; i < perPage; i++) {
        selectedMovies.push(movies[(startIndex + i) % movies.length]);
    }

    return selectedMovies;
}

// Hàm hiển thị danh sách phim
function renderMovies() {
    const movieList = document.querySelector("#movie-list .ds");
    movieList.innerHTML = ""; // Xóa nội dung cũ

    const moviesToShow = getMoviesByDate(movies, 12); // Lấy 12 phim
    moviesToShow.forEach(movie => {
        const listItem = `
            <li class="tranh">
                <a href="${movie.link}">
                    <div class="img1">
                        <div class="anhtoi"><img src="${movie.img}" alt="${movie.title}" height="350" width="253"><br>
                            <button><a href="${movie.link}">Mua vé</a></button>
                        </div>
                    </div>
                </a>
                <div class="thongtin">
                    <b>${movie.title}</b><br>
                </div>
            </li>
        `;
        movieList.insertAdjacentHTML("beforeend", listItem);
    });
}

// Gọi hàm render khi tải trang
document.addEventListener("DOMContentLoaded", renderMovies);
