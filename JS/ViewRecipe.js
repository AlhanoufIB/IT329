$(document).ready(function () {

    let openBtn = document.getElementById("AddComment");
    let modal = document.getElementById("CommentModal");
    let cancelBtn = document.getElementById("CancelModal");

    function openModal() {
        modal.classList.remove("Hidden");
    }

    function closeModal() {
        modal.classList.add("Hidden");
    }

    openBtn.addEventListener("click", openModal);
    cancelBtn.addEventListener("click", closeModal);

    modal.addEventListener("click", function (event) {
        if (event.target === modal) {
            closeModal();
        }
    });


    $("#FavouriteForm").submit(function (e) {

        e.preventDefault();

        var recipeID = $("#FavouriteRecipeID").val();

        $.post(
            "toggle_favourite.php",
            { recipe_id: recipeID },

            function (response) {

                if (response == "true") {

                    $("#FavouriteBtn").prop("disabled", true);

                    $("#FavouriteBtn").css({
                        "background-color": "#cccccc",
                        "color": "#666666",
                        "cursor": "not-allowed"
                    });

                }

            }
        );

    });


    $("#LikeForm").submit(function (e) {

        e.preventDefault();

        var recipeID = $("#LikeRecipeID").val();

        $.post(
            "toggle_like.php",
            { recipe_id: recipeID },

            function (response) {

                if (response == "true") {

                    $("#LikeBtn").prop("disabled", true);

                    $("#LikeBtn").css({
                        "background-color": "#cccccc",
                        "color": "#666666",
                        "cursor": "not-allowed"
                    });

                }

            }
        );

    });


    $("#ReportForm").submit(function (e) {

        e.preventDefault();

        var recipeID = $("#ReportRecipeID").val();

        $.post(
            "report_recipe.php",
            { recipe_id: recipeID },

            function (response) {

                if (response == "true") {

                    $("#ReportBtn").prop("disabled", true);

                    $("#ReportBtn").css({
                        "background-color": "#cccccc",
                        "color": "#666666",
                        "cursor": "not-allowed"
                    });

                }

            }
        );

    });

});