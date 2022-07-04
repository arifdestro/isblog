<!-- Footer-->
<footer class="bg-black text-center py-5">
    <div class="container px-5">
        <div class="text-white-50 small">
            <div class="mb-2">&copy; <img src="<?= base_url() ?>assets/img/logo_1.svg" alt="logo" width="30" height="24"> Kang Dongeng <?= date('Y') ?></div>
            <?php
            $foot = $this->db->get('kebijakan')->result_array();
            for ($i = 0; $i < count($foot); $i++) {
                $link = $foot[$i]['permalink_kb'];
                $nama = $foot[$i]['nama_kb'];
            ?>
                <a class="text-decoration-none" href="<?= base_url("legal/$link") ?>"><?= $nama ?></a>
                <?php
                $now = (int) count($foot) - 1;
                if ($now == $i) { ?>
                <?php } else { ?>
                    <span class="mx-1">&middot;</span>
                <?php } ?>
            <?php } ?>
        </div>
    </div>
</footer>
<!-- Feedback Modal-->
<div class="modal fade" id="feedbackModal" tabindex="-1" aria-labelledby="feedbackModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-gradient-primary-to-secondary p-4">
                <h5 class="modal-title font-alt text-white" id="feedbackModalLabel">Kirim Pesan</h5>
                <button class="btn-close btn-close-white" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body border-0 p-4">
                <?= form_open('kirim_pesan', 'autocomplete="off"', ['url' => current_url()]) ?>
                <!-- Name input-->
                <div class="form-floating mb-3">
                    <input class="form-control" id="name" name="nama" type="text" placeholder="Masukkan nama Anda..." data-sb-validations="required" />
                    <label for="name" class="text-muted">Name</label>
                </div>
                <!-- Email address input-->
                <div class="form-floating mb-3">
                    <input class="form-control" id="email" name="email" type="email" placeholder="Masukkan email Anda..." data-sb-validations="required,email" />
                    <label for="email" class="text-muted">Email</label>
                </div>
                <!-- Message input-->
                <div class="form-floating mb-3">
                    <textarea class="form-control" id="isi" name="isi" type="text" placeholder="Masukkan pesan Anda..." style="height: 10rem" data-sb-validations="required"></textarea>
                    <label for="isi" class="text-muted">Pesan</label>
                </div>
                <div class="form-floating mb-3">
                    <?php $get = $this->db->get('pengaturan')->row_array(); ?>
                    <div class="g-recaptcha" name="g-recaptcha-response" data-sitekey="<?= $get['recaptcha_site'] ?>"></div>
                </div>
                <div class="d-grid"><button class="btn btn-primary rounded-pill btn-lg" id="submitButton" type="submit">Submit</button></div>
                <?= form_close() ?>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="search" tabindex="-1" aria-labelledby="searchLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content bg-transparent border-0">
            <div class="modal-body border-0">
                <form method="GET" action="<?= base_url('search'); ?>">
                    <div class="input-group mb-3">
                        <input type="text" name="cari" class="form-control form-control-lg" placeholder="Cari Postingan ...." aria-label="Recipient's username" aria-describedby="button-addon2">
                        <button class="btn btn-dark" type="submit" id="button-addon2">Cari <i class="fas fa-chevron-right"></i></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<button type="button" class="btn btn-dark btn-sm btn-floating pe-2 ps-2" id="btn-back-to-top">
    <i class="fas fa-chevron-up"></i>
</button>

<!-- jQuery -->
<script src="<?= base_url() ?>assets/plugins/jquery/jquery.min.js"></script>

<!-- Bootstrap core JS-->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>

<!-- Core theme JS-->
<script src="<?= base_url() ?>assets/js/scripts.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $("#pesan").fadeTo(4000, 500).slideUp(500, function() {
            $("#pesan").slideUp(500);
        });
        $("#toast").toast('show');
    });
</script>

<script>
    /* begin begin Back to Top button  */
    (function() {
        'use strict';
        //
        document.querySelectorAll('.reply-comment').forEach(item => {
            item.addEventListener('click', event => {
                //handle click
                var nama = item.getAttribute('data-nama')
                // set value of `parent_id`
                document.forms['Komentar']['parent_id'].value = item.id;

                //get the target div you want to append/prepend to
                var statusBalas = document.getElementById("info_balas");

                //prepend text
                statusBalas.innerHTML = '<div class="alert alert-warning">Membalas komentar dari <b>' + nama + '</b></div>';
            })
        })

        //
        /* begin begin Back to Top button  */

        var goTopBtn = document.getElementById('back-to')

        function trackScroll() {
            var scrolled = window.pageYOffset;
            var coords = document.documentElement.clientHeight;

            if (scrolled > coords) {
                goTopBtn.classList.add("d-block");
            }
            if (scrolled < coords) {
                goTopBtn.classList.remove("d-block");
            }
        }

        window.addEventListener("scroll", trackScroll);

        /* end begin Back to Top button  */
    })();
</script>

<script>
    //Get the button
    let mybutton = document.getElementById("btn-back-to-top");

    // When the user scrolls down 20px from the top of the document, show the button
    window.onscroll = function() {
        scrollFunction();
    };

    function scrollFunction() {
        if (
            document.body.scrollTop > 20 ||
            document.documentElement.scrollTop > 20
        ) {
            mybutton.style.display = "block";
        } else {
            mybutton.style.display = "none";
        }
    }
    // When the user clicks on the button, scroll to the top of the document
    mybutton.addEventListener("click", backToTop);

    function backToTop() {
        document.body.scrollTop = 0;
        document.documentElement.scrollTop = 0;
    }
</script>

<script>
    /*==================== DARK LIGHT THEME ====================*/
    const themeButton = document.getElementById('switch-id')
    const darkTheme = 'dark-theme'
    const iconTheme = 'fa-sun'

    // Previously selected topic (if user selected)
    const selectedTheme = localStorage.getItem('selected-theme')
    const selectedIcon = localStorage.getItem('selected-icon')

    // We obtain the current theme that the interface has by validating the dark-theme class
    const getCurrentTheme = () => document.body.classList.contains(darkTheme) ? 'dark' : 'light'
    const getCurrentIcon = () => themeButton.classList.contains(iconTheme) ? 'fa-moon' : 'fa-sun'

    // We validate if the user previously chose a topic
    if (selectedTheme) {
        // If the validation is fulfilled, we ask what the issue was to know if we activated or deactivated the dark
        document.body.classList[selectedTheme === 'dark' ? 'add' : 'remove'](darkTheme)
        themeButton.classList[selectedIcon === 'fa-moon' ? 'add' : 'remove'](iconTheme)
    }

    // Activate / deactivate the theme manually with the button
    themeButton.addEventListener('click', () => {
        // Add or remove the dark / icon theme
        document.body.classList.toggle(darkTheme)
        themeButton.classList.toggle(iconTheme)
        // We save the theme and the current icon that the user chose
        localStorage.setItem('selected-theme', getCurrentTheme())
        localStorage.setItem('selected-icon', getCurrentIcon())
    })
</script>

<!-- <script src="https://cdn.startbootstrap.com/sb-forms-latest.js"></script> -->
</body>

</html>