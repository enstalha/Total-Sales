// ajax.js
// two features: username availability check + refresh bid on auction page

document.addEventListener('DOMContentLoaded', function () {

    // --- Feature 1: username availability check on register page ---
    var usernameField = document.getElementById('username');
    var feedbackSpan  = document.getElementById('username-feedback');

    if (usernameField && feedbackSpan) {
        var typingTimer;

        usernameField.addEventListener('input', function () {
            clearTimeout(typingTimer);
            var val = usernameField.value.trim();

            if (val.length < 3) {
                feedbackSpan.textContent = '';
                feedbackSpan.className = 'feedback-msg';
                return;
            }

            // wait a bit after user stops typing before hitting server
            typingTimer = setTimeout(function () {
                fetch('index.php?page=check_username&username=' + encodeURIComponent(val))
                    .then(function (r) { return r.json(); })
                    .then(function (data) {
                        if (data.taken) {
                            feedbackSpan.textContent = 'Username already taken.';
                            feedbackSpan.className = 'feedback-msg taken';
                        } else {
                            feedbackSpan.textContent = 'Username is available.';
                            feedbackSpan.className = 'feedback-msg ok';
                        }
                    })
                    .catch(function () {
                        // not sure if this is right but it works for now
                        feedbackSpan.textContent = '';
                    });
            }, 500);
        });
    }

    // --- Feature 2: refresh current bid on auction detail page ---
    var refreshBtn    = document.getElementById('refresh-bid-btn');
    var bidDisplay    = document.getElementById('current-bid-display');

    if (refreshBtn && bidDisplay && typeof currentAuctionId !== 'undefined') {
        refreshBtn.addEventListener('click', function () {
            fetch('index.php?page=get_bid&auction_id=' + currentAuctionId)
                .then(function (r) { return r.json(); })
                .then(function (data) {
                    if (data.current_bid) {
                        bidDisplay.textContent = '$' + parseFloat(data.current_bid).toFixed(2);
                    } else {
                        bidDisplay.textContent = 'No bids yet';
                    }
                })
                .catch(function (err) {
                    console.log('refresh failed', err);
                });
        });
    }

});
