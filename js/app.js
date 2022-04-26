jQuery(document).ready(($) => {
  /*** Elements ***/
  const loginModal = `
        <div class="mdgg-modal-bg"></div>
        <div class="mdgg-modal">
            <p class="mdgg-bold">Please Log In To Continue</p>
            <form id="mdgg-login">
                <label>
                    Username or email
                    <input type="text" name="username" placeholder="Your Username" required>
                </label>
                <label>
                    Password
                    <input type="password" name="pass" required>
                </label>
                <input type="hidden" name="nonce" value="${mdgg_ajax.nonce}">
                <button class="mdgg-btn">Log In</button>
            </form>
            <a href="${mdgg_ajax.lostPwd}">Forgot Password</a> | <a href="${mdgg_ajax.register}">Register</a>
        </div>
    `;

  const videoBlock = `
        <div class="mdgg-video-block">
            <p>You must log in to continue watching</p>
            <button class="mdgg-btn mdgg-modal-trigger">Log In</button>
        </div>
    `;

  const currentVideo = {
    obj: null,
    setObj: function (video) {
      this.obj = video;
    },
  };
  // Connect with the WISTIA data and start watching the video time
  const limitVideo = () => {
    window._wq = window._wq || [];
    _wq.push({
      id: "ezpbmlky1x",
      onReady: (video) => {
        video.bind("secondchange", (s) => {
          if (s >= 60 && mdgg_ajax.loggedIn != 1) {
            // Stop the video and make the user login
            forceLogin(video);
            currentVideo.setObj(video);
          }
        });
      },
    });
  };

  if (mdgg_ajax.loggedIn != 1) {
    limitVideo();
  }

  const forceLogin = (video) => {
    video.pause();
    blockVideo();
    createModal();
  };

  /*** Listeners ***/
  // Create a couple of options for closing the modal
  $("body").on("click", ".mdgg-modal-bg", function () {
    removeModal();
  });

  $(document).on("keydown", (event) => {
    if (event.key == "Escape") {
      removeModal();
    }
  });

  $("body").on("click", ".mdgg-modal-trigger", () => {
    createModal();
  });

  // FORM SUBMISSION
  $("body").on("submit", "#mdgg-login", function (e) {
    e.preventDefault();

    $.ajax({
      type: "post",
      url: mdgg_ajax.ajaxurl,
      data: {
        action: "mdgg_ajax_login",
        content: $(this).serialize(),
      },
      success: function (data) {
        if (data == 1) {
          mdgg_ajax.loggedIn = 1;
          currentVideo.obj.play();
          removeModal();
          removeBlock();
        } else {
          failedLogin();
        }
      },
      error: function (data) {
        alert(
          "Something went wrong, please contact support if you continue to experience issues."
        );
      },
    });
    e.preventDefault();
  });

  /*** Utitlities ***/

  // Function to close the modal
  const removeModal = () => {
    $(".mdgg-modal-bg, .mdgg-modal").remove();
  };

  // Function to create the modal
  const createModal = () => {
    $("body").append(loginModal);
  };

  // Function to remove the video block
  const removeBlock = () => {
    $(".mdgg-video-block").remove();
  };

  // Function to block out the video
  const blockVideo = () => {
    $("#mdgg-player").append(videoBlock);
  };

  const failedLogin = () => {
    $(".mdgg-warning").remove();
    $(".mdgg-modal form").prepend(
      '<p class="mdgg-warning">Sorry, that was incorrect. Please try again.</p>'
    );
    $(".mdgg-modal input[name=username], .mdgg-modal input[name=pass]").val("");
  };
});
