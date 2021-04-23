$(document).ready(function () {
    var files = [];
    //Functions
    function toggle_menu() {
        $(".menu_btn").toggleClass("change");
        $(".menu").toggleClass("open");
    }

    function expand_file() {
        let target = $(this).parent().parent();
        if (target.hasClass("expanded")) {//clicking on opened file
            target.toggleClass("expanded");
        } else {
            $(".expanded").removeClass("expanded");
            target.toggleClass("expanded");
        }
    }

    function get_server_info() {
        $.ajax({
            type: "GET",
            url: "utils/get_server_info.php",
            // data: { h: "michael" }, //pass data to php file
            dataType: "json",
            success: function (response) {//return data from php file
                $(".server_temp b").html(response.temp);
                $(".server_since b").html(response.uptime);
            },
            error: function (xhr, textStatus, error) {
                console.log(xhr.statusText + " " + textStatus + " " + error);
            }
        });
    }

    function get_cloud_storage() {
        $.ajax({
            type: "GET",
            url: "utils/get_cloud_info.php",
            dataType: "json",
            success: function (response) {
                if (response.ls != undefined) {
                    files = response.ls.split("\n");
                } else {
                    files = [];
                }
                display_files();

            },
            error: function (xhr, textStatus, error) {
                console.log(xhr.statusText + " " + textStatus + " " + error);
            }
        });
    }

    function display_files() {
        let target = $(".files_list");
        target.empty();//empty list
        for (let i = 0; i < files.length; i += 2) {
            if (files[i] === "") continue;
            target.append("<div class='file'><div class='details'><p class='name'>" + files[i + 1] + "</p><p class='size'>" + (files[i] / 1000) + "KBs</p><p class='date'>Sat 14:54</p></div><div class='actions'><i class='fas fa-download download'></i><i class='fas fa-trash-alt delete'></i><i class='fas fa-chevron-circle-down expand'></i></div><div class='extra_details'><p class='uploaded_by'>Uploaded by reznik99</p></div></div>");
        }
        //add top and bottom
        target.prepend("<div class='file example'><div class='details'><p class='name'>name</p><p class='size'>size</p><p class='date'>date uploaded</p></div><div class='actions'><p>Actions</p></div></div>");
        target.append("<div class='upload_file_button'><i class='fas fa-file-upload upload'></i></div>");
    }

    function download_file() {
        let target = $(this).parent().parent();
        let file_name = target.find(".name").text();
        window.location = "utils/file_download.php?filename=" + encodeURIComponent(file_name);
    }

    function toggle_upload_menu() {
        $(".upload_file_div").toggleClass("visible_upload_file_div");
        $(".div_to_close_upload_div").toggleClass("visible_upload_file_div");
    }

    function delete_file() {
        let file_name = $(this).parent().parent().find(".name").text();
        console.log('deleting ' + file_name);
        window.location = "utils/file_delete.php?filename=" + encodeURIComponent(file_name);
    }

    function on_mobile() {
        return window.innerWidth <= 600;
    }

    //Listeners
    $(document).on("click", ".menu_btn", toggle_menu);
    //actions
    $(document).on("click", ".download", download_file);
    $(document).on("click", ".delete", delete_file);
    $(document).on("click", ".expand", expand_file);
    //upload file
    $(document).on("click", ".upload_file_button", toggle_upload_menu);
    $(document).on("click", ".div_to_close_upload_div", toggle_upload_menu);

    //update server info display
    window.setInterval(function () {
        get_server_info();
    }, 60000);

    //load page variables
    get_server_info();
    get_cloud_storage();//temp
    if (!on_mobile()) {
        $(".menu_btn").click();//start with menu open
    }
});
