$(function () {
    $("#opslaan").click(function () {
        var fields = $("form").serialize();
        $.post("/admin/editCategorieVerwerk.php", fields).done(function () {
            if (a == "true") {
                alert("Succesvol opgeslagen");
            } else {
                alert("Er is een fout opgetreden");
            }
        }).fail(function () {
            alert("Er is een fout opgetreden");
        });
    });
});
