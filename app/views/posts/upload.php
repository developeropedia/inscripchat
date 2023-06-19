<?php

include APPROOT . "/views/inc/header.php";
include APPROOT . "/views/inc/nav.php";

$postObj = new Post;

if (isset($_POST['title'])) {
    $title = $_POST['title'];
    $tags = $_POST['tags'];
    $file = $_POST['file'];
    $type = pathinfo($file, PATHINFO_EXTENSION);

    if ($type == "pdf") {
        $type = "pdf";
    } else {
        $type = "image";
    }

    $postObj->addPost(0, $title, $file, $type, $tags);
    flash("post_added", "Post has been added successfully");
    redirect("posts");
}

?>

<main>
    <div class="container h-100 ">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="sign-heading  text-center mt-4">Upload</h1>
            </div>
        </div>
        <form action="" class="row upload-post-form" method="post">

            <div class="col-lg-6 h-100 d-flex flex-column justify-content-center mt-3 order-last order-lg-first">
                <div class="sign-content">

                    <div class="mb-4">
                        <input type="text" id="title" name="title" class="sign-input" placeholder="Title">
                    </div>
                    <div class="mb-4">
                        <small>Enter comma separated tags (tag1,tag2,tag3)</small>
                        <input type="text" id="tags" name="tags" class="sign-input" placeholder="Tags">
                    </div>

                    <div class="d-flex align-items-center justify-content-center flex-wrap">
                        <div class="thumbnail">
                            <img id="img_preview" src="" alt="">
                        </div>
                    </div>
                    <input type="hidden" name="file" id="uploadedFile">

                </div>
            </div>
            <div class="col-lg-6 order-first order-lg-last  d-flex flex-column justify-content-center  ">

                <div class="img-zone text-center" id="img-zone">
                    <div class="img-drop">
                        <h2 class="text-primary">Upload file</h2>

                        <span class=" btn-file d-flex align-items-center text-center justify-content-center">
                            Drag file here or <div class="text-primary"> &nbsp; browse</div><input type="file" accept="image/jpg, image/jpeg, image/png, application/pdf">
                        </span>
                        <p class="f-12 w-400">Supported file types: JPG, JPEG, PNG, PDF</p>
                    </div>
                </div>
                <div class="progress hidden">
                    <div style="width: 0%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="0" role="progressbar" class="progress-bar  active">
                        <span class="sr-only progress-status">0% Complete</span>
                    </div>
                </div>
                <div class="d-flex justify-content-center mt-5">
                    <button id="submitBtn" type="button" name="save" class="btn px-5 successfull-btn">Save</button>
                </div>


            </div>

        </form>
    </div>

</main>

<?php

include APPROOT . "/views/inc/footer.php";

?>

<script>
    const appURL = "<?php echo URLROOT; ?>";

    jQuery(document).ready(function() {
        var img_zone = document.getElementById('img-zone'),
            collect = {
                filereader: typeof FileReader != 'undefined',
                zone: 'draggable' in document.createElement('span'),
                formdata: !!window.FormData
            },
            acceptedTypes = {
                'image/png': true,
                'image/jpeg': true,
                'image/jpg': true,
                'image/gif': true,
                'application/pdf': true
            };

        // Function to show messages
        function ajax_msg(status, msg) {
            var the_msg = '<div class="alert p-1 px-3 alert-' + (status ? 'success' : 'danger') + '">';
            the_msg += msg;
            the_msg += '</div>';
            $(the_msg).insertBefore(img_zone);
        }

        // Function to upload image or PDF through AJAX
        function ajax_upload(files) {
            $('#img_preview').attr("src", "")
            $("#uploadedFile").val("")

            var maxSize = 10 * 1024 * 1024; // 10MB (in bytes)
            var totalSize = 0;

            // Calculate the total size of all files
            for (var i = 0; i < files.length; i++) {
                totalSize += files[i].size;
            }

            // Check if total size exceeds the maximum size
            if (totalSize > maxSize) {
                ajax_msg(false, 'File size exceeds the maximum limit of 10MB.');
                return;
            }

            $('.progress').removeClass('hidden');
            $('.progress-bar').css({
                "width": "0%"
            });
            $('.progress-bar span').html('0% complete');

            var formData = new FormData();
            for (var i = 0; i < files.length; i++) {
                if (!acceptedTypes[files[i].type]) {
                    ajax_msg(false, 'Unsupported file type');
                    return;
                }

                formData.append('img_file[]', files[i]);
            }

            $.ajax({
                url: appURL + "/posts/uploadPost", // Change name according to your PHP script to handle uploading on the server
                type: 'post',
                data: formData,
                dataType: 'json',
                processData: false,
                contentType: false,
                success: function(json) {
                    $('.progress').addClass('hidden');
                    $('#img_preview').attr("src", appURL + "/public/uploads/" + json.img)
                    $("#uploadedFile").val(json.file)
                    if (json.error != '')
                        ajax_msg(false, json.error);
                },
                progress: function(e) {
                    if (e.lengthComputable) {
                        var pct = (e.loaded / e.total) * 100;
                        $('.progress-bar').css({
                            "width": pct + "%"
                        });
                        $('.progress-bar span').html(pct + '% complete');
                    } else {
                        console.warn('Content Length not reported!');
                    }
                }
            });
        }

        // Call AJAX upload function on drag and drop event
        function dragHandle(element) {
            element.ondragover = function() {
                return false;
            };
            element.ondragend = function() {
                return false;
            };
            element.ondrop = function(e) {
                e.preventDefault();
                ajax_upload(e.dataTransfer.files);
            }
        }

        if (collect.zone) {
            dragHandle(img_zone);
        } else {
            alert("Drag & Drop isn't supported, use Open File Browser to upload photos.");
        }

        // Call AJAX upload function on image selection using file browser button
        $(document).on('change', '.btn-file :file', function() {
            ajax_upload(this.files);
        });

        // File upload progress event listener
        (function($, window, undefined) {
            var hasOnProgress = ("onprogress" in $.ajaxSettings.xhr());

            if (!hasOnProgress) {
                return;
            }

            var oldXHR = $.ajaxSettings.xhr;
            $.ajaxSettings.xhr = function() {
                var xhr = oldXHR();
                if (xhr instanceof window.XMLHttpRequest) {
                    xhr.addEventListener('progress', this.progress, false);
                }

                if (xhr.upload) {
                    xhr.upload.addEventListener('progress', this.progress, false);
                }

                return xhr;
            };
        })(jQuery, window);
    });
</script>

<script>
    $("#submitBtn").click(function(e) {
        e.preventDefault();

        var title = $("#title").val()
        var tags = $("#tags").val()
        var uploadedFile = $("#uploadedFile").val()

        if (title == "" || tags == "" || uploadedFile == "") {
            alert("Please fill all the fields")
            return;
        }

        $(".upload-post-form").submit()
    })
</script>