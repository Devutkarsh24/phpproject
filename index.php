<?php include "sidebar.php"; ?>
 <!DOCTYPE html>
<html>
<head>
    <title>Image Upload to ImageKit with Preview & SweetAlert</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        #preview {
            display: none;
            margin-top: 10px;
            max-width: 250px;
        }
        .loading {
            background-color: #ccc;
            cursor: not-allowed;
        }
        .spinner {
            border: 3px solid #f3f3f3;
            border-top: 3px solid #3498db;
            border-radius: 50%;
            width: 16px;
            height: 16px;
            animation: spin 1s linear infinite;
            display: inline-block;
            vertical-align: middle;
            margin-left: 8px;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body>
    <h2>Upload Image to ImageKit</h2>
    <form id="uploadForm" enctype="multipart/form-data">
        <input type="file" name="image" id="image" accept="image/*" required>
        <br><br>
        <img id="preview" src="#" alt="Preview">
        <br><br>
        <button type="submit" id="uploadBtn">Upload</button>
    </form>

    <script>
        // Show preview
        $("#image").change(function () {
            let reader = new FileReader();
            reader.onload = function (e) {
                $("#preview").attr("src", e.target.result).fadeIn();
            }
            reader.readAsDataURL(this.files[0]);
        });

        // AJAX Upload
        $("#uploadForm").on("submit", function (e) {
            e.preventDefault();
            let formData = new FormData(this);

            // Disable button + show loader
            $("#uploadBtn")
                .prop("disabled", true)
                .addClass("loading")
                .html(`Uploading <span class="spinner"></span>`);

            $.ajax({
                url: "upload.php",
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: function (res) {
                    if (res.status === "success") {
                        Swal.fire({
                            icon: "success",
                            title: res.message,
                            // footer: `<a href="${res.url}" target="_blank">${res.url}</a>`,
                            showConfirmButton: true
                        });
                        $("#uploadForm")[0].reset();
                        $("#preview").fadeOut();
                    } else {
                        Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            text: res.message
                        });
                    }
                },
                error: function () {
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        text: "Something went wrong!"
                    });
                },
                complete: function () {
                    // Re-enable button
                    $("#uploadBtn")
                        .prop("disabled", false)
                        .removeClass("loading")
                        .text("Upload");
                }
            });
        });
    </script>
</body>
</html>
