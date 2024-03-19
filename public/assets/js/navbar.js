const currentRoute = location.href,
    links = document.querySelectorAll(".nav-link, .dropdown-item");
let list;
links.forEach((link) => {
    if (link.href === currentRoute) {
        if (link.classList.contains("dropdown-item")) {
            list=link.closest("li.dropdown").querySelector(".dropdown-toggle");
            link.classList.add("active");
        }else list = link.closest("a.nav-link");
        list.classList.add("active");
    }
});
