<?php
$showSearch = false;
include("katalog.php");
?>

<!-- Hero Section -->
<div id="hero" class="d-flex align-items-center justify-content-center">
    <div class="container">
        <div class="row">
            <div class="col-12 hero-tagline text-center">
                <h1 class="text-white">Selamat datang di Ruang Baca</h1>
                <h2 class="">Jti Polinema</h2>
                <a href="katalogPage.php" class="btn btn-outline-light mt-3">Cek Katalog →</a>
            </div>
        </div>
    </div>
</div>

<!-- About Section -->
<section id="about" class="d-flex align-items-center justify-content-center mt-5">
    <div class="container">
        <div class="row">
            <div class="col-md-6 text-center mb-4 mb-md-0">
                <img src="../../Assets/img/rbaca-background.jpeg" alt="Foto RuangBaca" class="img-fluid rounded shadow">
            </div>
            <div class="col-md-6">
                <div class="about-content">
                    <h2 class="section-title text-dark mb-4">Temukan Ruang Baca</h2>
                    <p class="lead">
                        Selamat datang di dunia inspiratif Ruang Baca di JTI POLINEMA. Ruang baca kami lebih dari sekadar ruang; ini merupakan perjalanan menuju pengetahuan dan kolaborasi.
                    </p>
                    <p>
                        Telusuri lingkungan yang dirancang untuk meningkatkan pengalaman belajar Anda. Dengan perpaduan sempurna antara tradisi dan teknologi, Ruang Baca sedang membentuk masa depan pendidikan.
                    </p>
                    <p>
                        Bergabunglah dalam petualangan menarik ini di mana setiap lembaran yang dibalik merupakan langkah menuju hari esok yang lebih cerah.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>



<!-- Team Section -->
<section id="team" class="d-flex align-items-center justify-content-center mt-5 mb-5">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <h2 class="section-title text-darkblue mb-4">Our Team</h2>
            </div>

            <!-- Individual Team Members -->
            <div class="col-md-4">
                <div class="team-member">
                    <img src="../../Assets/img/eddo.jpg" alt="Team Member 1" class="img-fluid" width="100px">
                    <h4 class="team-member-name">Eddo Dava A</h4>
                    <p class="team-member-role">Project Manager & developer</p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="team-member">
                    <img src="../../Assets/img/fathur.jpg" alt="Team Member 2" class="img-fluid" width="100px">
                    <h4 class="team-member-name">M. Fathurrozak A</h4>
                    <p class="team-member-role">Analyst </p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="team-member">
                    <img src="../../Assets/img/yayun.jpg" alt="Team Member 3" class="img-fluid" width="100px">
                    <h4 class="team-member-name">Yayun Eldina </h4>
                    <p class="team-member-role">UI & UX Designer</p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="team-member">
                    <img src="../../Assets/img/yunila.jpg" alt="Team Member 4" class="img-fluid" width="100px">
                    <h4 class="team-member-name">Yunila Putmasari</h4>
                    <p class="team-member-role">Developer</p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="team-member">
                    <img src="../../Assets/img/syahrul.jpg" alt="Team Member 5" class="img-fluid" width="100px">
                    <h4 class="team-member-name">Achmad Syahrul Faroh</h4>
                    <p class="team-member-role">Developer</p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="team-member">
                    <img src="../../Assets/img/ade.png" alt="Team Member 6" class="img-fluid" width="100px">
                    <h4 class="team-member-name">Ade Putro Wibowo</h4>
                    <p class="team-member-role">Developer</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Contact Section -->
<section id="contact" class="d-flex align-items-center justify-content-center mt-5">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <h2 class="section-title text-darkblue mb-4">Contact Us</h2>
            </div>
            <div class="col-md-6 offset-md-3">
                <!-- modify this form HTML and place wherever you want your form -->
                <form id="my-form" action="https://formspree.io/f/mjvqqjlr" method="POST">
                    <div class="mb-3">
                        <label for="name" class="form-label">Your Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Your Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="message" class="form-label">Message</label>
                        <textarea class="form-control" id="message" name="message" rows="4" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Send Message</button>
                    <p id="my-form-status"></p>
                </form>
                <!-- Place this script at the end of the body tag -->
                <script>
                    var form = document.getElementById("my-form");

                    async function handleSubmit(event) {
                        event.preventDefault();
                        var status = document.getElementById("my-form-status");
                        var data = new FormData(event.target);
                        fetch(event.target.action, {
                            method: form.method,
                            body: data,
                            headers: {
                                'Accept': 'application/json'
                            }
                        }).then(response => {
                            if (response.ok) {
                                status.innerHTML = "Thanks for your submission!";
                                form.reset()
                            } else {
                                response.json().then(data => {
                                    if (Object.hasOwn(data, 'errors')) {
                                        status.innerHTML = data["errors"].map(error => error["message"]).join(", ")
                                    } else {
                                        status.innerHTML = "Oops! There was a problem submitting your form"
                                    }
                                })
                            }
                        }).catch(error => {
                            status.innerHTML = "Oops! There was a problem submitting your form"
                        });
                    }
                    form.addEventListener("submit", handleSubmit)
                </script>
            </div>
        </div>
    </div>
</section>


<!-- Footer Section -->
<footer class="" style="background-color: #1E2A3A; color: #fff;">
    <div class="container py-4 p-5">
        <div class="row">
            <div class="col-lg-6 col-md-12 mb-4 p-3">
                <h5 class="mb-3" style="letter-spacing: 2px;">Ruang Baca</h5>
                <p>
                    Selamat datang di dunia inspiratif Ruang Baca di JTI POLINEMA. Ruang Baca kami lebih dari sekadar ruang; ini merupakan perjalanan menuju pengetahuan dan kolaborasi.
                </p>
            </div>
            <div class="col-lg-3 col-md-6 mb-4 p-3">
                <h5 class="mb-1" style="letter-spacing: 2px;">Contact</h5>
                <p class="mb-1"> Email : </p>
                <p>RuangBaca@jti.polinema.ac.id</p>
            </div>
            <div class="col-lg-3 col-md-6 mb-4 p-3">
                <h5 class="mb-1" style="letter-spacing: 2px;">Opening Hours</h5>
                <table class="table" style="color: #ddd;">
                    <tbody>
                        <tr>
                            <td>Mon - Fri:</td>
                            <td>8am - 4pm</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2);">
        © <?php echo date("Y"); ?> Ruang Baca Jti Polinema
    </div>
</footer>