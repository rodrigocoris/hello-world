$(document).ready(function() {
    var extenced_token = $('#extenced_token').val();
    var resendButton = $('#resend-code-button');
    var timerElement = $('#timer');
    var resendTimer = $('#resend-timer');

    function startCountdown(remainingTime) {
        resendButton.prop('disabled', true).addClass('disabled');
        resendTimer.show();
        timerElement.text(remainingTime);
        var countdown = setInterval(function () {
            remainingTime--;
            timerElement.text(remainingTime);

            if (remainingTime <= 0) {
                clearInterval(countdown);
                resendButton.prop('disabled', false).removeClass('disabled');
                resendTimer.hide();
            }
        }, 1000);
    }

    // Opting the user value to be sent to ajax
    let inputToken =  $('input[name="extenced_token"]').val();
    let inputRequest = $('input[name="input_request"]').val();

    console.log(`inputToken: ${inputToken} \ninputRequest: ${inputRequest}`);

    $.ajax({
        url: getResendTimeUrl,
        method: 'POST',
        data: {
            _token: csrfToken,
            user_value: inputToken,
            input_request: inputRequest
        },
        success: function(response) {
            console.log('AJAX success response:', response);
            if (response.remainingTime > 0) {
                startCountdown(response.remainingTime);
            }
        },
        error: function(xhr, status, error) {
            console.error('AJAX error:', status, error);
        }
    });

    $('#resend-code-form').submit(function(e) {
        if (resendButton.prop('disabled')) {
            e.preventDefault();
        }
    });
});