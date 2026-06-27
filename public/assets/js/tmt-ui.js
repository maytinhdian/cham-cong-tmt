"use strict";

(function () {
    function scheduleAttendanceTabSync(nav, link) {
        window.requestAnimationFrame(function () {
            syncAttendanceTab(nav, link);
        });

        window.setTimeout(function () {
            syncAttendanceTab(nav, link);
        }, 140);
    }

    function syncAttendanceTab(nav, link) {
        if (!nav || !link) {
            return;
        }

        var item = link.closest(".nav-item");
        var movingTab = nav.querySelector(".moving-tab");

        if (!item) {
            return;
        }

        if (!movingTab) {
            movingTab = document.createElement("div");
            movingTab.className = "moving-tab position-absolute nav-link";
            movingTab.style.padding = "0px";
            movingTab.innerHTML = '<a class="nav-link mb-0 px-0 py-1 active">-</a>';
            nav.appendChild(movingTab);
        }

        if (nav.classList.contains("flex-column")) {
            movingTab.style.width = item.offsetWidth + "px";
            movingTab.style.height = item.offsetHeight + "px";
            movingTab.style.transform = "translate3d(0px, " + item.offsetTop + "px, 0px)";
            return;
        }

        movingTab.style.width = item.offsetWidth + "px";
        movingTab.style.height = item.offsetHeight + "px";
        movingTab.style.transform = "translate3d(" + item.offsetLeft + "px, 0px, 0px)";
    }

    function initAttendanceTabs() {
        document.querySelectorAll(".attendance-settings-tabs .nav.nav-pills").forEach(function (nav) {
            var activeLink = nav.querySelector(".nav-link.active");

            scheduleAttendanceTabSync(nav, activeLink);

            if (nav.dataset.attendanceTabsBound === "true") {
                return;
            }

            nav.dataset.attendanceTabsBound = "true";

            nav.querySelectorAll('[data-bs-toggle="tab"]').forEach(function (link) {
                link.addEventListener("click", function () {
                    scheduleAttendanceTabSync(nav, link);
                });

                link.addEventListener("shown.bs.tab", function () {
                    scheduleAttendanceTabSync(nav, link);
                });
            });
        });
    }

    function delayedInitAttendanceTabs() {
        window.setTimeout(initAttendanceTabs, 180);
    }

    document.addEventListener("DOMContentLoaded", delayedInitAttendanceTabs);
    document.addEventListener("livewire:navigated", delayedInitAttendanceTabs);

    window.addEventListener("resize", function () {
        document.querySelectorAll(".attendance-settings-tabs .nav.nav-pills").forEach(function (nav) {
            scheduleAttendanceTabSync(nav, nav.querySelector(".nav-link.active"));
        });
    });
})();
