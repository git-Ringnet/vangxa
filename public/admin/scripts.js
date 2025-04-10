$("#sidebarCollapse").on("click", function () {
    $("#sidebar").toggleClass("active");
});
setTimeout(function () {
    $(".alert").alert("close");
}, 3000);
