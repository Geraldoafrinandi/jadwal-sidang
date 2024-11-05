<!-- Navbar -->
<nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl " id="navbarBlur" data-scroll="false">
    <div class="container-fluid py-1 px-3" style="margin-left: 300px">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-0 px-0 ">
                <li class="breadcrumb-item text-sm text-white active" aria-current="page">
                    <h4 class="d-inline font-weight-bolder mb-0 text-truncate" style="color: #ffffff; max-width: 100%;">
                        Selamat datang, {{ Auth::user()->name }}! <br> <h5 class="text-white" style="font-size: 15px">Anda login sebagai {{ Auth::user()->role }}</h5>
                    </h4>

                </li>

            </ol>
        </nav>

        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
            <div class="ms-md-auto pe-md-3 d-flex align-items-center">

                <div class="input-group me-2" style="width: 100%; max-width: 300px;">
                    <span class="input-group-text text-body"><i class="fas fa-calendar-alt" aria-hidden="true"></i></span>
                    <span id="currentDate" class="form-control" style="border: none; background-color: white;"></span>
                </div>

                <div class="input-group me-2"> <!-- Added margin-end for spacing -->
                    <span class="input-group-text text-body"><i class="fas fa-search" aria-hidden="true"></i></span>
                    <input type="text" class="form-control" placeholder="Type here...">
                </div>

                <!-- Tanggal Real-Time -->



            </div>
            <li class="nav-item d-flex align-items-center ml-4">
                <a href="/profile" class="nav-link text-white font-weight-bold px-0 mb-3 text-center">
                    <div class="text-center">
                        <img src="{{ Auth::user()->image && Auth::user()->image !== 'default.jpg' ? asset('images/' . (Auth::user()->role === 'mahasiswa' ? 'mahasiswa/' : 'dosen/') . Auth::user()->image) : asset('images/default.jpg') }}" alt="User Profile Image"

                             alt="Profile Picture"
                             class="rounded-circle"
                             style="width: 30px; height: 30px; object-fit: cover;">
                        <div class="mt-1">
                            <span class="d-sm-inline d-block">{{ Auth::user()->name }}</span>
                        </div>
                    </div>
                </a>
            </li>
        </div>
    </div>
</nav>

<script>
$(document).ready(function() {
    // Update tanggal dan waktu real-time
    function updateDateTime() {
        let now = new Date();
        let options = { year: 'numeric', month: 'long', day: 'numeric' };
        let formattedDate = now.toLocaleDateString('id-ID', options); // Format tanggal sesuai dengan lokal Indonesia
        let hours = String(now.getHours()).padStart(2, '0');
        let minutes = String(now.getMinutes()).padStart(2, '0');
        let seconds = String(now.getSeconds()).padStart(2, '0');

        $('#currentDate').text(formattedDate); // Tampilkan tanggal
        $('#currentTime').text(hours + ':' + minutes + ':' + seconds); // Tampilkan waktu
    }

    setInterval(updateDateTime, 1000); // Update setiap detik
    updateDateTime(); // Initial call
});
</script>
