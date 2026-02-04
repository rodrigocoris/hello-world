<script>
    $(document).ready(function() {
        grecaptcha.ready(function() {
            grecaptcha.execute("{{ config('app.recaptcha.site_key') }}", {
                action: 'submit'
                }).then(function(captcha_token) {
                $('#reCAPTCHA-form').prepend(`<input type="hidden" name="captcha_token" value="${captcha_token}">`);
            });
        });
    });
</script>