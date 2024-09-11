document.addEventListener('DOMContentLoaded', function() {
    const sidebar = document.querySelector("#sidebar");
    const hide_sidebar = document.querySelector(".hide-sidebar");
    const new_chat_button = document.querySelector(".new-chat");

    if (hide_sidebar) {
        hide_sidebar.addEventListener("click", function() {
            if (sidebar) {
                sidebar.classList.toggle("hidden");
            }
        });
    }

    const user_menu = document.querySelector(".user-menu ul");
    const show_user_menu = document.querySelector(".user-menu button");

    if (show_user_menu) {
        show_user_menu.addEventListener("click", function() {
            if (user_menu) {
                if (user_menu.classList.contains("show")) {
                    user_menu.classList.toggle("show");
                    setTimeout(function() {
                        user_menu.classList.toggle("show-animate");
                    }, 200);
                } else {
                    user_menu.classList.toggle("show-animate");
                    setTimeout(function() {
                        user_menu.classList.toggle("show");
                    }, 50);
                }
            }
        });
    }

    const models = document.querySelectorAll(".model-selector button");

    if (models) {
        for (const model of models) {
            model.addEventListener("click", function() {
                document.querySelector(".model-selector button.selected")?.classList.remove("selected");
                model.classList.add("selected");
            });
        }
    }

    const message_box = document.querySelector("#message");

    if (message_box) {
        message_box.addEventListener("keyup", function() {
            message_box.style.height = "auto";
            let height = message_box.scrollHeight + 2;
            if (height > 200) {
                height = 200;
            }
            message_box.style.height = height + "px";
        });
    }

    function show_view(view_selector) {
        document.querySelectorAll(".view").forEach(view => {
            view.style.display = "none";
        });

        document.querySelector(view_selector).style.display = "flex";
    }

    if (new_chat_button) {
        new_chat_button.addEventListener("click", function() {
            show_view(".new-chat-view");
        });
    }

    document.querySelectorAll(".conversation-button").forEach(button => {
        button.addEventListener("click", function() {
            show_view(".conversation-view");
        });
    });
});
