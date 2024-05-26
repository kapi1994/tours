<main>
    <section class="container">
        <div class="row mt-5">
            <div class="col-lg-6 mx-auto">
                <h2 class="mb-3">Contact us</h2>
                <div id="contact_response_message" class="mb-2"></div>
                <form action="#">
                    <div class="mb-3">
                        <label for="first_name" class="mb-1">First name</label>
                        <input type="text" name="first_name" id="first_name" class="form-control mb-1">
                        <div id="first_name_error"></div>
                    </div>
                    <div class="mb-3">
                        <label for="last_name" class="mb-1">Last name</label>
                        <input type="text" name="last_name" id="last_name" class="form-control">
                        <div id="last_name_error"></div>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="mb-1">Email</label>
                        <input type="email" name="email" id="email" class="form-control">
                        <div id="email_error"></div>
                    </div>
                    <div class="mb-3">
                        <label for="message" class="mb-1">Message</label>
                        <textarea name="message" id="message" class="form-control"></textarea>
                        <div id="message_error"></div>
                    </div>
                    <button class="btn btn-sm btn-primary" id="btnContactUs" type="button" name="btnContactUs">Contact us</button>
                </form>
            </div>
        </div>
    </section>
</main>