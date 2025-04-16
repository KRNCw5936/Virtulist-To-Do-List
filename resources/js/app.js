import './bootstrap';
import Sortable from 'sortablejs';
import $ from 'jquery';

$(document).ready(function () {
    $(".task-container").each(function () {
        new Sortable(this, {
            group: "tasks",
            animation: 150,
            onEnd: function (evt) {
                let taskId = evt.item.dataset.id;
                if (!taskId) {
                    console.error("taskId tidak ditemukan!");
                    return;
                }

                // Mencari elemen .task-container yang benar
                let taskListElement = evt.to.closest(".task-container");
                if (!taskListElement) {
                    console.error("Elemen .task-container tidak ditemukan!");
                    return;
                }

                // Ambil data-task-list-id dari task-container
                let taskListId = taskListElement.getAttribute("data-task-list-id");
                if (!taskListId) {
                    console.error("taskListId tidak ditemukan di dataset!", taskListElement);
                    return;
                }

                console.log(`Task ID: ${taskId}, Task List ID: ${taskListId}`);

                let newStatus = evt.to.id;
                let status = "";

                if (newStatus === "task-pending") {
                    status = "pending";
                } else if (newStatus === "task-progress") {
                    status = "progress";
                } else if (newStatus === "task-completed") {
                    status = "completed";
                }

                let csrfToken = document.querySelector('meta[name="csrf-token"]').content;

                fetch(`/task-lists/${taskListId}/tasks/${taskId}/update-status`, {
                    method: "PATCH",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": csrfToken
                    },
                    body: JSON.stringify({ status: status })
                })                
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! Status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    console.log("Status berhasil diperbarui:", data);
                })
                .catch(error => console.error("Terjadi kesalahan:", error));
            }
        });
    });
});
